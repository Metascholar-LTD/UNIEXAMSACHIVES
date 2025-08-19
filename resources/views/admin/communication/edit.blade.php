@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<div class="dashboardarea sp_bottom_100">
    <div class="container-fluid full__width__padding">
        <div class="row">
            @include('components.create_section')
        </div>
    </div>
    <div class="dashboard">
        <div class="container-fluid full__width__padding">
            <div class="row">
                @include('components.sidebar')

                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>Edit Email</h4>
                            <div class="dashboard__section__actions">
                                <a href="{{route('admin.communication.show', $campaign)}}" class="default__button">
                                    <i class="icofont-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.communication.update', $campaign) }}" enctype="multipart/form-data" id="emailForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="dashboard__form__wraper">
                                        

                                        <div class="dashboard__form__input">
                                            <label for="subject">Email Subject <span class="required">*</span></label>
                                            <input type="text" id="subject" name="subject" 
                                                   placeholder="Enter email subject" 
                                                   value="{{ old('subject', $campaign->subject) }}" required>
                                            <small class="form-text text-muted">This will be the email subject line users see</small>
                                        </div>

                                        <div class="dashboard__form__input">
                                            <label for="message">Email Message <span class="required">*</span></label>
                                            <textarea id="message" name="message" rows="12" 
                                                      placeholder="Enter your email message..." required>{{ old('message', $campaign->message) }}</textarea>
                                            <small class="form-text text-muted">HTML formatting is supported</small>
                                        </div>

                                        <!-- Existing Attachments -->
                                        @if($campaign->attachments && count($campaign->attachments) > 0)
                                            <div class="dashboard__form__input">
                                                <label>Current Attachments</label>
                                                <div class="existing-attachments">
                                                    @foreach($campaign->attachments as $index => $attachment)
                                                        <div class="attachment-item" id="attachment-{{ $index }}">
                                                            <div class="attachment-info">
                                                                <i class="icofont-file-alt"></i>
                                                                <span class="attachment-name">{{ $attachment['name'] }}</span>
                                                                <span class="attachment-size">({{ number_format($attachment['size'] / 1024, 1) }} KB)</span>
                                                            </div>
                                                            <div class="attachment-actions">
                                                                <a href="{{ route('admin.communication.download-attachment', [$campaign, $index]) }}" 
                                                                   class="btn btn-sm btn-primary">
                                                                    <i class="icofont-download"></i>
                                                                </a>
                                                                <button type="button" class="btn btn-sm btn-danger" 
                                                                        onclick="removeExistingAttachment({{ $index }})">
                                                                    <i class="icofont-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- New Attachments -->
                                        <div class="dashboard__form__input">
                                            <label for="attachments">Add New Attachments</label>
                                            <div class="file-upload-area">
                                                <input type="file" id="attachments" name="attachments[]" 
                                                       multiple accept=".pdf,.doc,.docx,.txt,.jpg,.png,.gif,.zip"
                                                       class="file-input">
                                                <div class="file-upload-display">
                                                    <div class="file-upload-icon">
                                                        <i class="icofont-attachment"></i>
                                                    </div>
                                                    <div class="file-upload-text">
                                                        <strong>Click to upload files</strong> or drag and drop
                                                        <br><small>Supported: PDF, DOC, DOCX, TXT, JPG, PNG, GIF, ZIP (Max: 10MB each)</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="file-list" class="file-list mt-3"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="dashboard__form__wraper">
                                        <h5><i class="icofont-users"></i> Recipients</h5>
                                        
                                        <div class="recipient-options">
                                            <div class="recipient-option-card" data-option="all">
                                                <div class="option-header">
                                                    <div class="option-icon">
                                                        <i class="icofont-users-alt-3"></i>
                                                    </div>
                                                    <div class="option-content">
                                                        <h6 class="option-title">All Registered Users</h6>
                                                        <p class="option-description">Send to all approved users</p>
                                                        <span class="user-count">{{ $users->count() }} users</span>
                                                    </div>
                                                    <div class="option-radio">
                                                        <input class="form-check-input" type="radio" name="recipient_type" 
                                                               id="all_users" value="all" 
                                                               {{ old('recipient_type', $campaign->recipient_type) === 'all' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="recipient-option-card" data-option="selected">
                                                <div class="option-header">
                                                    <div class="option-icon">
                                                        <i class="icofont-user-alt-3"></i>
                                                    </div>
                                                    <div class="option-content">
                                                        <h6 class="option-title">Selected Users</h6>
                                                        <p class="option-description">Choose specific users to send to</p>
                                                        <span class="user-count" id="selected-count">{{ count($campaign->selected_users ?? []) }} users</span>
                                                    </div>
                                                    <div class="option-radio">
                                                        <input class="form-check-input" type="radio" name="recipient_type" 
                                                               id="selected_users" value="selected"
                                                               {{ old('recipient_type', $campaign->recipient_type) === 'selected' ? 'checked' : '' }}>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Advanced User Selector -->
                                        <div id="user-selector" class="user-selector mt-4" style="display: {{ old('recipient_type', $campaign->recipient_type) === 'selected' ? 'block' : 'none' }};">
                                            <div class="selector-header">
                                                <h6><i class="icofont-search-1"></i> Search & Select Users</h6>
                                                <div class="selector-stats">
                                                    <span class="selected-indicator" id="selected-indicator">{{ count($campaign->selected_users ?? []) }} selected</span>
                                                </div>
                                            </div>
                                            
                                            <!-- Search Bar -->
                                            <div class="search-container">
                                                <div class="search-input-wrapper">
                                                    <i class="icofont-search-1 search-icon"></i>
                                                    <input type="text" id="userSearch" placeholder="Search users by name or email..." 
                                                           class="search-input">
                                                    <div class="search-clear" id="searchClear" style="display: none;">
                                                        <i class="icofont-close"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- User List Container -->
                                            <div class="user-list-container">
                                                <div class="user-list-header">
                                                    <div class="select-all-wrapper">
                                                        <input type="checkbox" id="selectAllUsers" class="select-all-checkbox">
                                                        <label for="selectAllUsers">Select All Visible</label>
                                                    </div>
                                                    <div class="filter-tabs">
                                                        <button type="button" class="filter-tab active" data-filter="all">All</button>
                                                        <button type="button" class="filter-tab" data-filter="recent">Recent</button>
                                                        <button type="button" class="filter-tab" data-filter="active">Active</button>
                                                    </div>
                                                </div>
                                                
                                                <div class="user-list" id="userList">
                                                    @foreach($users as $user)
                                                        <div class="user-item" data-user-id="{{ $user->id }}" data-name="{{ strtolower($user->first_name . ' ' . $user->last_name) }}" data-email="{{ strtolower($user->email) }}">
                                                            <div class="user-checkbox">
                                                                <input type="checkbox" name="selected_users[]" value="{{ $user->id }}" 
                                                                       class="user-select-checkbox"
                                                                       {{ in_array($user->id, old('selected_users', $campaign->selected_users ?? [])) ? 'checked' : '' }}>
                                                            </div>
                                                            <div class="user-avatar">
                                                                @if($user->profile_picture)
                                                                    <img src="{{ Storage::url($user->profile_picture) }}" alt="{{ $user->first_name }}" onerror="this.src='/img/dashbord/profile.png'">
                                                                @else
                                                                    <img src="/img/dashbord/profile.png" alt="{{ $user->first_name }}">
                                                                @endif
                                                            </div>
                                                            <div class="user-info">
                                                                <div class="user-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                                <div class="user-email">{{ $user->email }}</div>
                                                                <div class="user-meta">
                                                                    <span class="user-status active">Active</span>
                                                                    <span class="user-joined">Joined {{ $user->created_at->diffForHumans() }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="user-actions">
                                                                <button type="button" class="btn-quick-select" title="Quick Select">
                                                                    <i class="icofont-plus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                
                                                <div class="user-list-footer">
                                                    <div class="list-info">
                                                        <span id="visibleCount">{{ $users->count() }}</span> users visible
                                                    </div>
                                                    <div class="list-actions">
                                                        <button type="button" class="btn-clear-selection" id="clearSelection">Clear Selection</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="icofont-save"></i> Update Email
                                            </button>
                                            <a href="{{ route('admin.communication.show', $campaign) }}" 
                                               class="btn btn-secondary btn-block">
                                                <i class="icofont-close"></i> Cancel
                                            </a>
                                        </div>

                                        <div class="email-preview mt-3">
                                            <h6><i class="icofont-eye"></i> Preview</h6>
                                            <div class="preview-card">
                                                <div class="preview-subject" id="preview-subject">{{ $campaign->subject }}</div>
                                                <div class="preview-message" id="preview-message">{{ Str::limit($campaign->message, 200) }}</div>
                                                <div class="preview-recipients" id="preview-recipients">
                                                    Recipients: {{ $campaign->recipient_type === 'all' ? 'All users' : count($campaign->selected_users ?? []) . ' selected users' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.required { color: #e74c3c; }

/* Professional Recipient Selection Styling */
.recipient-options {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.recipient-option-card {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    border: 2px solid #e9ecef;
    border-radius: 16px;
    padding: 20px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.recipient-option-card:hover {
    border-color: #007bff;
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.15);
    transform: translateY(-2px);
}

.recipient-option-card[data-option="all"]:hover {
    border-color: #28a745;
    box-shadow: 0 8px 25px rgba(40, 167, 69, 0.15);
}

.recipient-option-card[data-option="selected"]:hover {
    border-color: #ffc107;
    box-shadow: 0 8px 25px rgba(255, 193, 7, 0.15);
}

.recipient-option-card input[type="radio"]:checked + .option-header {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
}

.recipient-option-card input[type="radio"]:checked ~ .option-header .option-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.recipient-option-card input[type="radio"]:checked ~ .option-header .user-count {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.option-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 8px;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.option-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.recipient-option-card[data-option="all"] .option-icon {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
}

.recipient-option-card[data-option="selected"] .option-icon {
    background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%);
}

.option-content {
    flex: 1;
    min-width: 0;
}

.option-title {
    font-size: 16px;
    font-weight: 600;
    margin: 0 0 4px 0;
    color: #2c3e50;
}

.option-description {
    font-size: 14px;
    color: #6c757d;
    margin: 0 0 8px 0;
    line-height: 1.4;
}

.user-count {
    display: inline-block;
    background: #e9ecef;
    color: #495057;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.option-radio {
    flex-shrink: 0;
}

.option-radio input[type="radio"] {
    width: 20px;
    height: 20px;
    accent-color: #007bff;
}

/* Advanced User Selector */
.user-selector {
    background: #ffffff;
    border: 2px solid #e9ecef;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.selector-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 16px;
    border-bottom: 2px solid #f8f9fa;
}

.selector-header h6 {
    margin: 0;
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    display: flex;
    align-items: center;
    gap: 8px;
}

.selected-indicator {
    background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
    color: white;
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Search Container */
.search-container {
    margin-bottom: 20px;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 16px;
    color: #6c757d;
    font-size: 16px;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 14px 16px 14px 48px;
    border: 2px solid #e9ecef;
    border-radius: 12px;
    font-size: 14px;
    transition: all 0.3s ease;
    background: #f8f9fa;
}

.search-input:focus {
    outline: none;
    border-color: #007bff;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
}

.search-clear {
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    width: 20px;
    height: 20px;
    background: #6c757d;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 12px;
    transition: all 0.3s ease;
}

.search-clear:hover {
    background: #495057;
    transform: translateY(-50%) scale(1.1);
}

/* User List Container */
.user-list-container {
    background: #f8f9fa;
    border-radius: 12px;
    overflow: hidden;
}

.user-list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #ffffff;
    border-bottom: 1px solid #e9ecef;
}

.select-all-wrapper {
    display: flex;
    align-items: center;
    gap: 8px;
}

.select-all-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #007bff;
}

.select-all-wrapper label {
    font-size: 14px;
    font-weight: 500;
    color: #495057;
    margin: 0;
    cursor: pointer;
}

.filter-tabs {
    display: flex;
    gap: 8px;
}

.filter-tab {
    padding: 6px 16px;
    border: 1px solid #e9ecef;
    background: #ffffff;
    color: #6c757d;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.filter-tab:hover {
    border-color: #007bff;
    color: #007bff;
}

.filter-tab.active {
    background: #007bff;
    color: white;
    border-color: #007bff;
}

/* User List */
.user-list {
    max-height: 400px;
    overflow-y: auto;
    padding: 0;
}

.user-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    background: #ffffff;
    border-bottom: 1px solid #f8f9fa;
    transition: all 0.3s ease;
    cursor: pointer;
}

.user-item:hover {
    background: #f8f9fa;
    transform: translateX(4px);
}

.user-item.selected {
    background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
    border-left: 4px solid #007bff;
}

.user-checkbox {
    flex-shrink: 0;
}

.user-select-checkbox {
    width: 18px;
    height: 18px;
    accent-color: #007bff;
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    overflow: hidden;
    flex-shrink: 0;
    border: 3px solid #e9ecef;
    transition: all 0.3s ease;
}

.user-item:hover .user-avatar {
    border-color: #007bff;
    transform: scale(1.05);
}

.user-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-size: 16px;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 4px 0;
    line-height: 1.2;
}

.user-email {
    font-size: 14px;
    color: #6c757d;
    margin: 0 0 8px 0;
    line-height: 1.2;
    word-break: break-word;
}

.user-meta {
    display: flex;
    align-items: center;
    gap: 12px;
}

.user-status {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.user-status.active {
    background: #d4edda;
    color: #155724;
}

.user-joined {
    font-size: 12px;
    color: #6c757d;
}

.user-actions {
    flex-shrink: 0;
}

.btn-quick-select {
    width: 32px;
    height: 32px;
    border: 2px solid #e9ecef;
    background: #ffffff;
    color: #6c757d;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 14px;
}

.btn-quick-select:hover {
    border-color: #007bff;
    color: #007bff;
    background: #f8f9fa;
    transform: scale(1.1);
}

/* User List Footer */
.user-list-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #ffffff;
    border-top: 1px solid #e9ecef;
}

.list-info {
    font-size: 14px;
    color: #6c757d;
}

.list-info span {
    font-weight: 600;
    color: #007bff;
}

.btn-clear-selection {
    padding: 8px 16px;
    border: 1px solid #dc3545;
    background: #ffffff;
    color: #dc3545;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-clear-selection:hover {
    background: #dc3545;
    color: #ffffff;
    transform: translateY(-1px);
}

/* Responsive Design */
@media (max-width: 768px) {
    .recipient-option-card {
        padding: 16px;
    }
    
    .option-header {
        gap: 12px;
    }
    
    .option-icon {
        width: 40px;
        height: 40px;
        font-size: 18px;
    }
    
    .user-selector {
        padding: 16px;
    }
    
    .selector-header {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
    }
    
    .user-list-header {
        flex-direction: column;
        gap: 12px;
        align-items: flex-start;
    }
    
    .filter-tabs {
        width: 100%;
        justify-content: space-between;
    }
    
    .user-item {
        padding: 12px 16px;
        gap: 12px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
    }
    
    .user-name {
        font-size: 14px;
    }
    
    .user-email {
        font-size: 12px;
    }
    
    .user-meta {
        flex-direction: column;
        gap: 4px;
        align-items: flex-start;
    }
}

.existing-attachments {
    margin-bottom: 20px;
}

.attachment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    margin-bottom: 10px;
}

.attachment-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.attachment-name {
    font-weight: 600;
}

.attachment-size {
    color: #6c757d;
    font-size: 12px;
}

.attachment-actions {
    display: flex;
    gap: 5px;
}

.recipient-options .form-check {
    margin-bottom: 15px;
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.recipient-options .form-check:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.recipient-options .form-check-input:checked + .form-check-label {
    color: #007bff;
}

.user-selector {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.user-select {
    height: 200px;
    border-radius: 5px;
}

.file-upload-area {
    position: relative;
    border: 2px dashed #ddd;
    border-radius: 8px;
    padding: 30px;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
}

.file-upload-area:hover {
    border-color: #007bff;
    background-color: #f8f9fa;
}

.file-upload-area.dragover {
    border-color: #007bff;
    background-color: #e3f2fd;
}

.file-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

.file-upload-icon {
    font-size: 48px;
    color: #6c757d;
    margin-bottom: 10px;
}

.file-list {
    max-height: 200px;
    overflow-y: auto;
}

.file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    border: 1px solid #e9ecef;
    border-radius: 5px;
    margin-bottom: 5px;
    background: #f8f9fa;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 10px;
}

.file-size {
    font-size: 12px;
    color: #6c757d;
}

.preview-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    padding: 15px;
    font-size: 14px;
}

.preview-subject {
    font-weight: bold;
    margin-bottom: 10px;
    color: #495057;
}

.preview-message {
    margin-bottom: 10px;
    color: #6c757d;
    max-height: 100px;
    overflow-y: auto;
}

.preview-recipients {
    font-size: 12px;
    color: #28a745;
    font-weight: bold;
}

.form-actions button {
    margin-bottom: 10px;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientRadios = document.querySelectorAll('input[name="recipient_type"]');
    const userSelector = document.getElementById('user-selector');
    const selectedUsersList = document.getElementById('selected_users_list');
    
    const subjectInput = document.getElementById('subject');
    const messageInput = document.getElementById('message');
    const previewSubject = document.getElementById('preview-subject');
    const previewMessage = document.getElementById('preview-message');
    const previewRecipients = document.getElementById('preview-recipients');
    
    // Handle recipient type changes
    recipientRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'selected') {
                userSelector.style.display = 'block';
                selectedUsersList.required = true;
                updatePreview();
            } else {
                userSelector.style.display = 'none';
                selectedUsersList.required = false;
                updatePreview();
            }
        });
    });
    
    // Handle file uploads
    const fileInput = document.getElementById('attachments');
    const fileList = document.getElementById('file-list');
    const fileUploadArea = document.querySelector('.file-upload-area');
    
    fileInput.addEventListener('change', handleFileSelect);
    
    // Drag and drop functionality
    fileUploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('dragover');
    });
    
    fileUploadArea.addEventListener('dragleave', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
    });
    
    fileUploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('dragover');
        fileInput.files = e.dataTransfer.files;
        handleFileSelect();
    });
    
    function handleFileSelect() {
        fileList.innerHTML = '';
        Array.from(fileInput.files).forEach((file, index) => {
            const fileItem = document.createElement('div');
            fileItem.className = 'file-item';
            fileItem.innerHTML = `
                <div class="file-info">
                    <i class="icofont-file-alt"></i>
                    <span>${file.name}</span>
                    <span class="file-size">(${formatFileSize(file.size)})</span>
                </div>
                <button type="button" class="btn btn-sm btn-danger" onclick="removeFile(${index})">
                    <i class="icofont-close"></i>
                </button>
            `;
            fileList.appendChild(fileItem);
        });
    }
    
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
    
    // Preview functionality
    function updatePreview() {
        const subject = subjectInput.value || 'Subject will appear here';
        const message = messageInput.value || 'Message preview will appear here';
        
        previewSubject.textContent = subject;
        previewMessage.innerHTML = message.substring(0, 200) + (message.length > 200 ? '...' : '');
        
        const recipientType = document.querySelector('input[name="recipient_type"]:checked').value;
        if (recipientType === 'all') {
            previewRecipients.textContent = `Recipients: All users ({{ $users->count() }} users)`;
        } else {
            const selectedCount = selectedUsersList.selectedOptions.length;
            previewRecipients.textContent = `Recipients: ${selectedCount} selected users`;
        }
    }
    
    subjectInput.addEventListener('input', updatePreview);
    messageInput.addEventListener('input', updatePreview);
    selectedUsersList.addEventListener('change', updatePreview);
    
    // Form submission
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        // Show loading state
        e.target.querySelector('button[type="submit"]').disabled = true;
        e.target.querySelector('button[type="submit"]').innerHTML = '<i class="icofont-spinner fa-spin"></i> Updating...';
    });
    
    // Advanced User Selection Functionality
    const recipientCards = document.querySelectorAll('.recipient-option-card');
    const userSelector = document.getElementById('user-selector');
    const userSearch = document.getElementById('userSearch');
    const searchClear = document.getElementById('searchClear');
    const selectAllUsers = document.getElementById('selectAllUsers');
    const userCheckboxes = document.querySelectorAll('.user-select-checkbox');
    const clearSelection = document.getElementById('clearSelection');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const userItems = document.querySelectorAll('.user-item');
    const selectedCount = document.getElementById('selected-count');
    const selectedIndicator = document.getElementById('selected-indicator');
    const visibleCount = document.getElementById('visibleCount');
    
    let currentFilter = 'all';
    let searchTerm = '';
    
    // Recipient option selection
    recipientCards.forEach(card => {
        const radio = card.querySelector('input[type="radio"]');
        const option = card.dataset.option;
        
        card.addEventListener('click', function() {
            radio.checked = true;
            updateRecipientSelection();
        });
        
        // Update visual state when radio changes
        radio.addEventListener('change', function() {
            updateRecipientSelection();
        });
    });
    
    function updateRecipientSelection() {
        const selectedOption = document.querySelector('input[name="recipient_type"]:checked').value;
        
        if (selectedOption === 'selected') {
            userSelector.style.display = 'block';
            updateSelectedCount();
        } else {
            userSelector.style.display = 'none';
            // Clear all selections when switching to "all users"
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            updateSelectedCount();
        }
    }
    
    // Search functionality
    userSearch.addEventListener('input', function() {
        searchTerm = this.value.toLowerCase();
        filterUsers();
        
        if (searchTerm.length > 0) {
            searchClear.style.display = 'flex';
        } else {
            searchClear.style.display = 'none';
        }
    });
    
    searchClear.addEventListener('click', function() {
        userSearch.value = '';
        searchTerm = '';
        filterUsers();
        this.style.display = 'none';
    });
    
    // Filter tabs
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.dataset.filter;
            filterUsers();
        });
    });
    
    function filterUsers() {
        let visibleCount = 0;
        
        userItems.forEach(item => {
            const name = item.dataset.name;
            const email = item.dataset.email;
            const matchesSearch = !searchTerm || name.includes(searchTerm) || email.includes(searchTerm);
            
            let matchesFilter = true;
            if (currentFilter === 'recent') {
                // Show users who joined in the last 30 days
                const joinedDate = new Date(item.querySelector('.user-joined').textContent.replace('Joined ', ''));
                matchesFilter = (Date.now() - joinedDate.getTime()) < (30 * 24 * 60 * 60 * 1000);
            } else if (currentFilter === 'active') {
                // Show users with active status
                matchesFilter = item.querySelector('.user-status').textContent === 'Active';
            }
            
            if (matchesSearch && matchesFilter) {
                item.style.display = 'flex';
                visibleCount++;
            } else {
                item.style.display = 'none';
            }
        });
        
        document.getElementById('visibleCount').textContent = visibleCount;
        updateSelectAllState();
    }
    
    // Select all functionality
    selectAllUsers.addEventListener('change', function() {
        const visibleItems = Array.from(userItems).filter(item => 
            item.style.display !== 'none'
        );
        
        visibleItems.forEach(item => {
            const checkbox = item.querySelector('.user-select-checkbox');
            checkbox.checked = this.checked;
        });
        
        updateSelectedCount();
        updateUserItemStates();
    });
    
    // Individual checkbox changes
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updateUserItemStates();
            updateSelectAllState();
        });
    });
    
    // Quick select buttons
    userItems.forEach(item => {
        const quickSelectBtn = item.querySelector('.btn-quick-select');
        const checkbox = item.querySelector('.user-select-checkbox');
        
        quickSelectBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            checkbox.checked = !checkbox.checked;
            updateSelectedCount();
            updateUserItemStates();
            updateSelectAllState();
        });
        
        // Click on user item to select
        item.addEventListener('click', function(e) {
            if (e.target !== checkbox && e.target !== quickSelectBtn) {
                checkbox.checked = !checkbox.checked;
                updateSelectedCount();
                updateUserItemStates();
                updateSelectAllState();
            }
        });
    });
    
    // Clear selection
    clearSelection.addEventListener('click', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        updateSelectedCount();
        updateUserItemStates();
        updateSelectAllState();
    });
    
    function updateSelectedCount() {
        const selectedCount = userCheckboxes.filter(checkbox => checkbox.checked).length;
        document.getElementById('selected-count').textContent = selectedCount + ' users';
        document.getElementById('selected-indicator').textContent = selectedCount + ' selected';
    }
    
    function updateUserItemStates() {
        userItems.forEach(item => {
            const checkbox = item.querySelector('.user-select-checkbox');
            if (checkbox.checked) {
                item.classList.add('selected');
            } else {
                item.classList.remove('selected');
            }
        });
    }
    
    function updateSelectAllState() {
        const visibleItems = Array.from(userItems).filter(item => 
            item.style.display !== 'none'
        );
        const visibleCheckboxes = visibleItems.map(item => 
            item.querySelector('.user-select-checkbox')
        );
        const checkedCount = visibleCheckboxes.filter(checkbox => checkbox.checked).length;
        
        if (checkedCount === 0) {
            selectAllUsers.indeterminate = false;
            selectAllUsers.checked = false;
        } else if (checkedCount === visibleCheckboxes.length) {
            selectAllUsers.indeterminate = false;
            selectAllUsers.checked = true;
        } else {
            selectAllUsers.indeterminate = true;
            selectAllUsers.checked = false;
        }
    }
    
    // Initialize
    updateRecipientSelection();
    filterUsers();
});

function removeFile(index) {
    const fileInput = document.getElementById('attachments');
    const dt = new DataTransfer();
    const files = Array.from(fileInput.files);
    
    files.forEach((file, i) => {
        if (i !== index) {
            dt.items.add(file);
        }
    });
    
    fileInput.files = dt.files;
    handleFileSelect();
}

function removeExistingAttachment(index) {
    if (confirm('Are you sure you want to remove this attachment?')) {
        fetch(`{{ route('admin.communication.remove-attachment', [$campaign, '__INDEX__']) }}`.replace('__INDEX__', index), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`attachment-${index}`).remove();
            } else {
                alert('Failed to remove attachment: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to remove attachment');
        });
    }
}
</script>
@endsection