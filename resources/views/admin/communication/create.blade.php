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
                            <h4>Compose Memo</h4>
                            <div class="dashboard__section__actions">
                                <a href="{{route('admin.communication.index')}}" class="responsive-btn back-btn">
                                    <div class="svgWrapper">
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            class="svgIcon"
                                        >
                                            <path
                                                stroke="#fff"
                                                stroke-width="2"
                                                d="M19 12H5m7-7-7 7 7 7"
                                            ></path>
                                        </svg>
                                        <div class="text">Back to Memos</div>
                                    </div>
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

                        <form method="POST" action="{{ route('admin.communication.store') }}" enctype="multipart/form-data" id="emailForm">
                            @csrf
                            
                            <!-- Amazing Blinking Memo Delivery Notification -->
                            <div id="memo-delivery-notification" class="memo-notification-overlay" style="display: none;">
                                <div class="memo-notification-container">
                                    <div class="memo-notification-card">
                                        <div class="notification-icon-container">
                                            <div class="notification-icon success-icon">
                                                <i class="icofont-check-circled"></i>
                                            </div>
                                            <div class="icon-particles">
                                                <div class="particle"></div>
                                                <div class="particle"></div>
                                                <div class="particle"></div>
                                                <div class="particle"></div>
                                                <div class="particle"></div>
                                                <div class="particle"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="notification-content">
                                            <h3 class="notification-title">🎉 Memo Delivered Successfully!</h3>
                                            <p class="notification-message" id="delivery-message">
                                                Your memo has been delivered to all recipients successfully!
                                            </p>
                                            <div class="delivery-stats" id="delivery-stats">
                                                <div class="stat-item">
                                                    <span class="stat-number" id="sent-count">0</span>
                                                    <span class="stat-label">Sent</span>
                                                </div>
                                                <div class="stat-divider"></div>
                                                <div class="stat-item">
                                                    <span class="stat-number" id="total-recipients">0</span>
                                                    <span class="stat-label">Recipients</span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="notification-actions">
                                            <button type="button" class="notification-btn primary" id="view-memos-btn">
                                                <i class="icofont-eye"></i> View Memos
                                            </button>
                                            <button type="button" class="notification-btn secondary" id="close-notification-btn">
                                                <i class="icofont-close-line"></i> Close
                                            </button>
                                        </div>
                                        
                                        <div class="notification-progress">
                                            <div class="progress-bar" id="notification-progress-bar"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="compose-panel">
                                        <div class="panel-header">
                                            <h5><i class="icofont-edit"></i> Compose Your Memo</h5>
                                            <p class="panel-subtitle">Create engaging content for your audience</p>
                                        </div>

                                        <div class="form-section">
                                            <div class="form-group">
                                                <label for="subject" class="form-label">
                                                    <i class="icofont-email"></i> Memo Subject
                                                    <span class="required">*</span>
                                                </label>
                                                <input type="text" id="subject" name="subject" 
                                                       placeholder="Enter a compelling subject line..." 
                                                       value="{{ old('subject') }}" required class="form-input">
                                                <small class="form-help">This will be the memo subject line users see in their inbox</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="message" class="form-label">
                                                    <i class="icofont-chat"></i> Memo Message
                                                    <span class="required">*</span>
                                                </label>
                                                <div class="message-editor">
                                                    <div class="editor-toolbar">
                                                        <div class="toolbar-group">
                                                            <button type="button" class="toolbar-btn" data-command="bold" title="Bold (Ctrl+B)">
                                                                <i class="icofont-bold"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="italic" title="Italic (Ctrl+I)">
                                                                <i class="icofont-italic"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="underline" title="Underline (Ctrl+U)">
                                                                <i class="icofont-underline"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="strikeThrough" title="Strikethrough">
                                                                <i class="fas fa-strikethrough"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="toolbar-divider"></div>
                                                        
                                                        <div class="toolbar-group">
                                                            <button type="button" class="toolbar-btn" data-command="justifyLeft" title="Align Left">
                                                                <i class="icofont-align-left"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="justifyCenter" title="Align Center">
                                                                <i class="icofont-align-center"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="justifyRight" title="Align Right">
                                                                <i class="icofont-align-right"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="justifyFull" title="Justify">
                                                                <i class="fas fa-align-justify"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="toolbar-divider"></div>
                                                        
                                                        <div class="toolbar-group">
                                                            <button type="button" class="toolbar-btn" data-command="insertUnorderedList" title="Bullet List">
                                                                <i class="fas fa-list-ul"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="insertOrderedList" title="Numbered List">
                                                                <i class="fas fa-list-ol"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="outdent" title="Decrease Indent">
                                                                <i class="fas fa-outdent"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="indent" title="Increase Indent">
                                                                <i class="fas fa-indent"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="toolbar-divider"></div>
                                                        
                                                        <div class="toolbar-group">
                                                            <button type="button" class="toolbar-btn" data-command="createLink" title="Insert Link">
                                                                <i class="icofont-link"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="insertImage" title="Insert Image">
                                                                <i class="icofont-image"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="insertTable" title="Insert Table">
                                                                <i class="icofont-table"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="insertHorizontalRule" title="Insert Line">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="toolbar-divider"></div>
                                                        
                                                        <div class="toolbar-group">
                                                            <button type="button" class="toolbar-btn" data-command="undo" title="Undo (Ctrl+Z)">
                                                                <i class="icofont-undo"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="redo" title="Redo (Ctrl+Y)">
                                                                <i class="icofont-redo"></i>
                                                            </button>
                                                            <button type="button" class="toolbar-btn" data-command="removeFormat" title="Clear Formatting">
                                                                <i class="icofont-eraser"></i>
                                                            </button>
                                                        </div>
                                                        
                                                        <div class="toolbar-divider"></div>
                                                        
                                                        <div class="toolbar-group">
                                                            <select class="toolbar-select" id="fontSize" title="Font Size">
                                                                <option value="1">Small</option>
                                                                <option value="3" selected>Normal</option>
                                                                <option value="5">Large</option>
                                                                <option value="7">Extra Large</option>
                                                            </select>
                                                            <input type="color" class="toolbar-color" id="textColor" title="Text Color" value="#000000">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="editor-content" id="editor-content" contenteditable="true" data-placeholder="Write your message here... HTML formatting is supported">
                                                        {{ old('message') }}
                                                    </div>
                                                    
                                                    <textarea id="message" name="message" style="display: none;">{{ old('message') }}</textarea>
                                                </div>
                                                <small class="form-help">Use the toolbar above for rich text formatting. Your message will be sent as HTML.</small>
                                            </div>

                                            <div class="form-group">
                                                <label for="attachments" class="form-label">
                                                    <i class="icofont-attachment"></i> Attachments
                                                </label>
                                                <div class="file-upload-area">
                                                    <input type="file" id="attachments" name="attachments[]" 
                                                           multiple accept=".pdf,.doc,.docx,.txt,.jpg,.png,.gif,.zip"
                                                           class="file-input">
                                                    <div class="file-upload-display">
                                                        <div class="file-upload-icon">
                                                            <i class="icofont-cloud-upload"></i>
                                                        </div>
                                                        <div class="file-upload-text">
                                                            <strong>Click to upload files</strong> or drag and drop here
                                                            <br><small>Supported: PDF, DOC, DOCX, TXT, JPG, PNG, GIF, ZIP (Max: 10MB each)</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div id="file-list" class="file-list"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="compose-panel">
                                        <div class="panel-header">
                                            <h5><i class="icofont-users"></i> Recipients & Settings</h5>
                                            <p class="panel-subtitle">Configure your memo delivery options</p>
                                        </div>
                                        
                                        <div class="form-section">
                                            <div class="form-group">
                                                <label class="form-label">Recipient Selection</label>
                                                <div class="recipient-options">
                                                    <div class="option-card">
                                                        <input class="option-radio" type="radio" name="recipient_type" 
                                                               id="all_users" value="all" 
                                                               {{ old('recipient_type', 'all') === 'all' ? 'checked' : '' }}>
                                                        <label class="option-label" for="all_users">
                                                            <div class="option-icon">
                                                                <i class="icofont-users-alt-3"></i>
                                                            </div>
                                                            <div class="option-content">
                                                                <strong>All Registered Users</strong>
                                                                <span class="option-desc">Send to all approved users ({{ $users->count() }} users)</span>
                                                            </div>
                                                        </label>
                                                    </div>

                                                    <div class="option-card">
                                                        <input class="option-radio" type="radio" name="recipient_type" 
                                                               id="selected_users" value="selected"
                                                               {{ old('recipient_type') === 'selected' ? 'checked' : '' }}>
                                                        <label class="option-label" for="selected_users">
                                                            <div class="option-icon">
                                                                <i class="icofont-user-alt-4"></i>
                                                            </div>
                                                            <div class="option-content">
                                                                <strong>Selected Users</strong>
                                                                <span class="option-desc">Choose specific users to send to</span>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                        <div id="user-selector" class="user-selector" style="display: none;">
                                            <div class="user-selector-header">
                                                <div class="search-container">
                                                    <div class="search-input-wrapper">
                                                        <i class="icofont-search search-icon"></i>
                                                        <input type="text" id="user-search" 
                                                               placeholder="Search by name or email..." 
                                                               class="search-input">
                                                    </div>
                                                </div>
                                                <div class="user-stats">
                                                    <div class="stats-info">
                                                        <span class="selected-count">0</span> of <span class="total-count">{{ $users->count() }}</span> users selected
                                                    </div>
                                                    <div class="progress-bar-container">
                                                        <div class="progress-bar" id="selection-progress"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="user-list-container">
                                                <div class="user-list" id="user-list">
                                                    @foreach($users as $user)
                                                        <div class="user-item" data-user-id="{{ $user->id }}" data-search="{{ strtolower($user->first_name . ' ' . $user->last_name . ' ' . $user->email) }}">
                                                            <div class="user-avatar">
                                                                                                @if($user->profile_picture)
                                    <img src="{{ asset('profile_pictures/' . $user->profile_picture) }}" alt="{{ $user->first_name }}" class="avatar-img">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    </div>
                                @endif
                                                            </div>
                                                            <div class="user-info">
                                                                <div class="user-name">{{ $user->first_name }} {{ $user->last_name }}</div>
                                                                <div class="user-email">{{ $user->email }}</div>
                                                                <div class="user-status">
                                                                    <span class="status-indicator online"></span>
                                                                    <small>Active User</small>
                                                                </div>
                                                            </div>
                                                            <div class="user-select-checkbox">
                                                                <input type="checkbox" name="selected_users[]" 
                                                                       value="{{ $user->id }}" 
                                                                       class="user-checkbox"
                                                                       {{ in_array($user->id, old('selected_users', [])) ? 'checked' : '' }}>
                                                                <span class="checkmark"></span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            
                                            <div class="user-actions">
                                                <button type="button" class="btn btn-sm btn-outline-primary" id="select-all-btn">
                                                    <i class="icofont-check-circled"></i> Select All
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" id="clear-all-btn">
                                                    <i class="icofont-close-circled"></i> Clear All
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" id="export-selected-btn">
                                                    <i class="icofont-download"></i> Export
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Sending Options</label>
                                            <div class="sending-options">
                                                <div class="option-card">
                                                    <input class="option-radio" type="radio" name="send_option" 
                                                           id="send_now" value="now" checked>
                                                    <label class="option-label" for="send_now">
                                                        <div class="option-icon">
                                                            <i class="icofont-send-mail"></i>
                                                        </div>
                                                        <div class="option-content">
                                                            <strong>Send Immediately</strong>
                                                            <span class="option-desc">Memo will be sent right away</span>
                                                        </div>
                                                    </label>
                                                </div>

                                                <div class="option-card">
                                                    <input class="option-radio" type="radio" name="send_option" 
                                                           id="schedule_send" value="schedule">
                                                    <label class="option-label" for="schedule_send">
                                                        <div class="option-icon">
                                                            <i class="icofont-clock-time"></i>
                                                        </div>
                                                        <div class="option-content">
                                                            <strong>Schedule for Later</strong>
                                                            <span class="option-desc">Choose when to send the memo</span>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="schedule-datetime" class="schedule-datetime mt-3" style="display: none;">
                                            <label for="scheduled_at">Schedule Date & Time:</label>
                                            <input type="datetime-local" id="scheduled_at" name="scheduled_at" 
                                                   class="form-control" min="{{ date('Y-m-d\TH:i') }}">
                                        </div>

                                        <hr>

                                        <div class="form-group">
                                            <label class="form-label">Actions</label>
                                            <div class="form-actions">
                                                <button type="submit" name="action" value="send" class="action-btn send-btn">
                                                    <i class="icofont-send-mail"></i> Send Memo
                                                </button>
                                                <button type="submit" name="action" value="draft" class="action-btn draft-btn">
                                                    <i class="icofont-save"></i> Save as Draft
                                                </button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">
                                                <i class="icofont-eye"></i> Memo Preview
                                            </label>
                                            <div class="preview-card">
                                                <div class="preview-header">
                                                    <div class="preview-subject" id="preview-subject">Subject will appear here</div>
                                                    <div class="preview-recipients" id="preview-recipients">Recipients: All users</div>
                                                </div>
                                                <div class="preview-message" id="preview-message">Message preview will appear here</div>
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
    /* Modern Compose Memo Styles */
