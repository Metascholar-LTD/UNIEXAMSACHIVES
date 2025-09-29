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
                {{-- sidebar menu --}}
                @include('components.sidebar')
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>Memo</h4>
                            <div style="margin-top:8px">
                                <a href="{{ route('dashboard.message') }}" class="btn btn-sm btn-primary">
                                    <i class="icofont-arrow-left"></i> Back to Memos
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="dashboard__form"><h3>{{$message->title}}</h3></div>
                            </div>
                            <div class="col-lg-12 col-md-12">
                                <div class="dashboard__form">{!!$message->body!!}</div>
                                @if(isset($message->attachments) && is_array($message->attachments) && count($message->attachments) > 0)
                                <div class="dashboard__form" style="margin-top: 16px;">
                                    <h5><i class="icofont-attachment"></i> Attachments</h5>
                                    <div class="attachments-list">
                                        @foreach($message->attachments as $index => $file)
                                            <div class="attachment-item" style="display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; margin: 8px 0; border: 1px solid #e0e0e0; border-radius: 8px; background: #f9f9f9; transition: all 0.2s ease;">
                                                <div class="attachment-info" style="display: flex; align-items: center; flex: 1;">
                                                    <i class="icofont-file-alt" style="margin-right: 12px; color: #666; font-size: 1.2em;"></i>
                                                    <div>
                                                        <span class="attachment-name" style="font-weight: 500; color: #333; display: block;">{{ $file['name'] }}</span>
                                                        <span class="attachment-size" style="color: #666; font-size: 0.85em;">
                                                            {{ number_format($file['size'] / 1024, 1) }} KB
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="attachment-actions" style="display: flex; gap: 8px;">
                                                    <a href="{{ route('dashboard.memo.download-attachment', ['recipient' => $message->id, 'index' => $index]) }}" 
                                                       class="btn btn-sm btn-primary" style="padding: 6px 12px; font-size: 0.85em; border-radius: 4px;">
                                                        <i class="icofont-download"></i> Download
                                                    </a>
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary view-file-btn" 
                                                            style="padding: 6px 12px; font-size: 0.85em; border-radius: 4px;"
                                                            data-file-name="{{ $file['name'] }}"
                                                            data-file-type="{{ $file['type'] ?? 'application/octet-stream' }}"
                                                            data-view-url="{{ route('dashboard.memo.view-attachment', ['recipient' => $message->id, 'index' => $index]) }}"
                                                            data-download-url="{{ route('dashboard.memo.download-attachment', ['recipient' => $message->id, 'index' => $index]) }}">
                                                        <i class="icofont-eye"></i> View
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- File Viewer Modal -->
<div class="modal fade" id="fileViewerModal" tabindex="-1" aria-labelledby="fileViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #dee2e6;">
                <h5 class="modal-title" id="fileViewerModalLabel">
                    <i class="icofont-file-alt"></i> <span id="modalFileName">File Viewer</span>
                </h5>
                <div class="modal-actions">
                    <a href="#" id="modalDownloadBtn" class="btn btn-sm btn-primary me-2">
                        <i class="icofont-download"></i> Download
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body" style="padding: 0; height: 70vh; overflow: hidden;">
                <div id="fileViewerContent" style="height: 100%; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                    <div class="text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading file...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* File Viewer Modal Styles */
#fileViewerModal .modal-dialog {
    max-width: 95vw;
    margin: 1rem auto;
}

#fileViewerModal .modal-content {
    border-radius: 8px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}

#fileViewerModal .modal-header {
    padding: 1rem 1.5rem;
    border-radius: 8px 8px 0 0;
}

#fileViewerModal .modal-title {
    font-weight: 600;
    color: #333;
    margin: 0;
}

#fileViewerModal .modal-actions {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

#fileViewerModal .modal-body {
    border-radius: 0 0 8px 8px;
}

/* File content styling */
.file-content {
    width: 100%;
    height: 100%;
    border: none;
    background: white;
}

.file-content.pdf {
    width: 100%;
    height: 100%;
}

.file-content.image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.file-unsupported {
    text-align: center;
    padding: 2rem;
    color: #666;
}

