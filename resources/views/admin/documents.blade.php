@extends('layout.app')

@push('styles')
<style>
    /* Modern Documents Page Styles */
    .documents-hero {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 50%, #dee2e6 100%);
        padding: 80px 0 60px;
        position: relative;
        overflow: hidden;
    }

    .documents-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="docs-grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(108,117,125,0.08)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23docs-grid)" /></svg>');
        opacity: 0.7;
    }

    .documents-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: 700;
        color: #343a40;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #343a40 0%, #6c757d 50%, #adb5bd 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 2rem;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        margin-top: 2rem;
    }

    .stat-item {
        text-align: center;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: #007bff;
        display: block;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .search-filter-section {
        background: white;
        padding: 2rem 0;
        border-bottom: 1px solid #e9ecef;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .search-box {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input {
        width: 100%;
        padding: 15px 50px 15px 20px;
        border: 2px solid #e9ecef;
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }

    .search-input:focus {
        outline: none;
        border-color: #007bff;
        background: white;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .search-btn {
        position: absolute;
        right: 5px;
        top: 50%;
        transform: translateY(-50%);
        background: #007bff;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #0056b3;
        transform: translateY(-50%) scale(1.05);
    }

    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-top: 1.5rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 8px 20px;
        border: 2px solid #e9ecef;
        border-radius: 25px;
        background: white;
        color: #6c757d;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .filter-tab:hover,
    .filter-tab.active {
        border-color: #007bff;
        background: #007bff;
        color: white;
        text-decoration: none;
    }

    .documents-section {
        padding: 3rem 0;
        background: #f8f9fa;
        min-height: 60vh;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .view-toggles {
        display: flex;
        gap: 0.5rem;
    }

    .view-toggle {
        width: 40px;
        height: 40px;
        border: 2px solid #e9ecef;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6c757d;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .view-toggle:hover,
    .view-toggle.active {
        border-color: #007bff;
        background: #007bff;
        color: white;
        text-decoration: none;
    }

    /* Modern Document Card Design */
    .document-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        margin-bottom: 2rem;
        border: 1px solid #f1f3f4;
    }

    .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
    }

    .document-card-header {
        position: relative;
        height: 200px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .document-icon {
        width: 80px;
        height: 80px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(10px);
    }

    .document-icon i {
        font-size: 2.5rem;
        color: white;
    }

    .document-type-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
        color: #495057;
    }

    .pdf-card .document-card-header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    }

    .word-card .document-card-header {
        background: linear-gradient(135deg, #4834d4 0%, #686de0 100%);
    }

    .document-card-body {
        padding: 1.5rem;
    }

    .document-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }

    .document-title a {
        color: inherit;
        text-decoration: none;
    }

    .document-title a:hover {
        color: #007bff;
    }

    .document-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: #6c757d;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .document-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .action-btn {
        flex: 1;
        padding: 8px 12px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: white;
        color: #6c757d;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.3rem;
    }

    .action-btn:hover {
        text-decoration: none;
    }

    .action-btn.primary {
        border-color: #007bff;
        background: #007bff;
        color: white;
    }

    .action-btn.primary:hover {
        background: #0056b3;
        border-color: #0056b3;
        color: white;
    }

    .action-btn.secondary:hover {
        border-color: #6c757d;
        background: #6c757d;
        color: white;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        padding-top: 1rem;
        border-top: 1px solid #f1f3f4;
        margin-top: 1rem;
    }

    .instructor-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .instructor-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
    }

    .no-documents {
        text-align: center;
        padding: 4rem 2rem;
        color: #6c757d;
    }

    .no-documents i {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #dee2e6;
    }

    /* List View Styles */
    .list-view .document-card {
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .list-view .document-card-header {
        height: 80px;
        width: 80px;
        border-radius: 12px;
        margin: 1rem;
        flex-shrink: 0;
    }

    .list-view .document-card {
        display: flex;
        align-items: center;
    }

    .list-view .document-card-body {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem 1.5rem 1rem 0;
    }

    .list-view .document-info {
        flex: 1;
    }

    .list-view .document-actions {
        margin-top: 0;
        flex-shrink: 0;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }

        .hero-stats {
            gap: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .filter-tabs {
            gap: 0.5rem;
        }

        .filter-tab {
            padding: 6px 15px;
            font-size: 0.9rem;
        }

        .section-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .document-actions {
            flex-direction: column;
        }

        .list-view .document-card {
            flex-direction: column;
            text-align: center;
        }

        .list-view .document-card-header {
            margin: 1rem auto 0;
        }

        .list-view .document-card-body {
            flex-direction: column;
            padding: 1rem;
        }

        .list-view .document-actions {
            margin-top: 1rem;
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<!-- Hero Section -->
<div class="documents-hero">
    <div class="container">
        <div class="documents-hero-content">
            <h1 class="hero-title">University Document Archive</h1>
            <p class="hero-subtitle">Explore our comprehensive collection of academic resources and examination materials</p>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <span class="stat-number">{{ count($exams) > 0 ? count($exams[0] ?? []) + count($exams[1] ?? []) : 0 }}</span>
                    <div class="stat-label">Total Documents</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ count($exams) > 0 && isset($exams[0]) ? count($exams[0]) : 0 }}</span>
                    <div class="stat-label">Exam Papers</div>
                </div>
                <div class="stat-item">
                    <span class="stat-number">{{ count($exams) > 1 && isset($exams[1]) ? count($exams[1]) : 0 }}</span>
                    <div class="stat-label">Files</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filter Section -->
<div class="search-filter-section">
    <div class="container">
        <div class="search-box">
            <input type="text" class="search-input" id="searchInput" placeholder="Search documents, courses, or instructors...">
            <button class="search-btn" onclick="performSearch()">
                <i class="icofont-search-1"></i>
            </button>
        </div>
        
        <div class="filter-tabs">
            <a href="#" class="filter-tab active" data-filter="all">All Documents</a>
            <a href="#" class="filter-tab" data-filter="exam">Exam Papers</a>
            <a href="#" class="filter-tab" data-filter="file">Files</a>
            <a href="#" class="filter-tab" data-filter="pdf">PDF</a>
            <a href="#" class="filter-tab" data-filter="word">Word</a>
        </div>
    </div>
</div>

<!-- Documents Section -->
<div class="documents-section">
    <div class="container">
        <div class="section-header">
            <h3 style="margin: 0; color: #343a40; font-weight: 600;">Available Documents</h3>
            <div class="view-toggles">
                <a href="#" class="view-toggle active" data-view="grid" title="Grid View">
                    <i class="icofont-layout"></i>
                </a>
                <a href="#" class="view-toggle" data-view="list" title="List View">
                    <i class="icofont-listine-dots"></i>
                </a>
            </div>
        </div>

        <div class="row" id="documents-container">
            @if (count($exams) > 0)
                @foreach ($exams as $result)
                    @foreach ($result as $exam)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-12 document-item" 
                             data-type="{{ $exam instanceof \App\Models\Exam ? 'exam' : 'file' }}"
                             data-format="{{ $exam instanceof \App\Models\Exam ? strtolower(pathinfo($exam->exam_document, PATHINFO_EXTENSION)) : strtolower(pathinfo($exam->document_file, PATHINFO_EXTENSION)) }}">
                            
                            @if ($exam instanceof \App\Models\Exam)
                                <!-- Exam Document Card -->
                                @php
                                    $extension = pathinfo($exam->exam_document, PATHINFO_EXTENSION);
                                @endphp
                                <div class="document-card {{ strtolower($extension) }}-card">
                                    <div class="document-card-header">
                                        <div class="document-icon">
                                            @if (strtolower($extension) == 'pdf')
                                                <i class="icofont-file-pdf"></i>
                                            @else
                                                <i class="icofont-file-word"></i>
                                            @endif
                                        </div>
                                        <div class="document-type-badge">{{ strtoupper($extension) }}</div>
                                    </div>
                                    
                                    <div class="document-card-body">
                                        <h4 class="document-title">
                                            <a href="#" title="{{ $exam->course_title }}">{{ $exam->course_title }}</a>
                                        </h4>
                                        
                                        <div class="document-meta">
                                            <div class="meta-item">
                                                <i class="icofont-book-alt"></i>
                                                <span>{{ $exam->exam_format }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="icofont-clock-time"></i>
                                                <span>{{ $exam->duration }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="document-actions">
                                            <a href="{{ asset($exam->exam_document) }}" download class="action-btn primary">
                                                <i class="icofont-download"></i>
                                                Paper
                                            </a>
                                            @if($exam->answer_key)
                                                <a href="{{ asset($exam->answer_key) }}" download class="action-btn secondary">
                                                    <i class="icofont-download"></i>
                                                    Answer Key
                                                </a>
                                            @endif
                                        </div>
                                        
                                        <div class="instructor-info">
                                            <div class="instructor-avatar">
                                                {{ substr($exam->instructor_name, 0, 1) }}
                                            </div>
                                            <div class="instructor-name">{{ $exam->instructor_name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- File Document Card -->
                                @php
                                    $extension = pathinfo($exam->document_file, PATHINFO_EXTENSION);
                                @endphp
                                <div class="document-card {{ strtolower($extension) }}-card">
                                    <div class="document-card-header">
                                        <div class="document-icon">
                                            @if (strtolower($extension) == 'pdf')
                                                <i class="icofont-file-pdf"></i>
                                            @else
                                                <i class="icofont-file-word"></i>
                                            @endif
                                        </div>
                                        <div class="document-type-badge">{{ strtoupper($extension) }}</div>
                                    </div>
                                    
                                    <div class="document-card-body">
                                        <h4 class="document-title">
                                            <a href="#" title="{{ $exam->document_title }}">{{ $exam->document_title }}</a>
                                        </h4>
                                        
                                        <div class="document-meta">
                                            <div class="meta-item">
                                                <i class="icofont-file-alt"></i>
                                                <span>{{ $exam->file_format }}</span>
                                            </div>
                                            <div class="meta-item">
                                                <i class="icofont-calendar"></i>
                                                <span>{{ $exam->year_deposit }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="document-actions">
                                            <a href="{{ Storage::url($exam->document_file) }}" download class="action-btn primary">
                                                <i class="icofont-download"></i>
                                                Download File
                                            </a>
                                        </div>
                                        
                                        <div class="instructor-info">
                                            <div class="instructor-avatar">
                                                {{ substr($exam->depositor_name, 0, 1) }}
                                            </div>
                                            <div class="instructor-name">{{ $exam->depositor_name }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @endforeach
            @else
                <div class="col-12">
                    <div class="no-documents">
                        <i class="icofont-file-document"></i>
                        <h4>No Documents Available</h4>
                        <p>There are currently no documents in the archive. Check back later for updates.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@include('components.footer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View Toggle Functionality
    const viewToggles = document.querySelectorAll('.view-toggle');
    const container = document.getElementById('documents-container');
    
    viewToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all toggles
            viewToggles.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Toggle view
            const view = this.dataset.view;
            if (view === 'list') {
                container.classList.add('list-view');
            } else {
                container.classList.remove('list-view');
            }
        });
    });
    
    // Filter Functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Remove active class from all tabs
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter documents
            const filter = this.dataset.filter;
            filterDocuments(filter);
        });
    });
    
    // Search Functionality
    const searchInput = document.getElementById('searchInput');
    let searchTimeout;
    
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            performSearch();
        }, 300);
    });
});

