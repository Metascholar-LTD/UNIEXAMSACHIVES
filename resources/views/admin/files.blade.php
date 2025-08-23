@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<!-- Modern File Portfolio Header -->
<div class="portfolio-header-section">
    <div class="container-fluid">
        <div class="portfolio-header-content">
            <div class="portfolio-breadcrumb">
                <div class="breadcrumb-wrapper">
                    <div class="breadcrumb-item">
                        <a href="{{route('dashboard')}}" class="breadcrumb-link">
                            <i class="fas fa-home"></i>
                            <span>Dashboard</span>
                        </a>
                    </div>
                    <div class="breadcrumb-divider">
                        <i class="fas fa-chevron-right"></i>
                    </div>
                    <div class="breadcrumb-item current">
                        <span>File Class Portfolio</span>
                    </div>
                </div>
            </div>
            
            <div class="portfolio-header-main">
                <div class="portfolio-title-section">
                    <h1 class="portfolio-title">File Class Portfolio</h1>
                    <p class="portfolio-subtitle">Comprehensive management interface for academic files and documents</p>
                </div>
                
                <div class="portfolio-stats-cards">
                    <div class="stat-card file-stats">
                        <div class="stat-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ count($files) }}</div>
                            <div class="stat-label">Total Files</div>
                        </div>
                    </div>
                    <div class="stat-card exam-stats">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $files->where('is_approve', 1)->count() }}</div>
                            <div class="stat-label">Approved</div>
                        </div>
                    </div>
                    <div class="stat-card total-stats">
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ $files->where('is_approve', 0)->count() }}</div>
                            <div class="stat-label">Pending</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modern File Management Content -->
<div class="portfolio-content-section">
    <div class="container-fluid">
        @include('components.sidebar')
        <div class="modern-dashboard-layout">
            <div class="dashboard-main-content">
                <div class="dashboard-section-header">
                    <h2 class="section-title">File Management Dashboard</h2>
                    <p class="section-subtitle">View, manage, and approve academic files</p>
                </div>
                <div class="modern-file-grid">
                    @if (count($files) > 0)
                        @foreach ($files as $file)
                            <div class="file-card" data-file-id="{{ $file->id }}">
                                <div class="file-card-header">
                                    <div class="file-type-badge">
                                        @php
                                            $extension = pathinfo($file->document_file, PATHINFO_EXTENSION);
                                        @endphp
                                        <i class="fas fa-{{ $extension === 'pdf' ? 'file-pdf' : 'file-alt' }}"></i>
                                        <span>{{ strtoupper($extension) }}</span>
                                    </div>
                                    <div class="file-status">
                                        @if ($file->is_approve)
                                            <span class="status-badge approved">
                                                <i class="fas fa-check"></i>
                                                Approved
                                            </span>
                                        @else
                                            <span class="status-badge pending">
                                                <i class="fas fa-clock"></i>
                                                Pending
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="file-card-body">
                                    <h3 class="file-title">{{ $file->file_title }}</h3>
                                    <div class="file-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-user"></i>
                                            <span>{{ $file->depositor_name }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-building"></i>
                                            <span>{{ $file->unit }}</span>
                                        </div>
                                        <div class="meta-item">
                                            <i class="fas fa-calendar"></i>
                                            <span>{{ date('M Y', strtotime($file->year_created)) }}</span>
                                        </div>
                                    </div>
                                    <div class="file-format">
                                        Format: <strong>{{ $file->file_format }}</strong>
                                    </div>
                                </div>
                                
                                <div class="file-card-footer">
                                    <div class="file-actions">
                                        @if($extension === 'pdf')
                                            <button class="action-btn preview" data-url="{{ asset($file->document_file) }}" title="Preview">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        @endif
                                        <a href="{{ asset($file->document_file) }}" download class="action-btn download" title="Download">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @if (!$file->is_approve)
                                            <form action="{{ route('file.approve', $file->id) }}" method="post" class="inline-form">
                                                @csrf
                                                <button type="submit" class="action-btn approve" title="Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('file.destroy', $file->id) }}" method="post" class="inline-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="file-date">
                                        <small>{{ $file->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="empty-state-full">
                            <div class="empty-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <h3>No Files Found</h3>
                            <p>You haven't uploaded any files yet. Start by uploading your first academic file.</p>
                            <a href="{{ route('dashboard.file.create') }}" class="empty-action-btn">
                                <i class="fas fa-plus"></i>
                                Upload File
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- File Preview Modal -->
<div class="document-preview-modal" id="documentPreviewModal">
    <div class="modal-backdrop" id="modalBackdrop"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">File Preview</h3>
            <button class="modal-close-btn" id="modalCloseBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-content">
            <iframe id="documentPreviewFrame" src="" frameborder="0"></iframe>
        </div>
        <div class="modal-footer">
            <button class="modal-btn secondary" id="modalCloseFooterBtn">Close</button>
            <a href="" id="modalDownloadBtn" class="modal-btn primary" download>
                <i class="fas fa-download"></i>
                Download
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/portfolio.js') }}"></script>
@endpush