.file-unsupported i {
    font-size: 3rem;
    color: #ccc;
    margin-bottom: 1rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #fileViewerModal .modal-dialog {
        max-width: 100vw;
        margin: 0;
        height: 100vh;
    }
    
    #fileViewerModal .modal-content {
        height: 100vh;
        border-radius: 0;
    }
    
    #fileViewerModal .modal-body {
        height: calc(100vh - 80px);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = new bootstrap.Modal(document.getElementById('fileViewerModal'));
    const modalTitle = document.getElementById('modalFileName');
    const modalContent = document.getElementById('fileViewerContent');
    const modalDownloadBtn = document.getElementById('modalDownloadBtn');
    
    // Handle view file button clicks
    document.querySelectorAll('.view-file-btn').forEach(button => {
        button.addEventListener('click', function() {
            const fileName = this.getAttribute('data-file-name');
            const fileType = this.getAttribute('data-file-type');
            const viewUrl = this.getAttribute('data-view-url');
            const downloadUrl = this.getAttribute('data-download-url');
            
            // Update modal title and download link
            modalTitle.textContent = fileName;
            modalDownloadBtn.href = downloadUrl;
            
            // Show loading state
            modalContent.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading file...</p>
                </div>
            `;
            
            // Show modal
            modal.show();
            
            // Load file content
            loadFileContent(viewUrl, fileType, fileName);
        });
    });
    
    function loadFileContent(url, fileType, fileName) {
        // Determine how to display the file based on type
        if (fileType.startsWith('image/')) {
            // Display images directly
            modalContent.innerHTML = `
                <img src="${url}" class="file-content image" alt="${fileName}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            `;
        } else if (fileType === 'application/pdf') {
            // Display PDFs in iframe
            modalContent.innerHTML = `
                <iframe src="${url}" class="file-content pdf" frameborder="0"></iframe>
            `;
        } else if (fileType.startsWith('text/')) {
            // Display text files in iframe
            modalContent.innerHTML = `
                <iframe src="${url}" class="file-content" frameborder="0"></iframe>
            `;
        } else if (fileType === 'application/zip' || fileType === 'application/x-zip-compressed') {
            // Handle ZIP files
            modalContent.innerHTML = `
                <div class="file-unsupported">
                    <i class="icofont-file-zip" style="font-size: 3rem; color: #007bff; margin-bottom: 1rem;"></i>
                    <h5>ZIP Archive</h5>
                    <p>This is a compressed archive file.</p>
                    <p>Download and extract it to view the contents.</p>
                    <div class="mt-3">
                        <a href="${url}" class="btn btn-primary" download>
                            <i class="icofont-download"></i> Download ZIP File
                        </a>
                    </div>
                </div>
            `;
        } else if (fileType === 'application/msword' || fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
            // Handle Word documents
            modalContent.innerHTML = `
                <div class="file-unsupported">
                    <i class="icofont-file-doc" style="font-size: 3rem; color: #2b579a; margin-bottom: 1rem;"></i>
                    <h5>Microsoft Word Document</h5>
                    <p>This is a Word document (.doc/.docx).</p>
                    <p>Download it to open with Microsoft Word or compatible software.</p>
                    <div class="mt-3">
                        <a href="${url}" class="btn btn-primary" download>
                            <i class="icofont-download"></i> Download Word Document
                        </a>
                    </div>
                </div>
            `;
        } else if (fileType === 'application/vnd.ms-excel' || fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
            // Handle Excel documents
            modalContent.innerHTML = `
                <div class="file-unsupported">
                    <i class="icofont-file-excel" style="font-size: 3rem; color: #217346; margin-bottom: 1rem;"></i>
                    <h5>Microsoft Excel Spreadsheet</h5>
                    <p>This is an Excel spreadsheet (.xls/.xlsx).</p>
                    <p>Download it to open with Microsoft Excel or compatible software.</p>
                    <div class="mt-3">
                        <a href="${url}" class="btn btn-primary" download>
                            <i class="icofont-download"></i> Download Excel File
                        </a>
                    </div>
                </div>
            `;
        } else {
            // For other unsupported file types, show a generic message
            modalContent.innerHTML = `
                <div class="file-unsupported">
                    <i class="icofont-file-alt"></i>
                    <h5>Preview not available</h5>
                    <p>This file type cannot be previewed in the browser.</p>
                    <p>Click the download button to save the file to your device.</p>
                    <div class="mt-3">
                        <a href="${url}" class="btn btn-primary" download>
                            <i class="icofont-download"></i> Download File
                        </a>
                    </div>
                </div>
            `;
        }
    }
});
</script>

@endsection