function filterDocuments(filter) {
    const items = document.querySelectorAll('.document-item');
    
    items.forEach(item => {
        const type = item.dataset.type;
        const format = item.dataset.format;
        
        let show = false;
        
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'exam':
                show = type === 'exam';
                break;
            case 'file':
                show = type === 'file';
                break;
            case 'pdf':
                show = format === 'pdf';
                break;
            case 'word':
                show = format === 'doc' || format === 'docx';
                break;
        }
        
        if (show) {
            item.style.display = 'block';
            item.style.animation = 'fadeIn 0.3s ease';
        } else {
            item.style.display = 'none';
        }
    });
}

function performSearch() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.document-item');
    
    items.forEach(item => {
        const title = item.querySelector('.document-title a').textContent.toLowerCase();
        const instructor = item.querySelector('.instructor-name').textContent.toLowerCase();
        const meta = item.querySelector('.document-meta').textContent.toLowerCase();
        
        const matches = title.includes(searchTerm) || 
                       instructor.includes(searchTerm) || 
                       meta.includes(searchTerm);
        
        if (matches || searchTerm === '') {
            item.style.display = 'block';
            item.style.animation = 'fadeIn 0.3s ease';
        } else {
            item.style.display = 'none';
        }
    });
}

// Add CSS animation
const style = document.createElement('style');
style.textContent = `
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
`;
document.head.appendChild(style);
</script>
@endpush