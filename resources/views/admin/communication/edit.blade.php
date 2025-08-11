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
                            <h4>Edit Email Campaign</h4>
                            <div class="dashboard__section__actions">
                                <a href="{{route('admin.communication.show', $campaign)}}" class="default__button">
                                    <i class="icofont-arrow-left"></i> Back to Campaign
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

                        <form method="POST" action="{{ route('admin.communication.update', $campaign) }}" enctype="multipart/form-data" id="campaignForm">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-xl-8">
                                    <div class="dashboard__form__wraper">
                                        <div class="dashboard__form__input">
                                            <label for="title">Campaign Title <span class="required">*</span></label>
                                            <input type="text" id="title" name="title" 
                                                   placeholder="Enter campaign title" 
                                                   value="{{ old('title', $campaign->title) }}" required>
                                            <small class="form-text text-muted">Internal name for this email campaign</small>
                                        </div>

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
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="recipient_type" 
                                                       id="all_users" value="all" 
                                                       {{ old('recipient_type', $campaign->recipient_type) === 'all' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="all_users">
                                                    <strong>All Registered Users</strong>
                                                    <br><small class="text-muted">Send to all approved users ({{ $users->count() }} users)</small>
                                                </label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="recipient_type" 
                                                       id="selected_users" value="selected"
                                                       {{ old('recipient_type', $campaign->recipient_type) === 'selected' ? 'checked' : '' }}>
                                                <label class="form-check-label" for="selected_users">
                                                    <strong>Selected Users</strong>
                                                    <br><small class="text-muted">Choose specific users to send to</small>
                                                </label>
                                            </div>
                                        </div>

                                        <div id="user-selector" class="user-selector mt-3" style="display: {{ old('recipient_type', $campaign->recipient_type) === 'selected' ? 'block' : 'none' }};">
                                            <label for="selected_users_list">Select Users:</label>
                                            <select name="selected_users[]" id="selected_users_list" multiple 
                                                    class="form-control user-select">
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}"
                                                            {{ in_array($user->id, old('selected_users', $campaign->selected_users ?? [])) ? 'selected' : '' }}>
                                                        {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="form-text text-muted">Hold Ctrl/Cmd to select multiple users</small>
                                        </div>

                                        <hr>

                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <i class="icofont-save"></i> Update Campaign
                                            </button>
                                            <a href="{{ route('admin.communication.show', $campaign) }}" 
                                               class="btn btn-secondary btn-block">
                                                <i class="icofont-close"></i> Cancel
                                            </a>
                                        </div>

                                        <div class="campaign-preview mt-3">
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
    document.getElementById('campaignForm').addEventListener('submit', function(e) {
        // Show loading state
        e.target.querySelector('button[type="submit"]').disabled = true;
        e.target.querySelector('button[type="submit"]').innerHTML = '<i class="icofont-spinner fa-spin"></i> Updating...';
    });
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