* {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
}

.required { 
  color: #ef4444; 
  font-weight: 600;
}

/* Enhanced Dashboard Section Title */
.dashboard__section__title h4 {
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
  font-size: 26px;
  font-weight: 800;
  color: #1e293b;
  letter-spacing: -0.03em;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.08);
  margin: 0;
}

/* Responsive Button Styling */
.dashboard__section__actions {
  display: flex;
  gap: 15px;
  align-items: center;
}

.responsive-btn {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  height: 45px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: 0.3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background-color: #1a4a9b;
  text-decoration: none;
  flex-shrink: 0;
}

.responsive-btn:hover {
  width: 160px;
  border-radius: 40px;
  transition-duration: 0.3s;
  text-decoration: none;
}

.responsive-btn .svgWrapper {
  width: 100%;
  transition-duration: 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}

.responsive-btn .svgIcon {
  width: 17px;
  flex-shrink: 0;
}

.responsive-btn .text {
  position: absolute;
  left: 50px;
  width: 100px;
  opacity: 0;
  color: white;
  font-size: 14px;
  font-weight: 600;
  transition-duration: 0.3s;
  white-space: nowrap;
  text-align: left;
  padding-right: 10px;
}

.responsive-btn:hover .svgWrapper {
  width: 45px;
  transition-duration: 0.3s;
  padding-left: 0;
}

.responsive-btn:hover .text {
  opacity: 1;
  transition-duration: 0.3s;
}

.responsive-btn:active {
  transform: translate(2px, 2px);
}

/* Button variants */
.compose-btn {
  background-color: #1a4a9b;
}

.compose-btn:hover {
  background-color: #1a4a9b;
}

.back-btn {
  background-color: #1a4a9b;
}

.back-btn:hover {
  background-color: #1a4a9b;
}

.edit-btn {
  background-color: #1a4a9b;
}

.edit-btn:hover {
  background-color: #1a4a9b;
}

/* Compose Panel */
.compose-panel {
  background: #ffffff;
  border-radius: 16px;
  padding: 32px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #f1f5f9;
  height: 100%;
  margin-bottom: 24px;
}

.panel-header {
  margin-bottom: 32px;
  text-align: center;
}

.panel-header h5 {
  font-size: 20px;
  font-weight: 700;
  color: #1e293b;
  margin: 0 0 8px 0;
  letter-spacing: -0.02em;
  text-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

.panel-subtitle {
  font-size: 14px;
  color: #64748b;
  margin: 0;
  font-weight: 500;
  letter-spacing: 0.02em;
  opacity: 0.85;
}

/* Form Sections */
.form-section {
  display: flex;
  flex-direction: column;
  gap: 24px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-label {
  font-size: 15px;
  font-weight: 600;
  color: #374151;
  display: flex;
  align-items: center;
  gap: 8px;
  letter-spacing: 0.01em;
}

.form-label i {
  color: #3b82f6;
  font-size: 16px;
}

.form-help {
  font-size: 13px;
  color: #64748b;
  font-weight: 500;
  margin: 0;
}

/* Form Inputs */
.form-input {
  padding: 16px 20px;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  font-size: 15px;
  color: #1e293b;
  background: #ffffff;
  transition: all 0.3s ease;
  font-weight: 500;
}

.form-input:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  transform: translateY(-1px);
}

.form-input::placeholder {
  color: #94a3b8;
  font-weight: 400;
}

/* Message Editor */
.message-editor {
  position: relative;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  overflow: hidden;
  transition: all 0.3s ease;
}

.message-editor:focus-within {
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
  transform: translateY(-1px);
}

.form-textarea {
  width: 100%;
  border: none;
  padding: 20px;
  font-size: 15px;
  color: #1e293b;
  background: #ffffff;
  resize: vertical;
  min-height: 200px;
  font-family: inherit;
  line-height: 1.6;
}

.form-textarea:focus {
  outline: none;
}

.form-textarea::placeholder {
  color: #94a3b8;
  font-weight: 400;
}

/* Editor Toolbar */
.editor-toolbar {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 16px 20px;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  flex-wrap: wrap;
}

.toolbar-group {
  display: flex;
  gap: 4px;
  align-items: center;
}

.toolbar-divider {
  width: 1px;
  height: 24px;
  background: #e2e8f0;
  margin: 0 4px;
}

.toolbar-btn {
  width: 36px;
  height: 36px;
  border: none;
  border-radius: 8px;
  background: #ffffff;
  color: #64748b;
  font-size: 14px;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #e2e8f0;
  position: relative;
}

.toolbar-btn:hover {
  background: #3b82f6;
  color: white;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
  border-color: #3b82f6;
}

.toolbar-btn.active {
  background: #3b82f6;
  color: white;
  border-color: #3b82f6;
  box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.toolbar-btn:active {
  transform: translateY(0);
  box-shadow: 0 2px 4px rgba(59, 130, 246, 0.2);
}

.toolbar-select {
  padding: 6px 8px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  background: #ffffff;
  color: #64748b;
  font-size: 12px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
  min-width: 80px;
}

.toolbar-select:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
}

.toolbar-color {
  width: 32px;
  height: 32px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  cursor: pointer;
  transition: all 0.3s ease;
  background: #ffffff;
}

.toolbar-color:hover {
  border-color: #3b82f6;
  transform: scale(1.05);
}

.toolbar-color::-webkit-color-swatch-wrapper {
  padding: 0;
}

.toolbar-color::-webkit-color-swatch {
  border: none;
  border-radius: 4px;
}

/* Editor Content Area */
.editor-content {
  min-height: 200px;
  padding: 20px;
  border: none;
  outline: none;
  font-size: 15px;
  color: #1e293b;
  background: #ffffff;
  font-family: inherit;
  line-height: 1.6;
  overflow-y: auto;
  position: relative;
}

.editor-content:empty:before {
  content: attr(data-placeholder);
  color: #94a3b8;
  font-style: italic;
  pointer-events: none;
}

.editor-content:focus {
  outline: none;
}

.editor-content:focus:empty:before {
  display: none;
}

/* Rich Text Content Styles */
.editor-content h1,
.editor-content h2,
.editor-content h3,
.editor-content h4,
.editor-content h5,
.editor-content h6 {
  margin: 16px 0 8px 0;
  color: #1e293b;
  font-weight: 600;
  line-height: 1.3;
}

.editor-content h1 { font-size: 24px; }
.editor-content h2 { font-size: 20px; }
.editor-content h3 { font-size: 18px; }
.editor-content h4 { font-size: 16px; }
.editor-content h5 { font-size: 14px; }
.editor-content h6 { font-size: 13px; }

.editor-content p {
  margin: 0 0 12px 0;
  line-height: 1.6;
}

.editor-content ul,
.editor-content ol {
  margin: 12px 0;
  padding-left: 24px;
}

.editor-content li {
  margin: 4px 0;
  line-height: 1.5;
}

.editor-content blockquote {
  margin: 16px 0;
  padding: 12px 20px;
  border-left: 4px solid #3b82f6;
  background: #f8fafc;
  font-style: italic;
  color: #64748b;
}

.editor-content table {
  width: 100%;
  border-collapse: collapse;
  margin: 16px 0;
}

.editor-content table td,
.editor-content table th {
  border: 1px solid #e2e8f0;
  padding: 8px 12px;
  text-align: left;
}

.editor-content table th {
  background: #f8fafc;
  font-weight: 600;
  color: #374151;
}

.editor-content img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin: 8px 0;
}

.editor-content a {
  color: #3b82f6;
  text-decoration: underline;
  transition: color 0.3s ease;
}

.editor-content a:hover {
  color: #1d4ed8;
}

/* Recipient Options */
.recipient-options {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.option-card {
  position: relative;
  border: 2px solid #e2e8f0;
  border-radius: 12px;
  transition: all 0.3s ease;
  cursor: pointer;
  overflow: hidden;
}

.option-card:hover {
  border-color: #3b82f6;
  background: #f8fafc;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}

.option-radio {
  position: absolute;
  opacity: 0;
  cursor: pointer;
}

.option-label {
  display: flex;
  align-items: center;
  gap: 16px;
  padding: 20px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.option-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 20px;
  flex-shrink: 0;
}

.option-content {
  flex: 1;
  min-width: 0;
}

.option-content strong {
  display: block;
  font-size: 16px;
  font-weight: 700;
  color: #1e293b;
  margin-bottom: 4px;
  letter-spacing: 0.01em;
}

.option-desc {
  font-size: 13px;
  color: #64748b;
  font-weight: 500;
  line-height: 1.4;
}

.option-radio:checked + .option-label .option-card {
  border-color: #3b82f6;
  background: #f0f9ff;
}

.option-radio:checked + .option-label .option-icon {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

/* User Selector */
.user-selector {
  background: #ffffff;
  border: 1px solid #e2e8f0;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  margin-top: 16px;
}

.user-selector-header {
  padding: 24px;
  background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
  color: white;
}

.search-container {
  margin-bottom: 20px;
}

.search-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
  background: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
  border-radius: 12px;
  padding: 4px;
  transition: all 0.3s ease;
}

.search-input-wrapper:focus-within {
  background: rgba(255, 255, 255, 0.15);
  border-color: rgba(255, 255, 255, 0.3);
  box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
}

.search-input {
  flex: 1;
  border: none;
  background: transparent;
  padding: 12px 16px;
  font-size: 14px;
  color: white;
  outline: none;
  font-weight: 500;
}

.search-input::placeholder {
  color: rgba(255, 255, 255, 0.7);
}

.search-icon {
  color: rgba(255, 255, 255, 0.8);
  margin-right: 12px;
  font-size: 16px;
}

.user-stats {
  text-align: center;
  font-size: 14px;
  opacity: 0.9;
}

.stats-info {
  margin-bottom: 12px;
  font-weight: 500;
}

.selected-count {
  font-weight: 700;
  color: #10b981;
}

.progress-bar-container {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 10px;
  height: 8px;
  overflow: hidden;
}

.progress-bar {
  height: 100%;
  background: linear-gradient(90deg, #10b981, #059669);
  width: 0%;
  transition: width 0.8s ease;
  border-radius: 10px;
}

.user-list-container {
    max-height: 300px;
    overflow-y: auto;
    background: #f8f9fa;
}

.user-list {
    padding: 0;
    margin: 0;
}

.user-item {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #e9ecef;
    transition: all 0.2s ease;
    cursor: pointer;
}

.user-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.user-item:last-child {
    border-bottom: none;
}

.user-avatar {
    margin-right: 15px;
    flex-shrink: 0;
}

.avatar-img {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.avatar-placeholder {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 16px;
    border: 2px solid #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.user-info {
    flex: 1;
    min-width: 0;
}

.user-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 4px;
    font-size: 14px;
}

.user-email {
    color: #6c757d;
    font-size: 12px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 4px;
}

.user-status {
    display: flex;
    align-items: center;
    gap: 6px;
}

.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #28a745;
    animation: pulse 2s infinite;
}

.status-indicator.online {
    background: #28a745;
}

.status-indicator.offline {
    background: #6c757d;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

.user-select-checkbox {
    position: relative;
    margin-left: 15px;
}

.user-checkbox {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 22px;
    width: 22px;
    z-index: 2;
}

.checkmark {
    height: 22px;
    width: 22px;
    background-color: #fff;
    border: 2px solid #dee2e6;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
    cursor: pointer;
    position: relative;
    z-index: 1;
}

.user-checkbox:checked ~ .checkmark {
    background-color: #28a745;
    border-color: #28a745;
}

.checkmark:after {
    content: '';
    display: none;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.user-checkbox:checked ~ .checkmark:after {
    display: block;
}

/* Ensure the checkbox container is properly positioned */
.user-select-checkbox {
    position: relative;
    margin-left: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 22px;
    min-height: 22px;
}

/* Make sure checkboxes are clickable */
.user-checkbox:focus + .checkmark {
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}

/* Hover effect for better UX */
.user-item:hover .checkmark {
    border-color: #007bff;
}

/* Ensure the checkbox is properly layered */
.user-select-checkbox input[type="checkbox"] {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    margin: 0;
    opacity: 0;
    cursor: pointer;
}

.user-actions {
    padding: 15px 20px;
    background: #f8f9fa;
    border-top: 1px solid #e9ecef;
    display: flex;
    gap: 10px;
}

.user-actions .btn {
    flex: 1;
    font-size: 12px;
    padding: 8px 12px;
}

.sending-options .form-check {
    margin-bottom: 15px;
    padding: 15px;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.sending-options .form-check:hover {
    border-color: #28a745;
    background-color: #f8f9fa;
}

.schedule-datetime {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

/* File Upload */
.file-upload-area {
  position: relative;
  border: 2px dashed #cbd5e1;
  border-radius: 16px;
  padding: 40px 30px;
  text-align: center;
  transition: all 0.3s ease;
  cursor: pointer;
  background: #f8fafc;
}

.file-upload-area:hover {
  border-color: #3b82f6;
  background: #f0f9ff;
  transform: translateY(-2px);
  box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
}

.file-upload-area.dragover {
  border-color: #3b82f6;
  background: #dbeafe;
  transform: scale(1.02);
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
  font-size: 56px;
  color: #3b82f6;
  margin-bottom: 16px;
  opacity: 0.8;
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

/* Form Actions */
.form-actions {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.action-btn {
  padding: 16px 24px;
  border: none;
  border-radius: 12px;
  font-size: 15px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  letter-spacing: 0.02em;
  text-decoration: none;
}

.action-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
}

.send-btn {
  background: linear-gradient(135deg, #10b981 0%, #059669 100%);
  color: white;
}

.draft-btn {
  background: linear-gradient(135deg, #64748b 0%, #475569 100%);
  color: white;
}

/* Preview Card */
.preview-card {
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 12px;
  padding: 20px;
  font-size: 14px;
}

.preview-header {
  margin-bottom: 16px;
  padding-bottom: 16px;
  border-bottom: 1px solid #e2e8f0;
}

.preview-subject {
  font-weight: 700;
  margin-bottom: 8px;
  color: #1e293b;
  font-size: 16px;
  letter-spacing: 0.01em;
}

.preview-recipients {
  font-size: 13px;
  color: #10b981;
  font-weight: 600;
  letter-spacing: 0.02em;
}

.preview-message {
  color: #64748b;
  line-height: 1.6;
  max-height: 120px;
  overflow-y: auto;
  font-size: 13px;
}

/* ============================================
   AMAZING MEMO DELIVERY NOTIFICATION SYSTEM
   ============================================ */

/* Notification Overlay */
.memo-notification-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: overlayFadeIn 0.5s ease-out;
}

@keyframes overlayFadeIn {
    from {
        opacity: 0;
        backdrop-filter: blur(0px);
    }
    to {
        opacity: 1;
        backdrop-filter: blur(10px);
    }
}

/* Notification Container */
.memo-notification-container {
    position: relative;
    animation: notificationSlideIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

@keyframes notificationSlideIn {
    from {
        opacity: 0;
        transform: translateY(-100px) scale(0.8);
        filter: blur(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0px);
    }
}

/* Main Notification Card */
.memo-notification-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.15),
        0 0 0 1px rgba(255, 255, 255, 0.1),
        inset 0 1px 0 rgba(255, 255, 255, 0.8);
    max-width: 500px;
    width: 90vw;
    text-align: center;
    position: relative;
    overflow: hidden;
    animation: cardPulse 3s ease-in-out infinite;
}

@keyframes cardPulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 
            0 25px 50px rgba(0, 0, 0, 0.15),
            0 0 30px rgba(16, 185, 129, 0.3);
    }
    50% {
        transform: scale(1.02);
        box-shadow: 
            0 30px 60px rgba(0, 0, 0, 0.2),
            0 0 40px rgba(16, 185, 129, 0.5);
    }
}

/* Success Icon Container */
.notification-icon-container {
    position: relative;
    margin-bottom: 24px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.notification-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: white;
    position: relative;
    z-index: 2;
    animation: iconBlink 2s ease-in-out infinite;
}

.success-icon {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 
        0 8px 32px rgba(16, 185, 129, 0.4),
        inset 0 2px 0 rgba(255, 255, 255, 0.3);
}

@keyframes iconBlink {
    0%, 100% {
        transform: scale(1) rotate(0deg);
        box-shadow: 
            0 8px 32px rgba(16, 185, 129, 0.4),
            0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    25% {
        transform: scale(1.1) rotate(5deg);
        box-shadow: 
            0 12px 40px rgba(16, 185, 129, 0.6),
            0 0 0 20px rgba(16, 185, 129, 0.3);
    }
    50% {
        transform: scale(1.2) rotate(0deg);
        box-shadow: 
            0 16px 48px rgba(16, 185, 129, 0.8),
            0 0 0 40px rgba(16, 185, 129, 0.1);
    }
    75% {
        transform: scale(1.1) rotate(-5deg);
        box-shadow: 
            0 12px 40px rgba(16, 185, 129, 0.6),
            0 0 0 20px rgba(16, 185, 129, 0.3);
    }
}

/* Floating Particles */
.icon-particles {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 120px;
    height: 120px;
    pointer-events: none;
}

.particle {
    position: absolute;
    width: 8px;
    height: 8px;
    background: linear-gradient(45deg, #10b981, #34d399);
    border-radius: 50%;
    animation: particleFloat 3s ease-in-out infinite;
    box-shadow: 0 0 10px rgba(16, 185, 129, 0.6);
}

.particle:nth-child(1) {
    top: 10%;
    left: 50%;
    animation-delay: 0s;
    animation-duration: 2.5s;
}

.particle:nth-child(2) {
    top: 30%;
    right: 15%;
    animation-delay: 0.5s;
    animation-duration: 3s;
}

.particle:nth-child(3) {
    bottom: 30%;
    right: 10%;
    animation-delay: 1s;
    animation-duration: 2.8s;
}

.particle:nth-child(4) {
    bottom: 10%;
    left: 45%;
    animation-delay: 1.5s;
    animation-duration: 3.2s;
}

.particle:nth-child(5) {
    top: 35%;
    left: 10%;
    animation-delay: 2s;
    animation-duration: 2.7s;
}

.particle:nth-child(6) {
    top: 60%;
    left: 80%;
    animation-delay: 2.5s;
    animation-duration: 3.1s;
}

@keyframes particleFloat {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
        opacity: 0.8;
    }
    25% {
        transform: translateY(-20px) rotate(90deg);
        opacity: 1;
    }
    50% {
        transform: translateY(-40px) rotate(180deg);
        opacity: 0.9;
    }
    75% {
        transform: translateY(-20px) rotate(270deg);
        opacity: 1;
    }
}

/* Notification Content */
.notification-content {
    margin-bottom: 32px;
}

.notification-title {
    font-size: 28px;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 12px;
    letter-spacing: -0.02em;
    background: linear-gradient(135deg, #1e293b 0%, #10b981 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: titleShimmer 3s ease-in-out infinite;
}

@keyframes titleShimmer {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

.notification-message {
    font-size: 16px;
    color: #64748b;
    font-weight: 500;
    line-height: 1.6;
    margin-bottom: 24px;
    animation: messageGlow 4s ease-in-out infinite;
}

@keyframes messageGlow {
    0%, 100% {
        color: #64748b;
        text-shadow: none;
    }
    50% {
        color: #10b981;
        text-shadow: 0 0 10px rgba(16, 185, 129, 0.3);
    }
}

/* Delivery Statistics */
.delivery-stats {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    padding: 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    margin: 24px 0;
    animation: statsGlow 3s ease-in-out infinite;
}

@keyframes statsGlow {
    0%, 100% {
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    50% {
        box-shadow: 0 8px 30px rgba(16, 185, 129, 0.2);
    }
}

.stat-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.stat-number {
    font-size: 24px;
    font-weight: 800;
    color: #10b981;
    animation: numberCount 2s ease-out;
}

@keyframes numberCount {
    from {
        transform: scale(0.5) rotate(-180deg);
        opacity: 0;
    }
    to {
        transform: scale(1) rotate(0deg);
        opacity: 1;
    }
}

.stat-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.stat-divider {
    width: 1px;
    height: 40px;
    background: linear-gradient(to bottom, transparent, #e2e8f0, transparent);
}

/* Notification Actions */
.notification-actions {
    display: flex;
    gap: 16px;
    justify-content: center;
    margin-bottom: 24px;
}

.notification-btn {
    padding: 14px 28px;
    border: none;
    border-radius: 12px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    display: flex;
    align-items: center;
    gap: 8px;
    letter-spacing: 0.02em;
    position: relative;
    overflow: hidden;
}

.notification-btn:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
    transition: left 0.6s;
}

.notification-btn:hover:before {
    left: 100%;
}

.notification-btn.primary {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    box-shadow: 0 4px 20px rgba(59, 130, 246, 0.3);
}

.notification-btn.primary:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 8px 30px rgba(59, 130, 246, 0.4);
}

.notification-btn.secondary {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    color: #64748b;
    border: 1px solid #e2e8f0;
}

.notification-btn.secondary:hover {
    transform: translateY(-2px) scale(1.05);
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    color: #475569;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Progress Bar */
.notification-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: rgba(226, 232, 240, 0.3);
    border-radius: 0 0 24px 24px;
    overflow: hidden;
}

.progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #10b981, #34d399, #6ee7b7);
    background-size: 200% 100%;
    animation: progressFlow 3s ease-in-out;
    border-radius: 0 0 24px 24px;
}

@keyframes progressFlow {
    0% {
        width: 0%;
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
    100% {
        width: 100%;
        background-position: 0% 50%;
    }
}

/* Blinking Effect for the Entire Card */
@keyframes notificationBlink {
    0%, 100% {
        opacity: 1;
        transform: scale(1);
    }
    25% {
        opacity: 0.7;
        transform: scale(0.98);
    }
    50% {
        opacity: 1;
        transform: scale(1.02);
    }
    75% {
        opacity: 0.7;
        transform: scale(0.98);
    }
}

.memo-notification-card.blinking {
    animation: notificationBlink 1.5s ease-in-out infinite;
}

/* Responsive Design for Notification */
@media (max-width: 768px) {
    .memo-notification-card {
        padding: 30px 20px;
        max-width: 95vw;
    }
    
    .notification-icon {
        width: 70px;
        height: 70px;
        font-size: 35px;
    }
    
    .notification-title {
        font-size: 24px;
    }
    
    .notification-message {
        font-size: 15px;
    }
    
    .delivery-stats {
        flex-direction: column;
        gap: 16px;
    }
    
    .stat-divider {
        width: 80%;
        height: 1px;
    }
    
    .notification-actions {
        flex-direction: column;
    }
    
    .notification-btn {
        width: 100%;
        justify-content: center;
    }
}

/* Custom scrollbar for user list */
.user-list-container::-webkit-scrollbar {
  width: 6px;
}

.user-list-container::-webkit-scrollbar-track {
  background: #f1f5f9;
  border-radius: 3px;
}

.user-list-container::-webkit-scrollbar-thumb {
  background: #cbd5e1;
  border-radius: 3px;
}

.user-list-container::-webkit-scrollbar-thumb:hover {
  background: #94a3b8;
}

/* Animation for user items */
.user-item {
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateX(-20px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
  .dashboard__section__actions {
    flex-direction: column;
    gap: 10px;
    align-items: stretch;
  }
  
  .responsive-btn {
    width: 100%;
    height: 50px;
    border-radius: 25px;
    justify-content: center;
  }
  
  .responsive-btn:hover {
    width: 100%;
  }
  
  .responsive-btn .text {
    position: static;
    opacity: 1;
    width: auto;
    margin-left: 15px;
  }
  
  .responsive-btn .svgWrapper {
    width: auto;
  }
  
  .compose-panel {
    padding: 24px;
    margin-bottom: 16px;
  }
  
  .panel-header h5 {
    font-size: 18px;
  }
  
  .form-input,
  .form-textarea {
    padding: 14px 16px;
    font-size: 14px;
  }
  
  .message-editor {
    min-height: 180px;
  }
  
  .editor-toolbar {
    padding: 10px 16px;
    gap: 6px;
  }
  
  .toolbar-group {
    gap: 2px;
  }
  
  .toolbar-btn {
    width: 32px;
    height: 32px;
    font-size: 12px;
  }
  
  .toolbar-divider {
    height: 20px;
    margin: 0 2px;
  }
  
  .toolbar-select {
    min-width: 70px;
    font-size: 11px;
    padding: 4px 6px;
  }
  
  .toolbar-color {
    width: 28px;
    height: 28px;
  }
  
  .option-label {
    padding: 16px;
    gap: 12px;
  }
  
  .option-icon {
    width: 40px;
    height: 40px;
    font-size: 18px;
  }
  
  .user-selector-header {
    padding: 20px;
  }
  
  .search-input-wrapper {
    padding: 2px;
  }
  
  .search-input {
    padding: 10px 14px;
    font-size: 13px;
  }
  
  .user-item {
    padding: 12px 16px;
  }
  
  .avatar-img, .avatar-placeholder {
    width: 40px;
    height: 40px;
    font-size: 14px;
  }
  
  .user-name {
    font-size: 14px;
  }
  
  .user-email {
    font-size: 12px;
  }
  
  .action-btn {
    padding: 14px 20px;
    font-size: 14px;
  }
  
  .file-upload-area {
    padding: 30px 20px;
  }
  
  .file-upload-icon {
    font-size: 48px;
  }
}

@media (max-width: 576px) {
  .compose-panel {
    padding: 20px;
  }
  
  .panel-header {
    margin-bottom: 24px;
  }
  
  .form-section {
    gap: 20px;
  }
  
  .option-label {
    flex-direction: column;
    text-align: center;
    gap: 12px;
  }
  
  .user-selector-header {
    padding: 16px;
  }
  
  .user-actions {
    flex-direction: column;
    gap: 8px;
  }
  
  .user-actions .btn {
    width: 100%;
  }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const recipientRadios = document.querySelectorAll('input[name="recipient_type"]');
    const userSelector = document.getElementById('user-selector');
    const userSearch = document.getElementById('user-search');
    const userList = document.getElementById('user-list');
    const userItems = document.querySelectorAll('.user-item');
    const userCheckboxes = document.querySelectorAll('.user-checkbox');
    const selectAllBtn = document.getElementById('select-all-btn');
    const clearAllBtn = document.getElementById('clear-all-btn');
    const exportSelectedBtn = document.getElementById('export-selected-btn');
    const selectedCountSpan = document.querySelector('.selected-count');
    
    const sendOptionRadios = document.querySelectorAll('input[name="send_option"]');
    const scheduleDateTime = document.getElementById('schedule-datetime');
    
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
                updateSelectedCount();
                updatePreview();
            } else {
                userSelector.style.display = 'none';
                updatePreview();
            }
        });
    });
    
    // Handle send option changes
    sendOptionRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'schedule') {
                scheduleDateTime.style.display = 'block';
                document.getElementById('scheduled_at').required = true;
            } else {
                scheduleDateTime.style.display = 'none';
                document.getElementById('scheduled_at').required = false;
            }
        });
    });
    
    // Search functionality
    userSearch.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        userItems.forEach(item => {
            const searchData = item.getAttribute('data-search');
            if (searchData.includes(searchTerm)) {
                item.style.display = 'flex';
                item.style.animation = 'slideIn 0.3s ease-out';
            } else {
                item.style.display = 'none';
            }
        });
    });
    
    // User selection handling
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectedCount();
            updatePreview();
        });
        
        // Also add click event to the user item for better UX
        const userItem = checkbox.closest('.user-item');
        if (userItem) {
            userItem.addEventListener('click', function(e) {
                // Don't trigger if clicking on the checkbox itself
                if (e.target !== checkbox && !checkbox.contains(e.target)) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change'));
                }
            });
        }
    });
    
    // Select all functionality
    selectAllBtn.addEventListener('click', function() {
        const visibleCheckboxes = Array.from(userCheckboxes).filter(checkbox => {
            const userItem = checkbox.closest('.user-item');
            return userItem.style.display !== 'none';
        });
        
        visibleCheckboxes.forEach(checkbox => {
            checkbox.checked = true;
        });
        
        updateSelectedCount();
        updatePreview();
    });
    
    // Clear all functionality
    clearAllBtn.addEventListener('click', function() {
        userCheckboxes.forEach(checkbox => {
            checkbox.checked = false;
        });
        
        updateSelectedCount();
        updatePreview();
    });
    
    // Export selected users functionality
    exportSelectedBtn.addEventListener('click', function() {
        const selectedUsers = Array.from(userCheckboxes)
            .filter(checkbox => checkbox.checked)
            .map(checkbox => {
                const userItem = checkbox.closest('.user-item');
                const name = userItem.querySelector('.user-name').textContent;
                const email = userItem.querySelector('.user-email').textContent;
                return { name, email };
            });
        
        if (selectedUsers.length === 0) {
            alert('No users selected to export');
            return;
        }
        
        // Create CSV content
        const csvContent = 'Name,Email\n' + 
            selectedUsers.map(user => `"${user.name}","${user.email}"`).join('\n');
        
        // Create and download file
        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = window.URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `selected_users_${new Date().toISOString().split('T')[0]}.csv`;
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
        
        // Show success message
        this.innerHTML = '<i class="icofont-check-circled"></i> Exported!';
        setTimeout(() => {
            this.innerHTML = '<i class="icofont-download"></i> Export';
        }, 2000);
    });
    
    // Update selected count
    function updateSelectedCount() {
        const selectedCount = Array.from(userCheckboxes).filter(checkbox => checkbox.checked).length;
        const totalCount = userCheckboxes.length;
        const progressPercentage = totalCount > 0 ? (selectedCount / totalCount) * 100 : 0;
        
        selectedCountSpan.textContent = selectedCount;
        
        // Update progress bar
        const progressBar = document.getElementById('selection-progress');
        if (progressBar) {
            progressBar.style.width = progressPercentage + '%';
        }
        
        // Update button states
        if (selectedCount > 0) {
            clearAllBtn.disabled = false;
            exportSelectedBtn.disabled = false;
        } else {
            clearAllBtn.disabled = true;
            exportSelectedBtn.disabled = true;
        }
    }
    
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
    
    // Rich Text Editor Functionality
    const editorContent = document.getElementById('editor-content');
    const messageTextarea = document.getElementById('message');
    const toolbarButtons = document.querySelectorAll('.toolbar-btn');
    
    // Initialize editor content
    if (editorContent.innerHTML.trim() === '') {
        editorContent.innerHTML = '';
    }
    
    // Handle toolbar button clicks
    toolbarButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const command = this.getAttribute('data-command');
            
            if (command) {
                executeCommand(command);
                updateTextareaContent();
                updatePreview();
            }
        });
    });
    
    // Execute formatting commands
    function executeCommand(command) {
        switch(command) {
            case 'createLink':
                const url = prompt('Enter URL:', 'https://');
                if (url) {
                    document.execCommand('createLink', false, url);
                }
                break;
            case 'insertImage':
                const imageUrl = prompt('Enter image URL:', 'https://');
                if (imageUrl) {
                    document.execCommand('insertImage', false, imageUrl);
                }
                break;
            case 'insertTable':
                const rows = prompt('Enter number of rows:', '3');
                const cols = prompt('Enter number of columns:', '3');
                if (rows && cols) {
                    insertTable(parseInt(rows), parseInt(cols));
                }
                break;
            case 'insertHorizontalRule':
                document.execCommand('insertHorizontalRule', false);
                break;
            default:
                document.execCommand(command, false, null);
                break;
        }
        
        // Update button states
        updateButtonStates();
    }
    
    // Insert table function
    function insertTable(rows, cols) {
        let tableHTML = '<table border="1" style="border-collapse: collapse; width: 100%;">';
        
        for (let i = 0; i < rows; i++) {
            tableHTML += '<tr>';
            for (let j = 0; j < cols; j++) {
                if (i === 0) {
                    tableHTML += '<th style="padding: 8px; border: 1px solid #ccc; background: #f8f9fa;">Header ' + (j + 1) + '</th>';
                } else {
                    tableHTML += '<td style="padding: 8px; border: 1px solid #ccc;">Cell ' + (i + 1) + '-' + (j + 1) + '</td>';
                }
            }
            tableHTML += '</tr>';
        }
        
        tableHTML += '</table>';
        document.execCommand('insertHTML', false, tableHTML);
    }
    
    // Update button states based on current selection
    function updateButtonStates() {
        toolbarButtons.forEach(button => {
            const command = button.getAttribute('data-command');
            if (['bold', 'italic', 'underline', 'strikeThrough'].includes(command)) {
                if (document.queryCommandState(command)) {
                    button.classList.add('active');
                } else {
                    button.classList.remove('active');
                }
            }
        });
    }
    
    // Update textarea content for form submission
    function updateTextareaContent() {
        messageTextarea.value = editorContent.innerHTML;
    }
    
    // Handle editor content changes
    editorContent.addEventListener('input', function() {
        updateTextareaContent();
        updatePreview();
    });
    
    editorContent.addEventListener('keyup', function() {
        updateButtonStates();
    });
    
    // Handle keyboard shortcuts
    editorContent.addEventListener('keydown', function(e) {
        if (e.ctrlKey || e.metaKey) {
            switch(e.key.toLowerCase()) {
                case 'b':
                    e.preventDefault();
                    executeCommand('bold');
                    break;
                case 'i':
                    e.preventDefault();
                    executeCommand('italic');
                    break;
                case 'u':
                    e.preventDefault();
                    executeCommand('underline');
                    break;
                case 'z':
                    if (e.shiftKey) {
                        e.preventDefault();
                        executeCommand('redo');
                    } else {
                        e.preventDefault();
                        executeCommand('undo');
                    }
                    break;
            }
        }
    });
    
    // Font size and color controls
    const fontSizeSelect = document.getElementById('fontSize');
    const textColorInput = document.getElementById('textColor');
    
    fontSizeSelect.addEventListener('change', function() {
        document.execCommand('fontSize', false, this.value);
        updateTextareaContent();
        updatePreview();
    });
    
    textColorInput.addEventListener('change', function() {
        document.execCommand('foreColor', false, this.value);
        updateTextareaContent();
        updatePreview();
    });
    
    // Preview functionality
    function updatePreview() {
        const subject = subjectInput.value || 'Subject will appear here';
        const message = messageTextarea.value || 'Message preview will appear here';
        
        previewSubject.textContent = subject;
        previewMessage.innerHTML = message.substring(0, 200) + (message.length > 200 ? '...' : '');
        
        const recipientType = document.querySelector('input[name="recipient_type"]:checked').value;
        if (recipientType === 'all') {
            previewRecipients.textContent = `Recipients: All users ({{ $users->count() }} users)`;
        } else {
            const selectedCount = Array.from(userCheckboxes).filter(checkbox => checkbox.checked).length;
            previewRecipients.textContent = `Recipients: ${selectedCount} selected users`;
        }
    }
    
    subjectInput.addEventListener('input', updatePreview);
    editorContent.addEventListener('input', updatePreview);
    
    // Initialize
    if (document.getElementById('selected_users').checked) {
        userSelector.style.display = 'block';
    }
    
    if (document.getElementById('schedule_send').checked) {
        scheduleDateTime.style.display = 'block';
    }
    
    // Initialize button states
    exportSelectedBtn.disabled = true;
    
    updateSelectedCount();
    updatePreview();
    
    // Form submission with AJAX for memo delivery notification
    document.getElementById('emailForm').addEventListener('submit', function(e) {
        // Ensure the textarea has the latest content
        updateTextareaContent();
        
        const action = e.submitter ? e.submitter.value : 'send';
        const submitButton = e.submitter || document.querySelector('button[type="submit"]');
        
        // Only prevent default for Send Memo action, let Draft submit normally
        if (action === 'send') {
            e.preventDefault();
            
            // Show loading state
            submitButton.disabled = true;
            const originalText = submitButton.innerHTML;
            submitButton.innerHTML = '<i class="icofont-spinner icofont-spin"></i> Sending Memo...';
            
            // Create FormData from the actual form
            const formData = new FormData(this);
            
            // Ensure action is set correctly
            formData.set('action', 'send');
            
            // Make AJAX request
            fetch('{{ route("admin.communication.store") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.text().then(text => {
                        throw new Error(`HTTP ${response.status}: ${text}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showMemoDeliveryNotification(data);
                } else {
                    throw new Error(data.message || 'Failed to send memo');
                }
            })
            .catch(error => {
                console.error('Ajax Error:', error);
                // Restore button state
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
                
                // Show error
                alert('Error sending memo: ' + error.message);
            });
        }
        // If it's draft action, let the form submit normally (don't prevent default)
    });
    
    // Function to show the impressive memo delivery notification
    function showMemoDeliveryNotification(data) {
        const notification = document.getElementById('memo-delivery-notification');
        const notificationCard = notification.querySelector('.memo-notification-card');
        const deliveryMessage = document.getElementById('delivery-message');
        const sentCount = document.getElementById('sent-count');
        const totalRecipients = document.getElementById('total-recipients');
        const viewMemosBtn = document.getElementById('view-memos-btn');
        const closeNotificationBtn = document.getElementById('close-notification-btn');
        
        // Update content with data from server
        deliveryMessage.textContent = data.message || 'Your memo has been delivered successfully!';
        sentCount.textContent = data.sent_count || 0;
        totalRecipients.textContent = data.total_recipients || 0;
        
        // Show notification with fade-in effect
        notification.style.display = 'flex';
        
        // Play success sound (if supported)
        try {
            // Create success sound using Web Audio API
            const audioContext = new (window.AudioContext || window.webkitAudioContext)();
            const successSound = () => {
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                // Create a pleasant success melody
                const notes = [523.25, 659.25, 783.99]; // C5, E5, G5
                let noteIndex = 0;
                
                const playNote = () => {
                    if (noteIndex < notes.length) {
                        oscillator.frequency.setValueAtTime(notes[noteIndex], audioContext.currentTime);
                        gainNode.gain.setValueAtTime(0.1, audioContext.currentTime);
                        gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.3);
                        
                        noteIndex++;
                        setTimeout(playNote, 200);
                    }
                };
                
                oscillator.start();
                playNote();
                oscillator.stop(audioContext.currentTime + 1);
            };
            
            successSound();
        } catch (e) {
            console.log('Audio not supported or blocked');
        }
        
        // Add screen shake effect
        document.body.style.animation = 'successShake 0.5s ease-in-out';
        setTimeout(() => {
            document.body.style.animation = '';
        }, 500);
        
        // Add blinking effect after 2 seconds
        setTimeout(() => {
            notificationCard.classList.add('blinking');
        }, 2000);
        
        // Auto-close notification after 8 seconds (optional)
        let autoCloseTimer = setTimeout(() => {
            hideMemoDeliveryNotification(data.redirect_url);
        }, 8000);
        
        // Handle View Memos button click
        viewMemosBtn.onclick = function() {
            clearTimeout(autoCloseTimer);
            hideMemoDeliveryNotification(data.redirect_url);
        };
        
        // Handle Close button click
        closeNotificationBtn.onclick = function() {
            clearTimeout(autoCloseTimer);
            hideMemoDeliveryNotification(data.redirect_url);
        };
        
        // Handle click outside notification to close
        notification.onclick = function(e) {
            if (e.target === notification) {
                clearTimeout(autoCloseTimer);
                hideMemoDeliveryNotification(data.redirect_url);
            }
        };
        
        // Handle ESC key to close
        document.addEventListener('keydown', function escKeyHandler(e) {
            if (e.key === 'Escape') {
                clearTimeout(autoCloseTimer);
                document.removeEventListener('keydown', escKeyHandler);
                hideMemoDeliveryNotification(data.redirect_url);
            }
        });
    }
    
    // Function to hide the notification and redirect
    function hideMemoDeliveryNotification(redirectUrl) {
        const notification = document.getElementById('memo-delivery-notification');
        const notificationCard = notification.querySelector('.memo-notification-card');
        
        // Remove blinking effect
        notificationCard.classList.remove('blinking');
        
        // Add fade-out animation
        notification.style.animation = 'overlayFadeOut 0.5s ease-out forwards';
        notificationCard.style.animation = 'notificationSlideOut 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55) forwards';
        
        // Hide and redirect after animation
        setTimeout(() => {
            notification.style.display = 'none';
            // Reset animations
            notification.style.animation = '';
            notificationCard.style.animation = '';
            
            // Redirect to memos page
            if (redirectUrl) {
                window.location.href = redirectUrl;
            }
        }, 500);
    }
    
    // Add fade-out animations to CSS (we'll add this in the next step)
    const style = document.createElement('style');
    style.textContent = `
        @keyframes overlayFadeOut {
            from {
                opacity: 1;
                backdrop-filter: blur(10px);
            }
            to {
                opacity: 0;
                backdrop-filter: blur(0px);
            }
        }
        
        @keyframes notificationSlideOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
                filter: blur(0px);
            }
            to {
                opacity: 0;
                transform: translateY(-100px) scale(0.8);
                filter: blur(10px);
            }
        }
        
        @keyframes successShake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
            20%, 40%, 60%, 80% { transform: translateX(2px); }
        }
    `;
    document.head.appendChild(style);
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
</script>
@endsection