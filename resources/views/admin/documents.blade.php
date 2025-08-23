@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<!-- Modern Portfolio Header -->
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
                        <span>Document Portfolio</span>
                    </div>
                    </div>
                </div>

            <div class="portfolio-header-main">
                <div class="portfolio-title-section">
                    <h1 class="portfolio-title">Academic Document Portfolio</h1>
                    <p class="portfolio-subtitle">Comprehensive collection of academic resources, examination papers, and research documents</p>
                </div>
                
                <div class="portfolio-stats-cards">
                    <div class="stat-card exam-stats">
                        <div class="stat-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ count($exams['exams']) ?? 0 }}</div>
                            <div class="stat-label">Examination Papers</div>
                        </div>
                    </div>
                    <div class="stat-card file-stats">
                        <div class="stat-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ count($exams['files']) ?? 0 }}</div>
                            <div class="stat-label">Academic Files</div>
                        </div>
                    </div>
                    <div class="stat-card total-stats">
                        <div class="stat-icon">
                            <i class="fas fa-database"></i>
                        </div>
                        <div class="stat-content">
                            <div class="stat-number">{{ (count($exams['exams']) ?? 0) + (count($exams['files']) ?? 0) }}</div>
                            <div class="stat-label">Total Documents</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modern Portfolio Content -->
<div class="portfolio-content-section">
    <div class="container-fluid">
        <div class="portfolio-layout">
            
            <!-- Advanced Search and Filter Controls -->
            <div class="portfolio-controls">
                <div class="search-controls-wrapper">
                    <!-- Search Bar -->
                    <div class="advanced-search-bar">
                        <form action="{{ route('exam.search') }}" method="GET" class="search-form">
                            <div class="search-input-group">
                                <div class="search-icon">
                                    <i class="fas fa-search"></i>
                                </div>
                                <input type="text" name="query" placeholder="Search documents, courses, instructors..." class="search-input" autocomplete="off">
                                <button type="submit" class="search-submit-btn">
                                    <span>Search</span>
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- View Options -->
                    <div class="view-controls">
                        <div class="view-toggle-group">
                            <button class="view-toggle active" data-view="grid" title="Grid View">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button class="view-toggle" data-view="list" title="List View">
                                <i class="fas fa-list"></i>
                            </button>
                            <button class="view-toggle" data-view="compact" title="Compact View">
                                <i class="fas fa-th"></i>
                            </button>
                        </div>
                        
                        <div class="sort-controls">
                            <select class="modern-select" id="sortSelect">
                                <option value="newest">Newest First</option>
                                <option value="oldest">Oldest First</option>
                                <option value="title">Title A-Z</option>
                                <option value="course">Course Code</option>
                                <option value="instructor">Instructor</option>
                                      </select>
                        </div>
                    </div>
                </div>

                <!-- Filter Tags -->
                <div class="filter-tags-container">
                    <div class="active-filters" id="activeFilters">
                        <!-- Active filter tags will be populated here -->
                    </div>
                    <button class="clear-filters-btn" id="clearFilters" style="display: none;">
                        <i class="fas fa-times"></i>
                        <span>Clear All Filters</span>
                    </button>
                </div>
            </div>
            <!-- Modern Sidebar Filters -->
            <div class="portfolio-sidebar">
                <div class="filter-sidebar">
                    <div class="sidebar-header">
                        <h3 class="sidebar-title">
                            <i class="fas fa-filter"></i>
                            <span>Filter Documents</span>
                        </h3>
                        <button class="mobile-filter-toggle">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    
                    <!-- Document Type Filter -->
                    <div class="filter-section">
                        <div class="filter-header">
                            <h4 class="filter-title">Document Type</h4>
                            <button class="filter-expand" data-target="document-type">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="filter-content" id="document-type">
                            <div class="filter-option">
                                <label class="custom-checkbox">
                                    <input type="checkbox" class="filter-checkbox" name="document_type" value="exam">
                                    <span class="checkmark"></span>
                                    <span class="option-text">
                                        <i class="fas fa-file-alt"></i>
                                        Examination Papers
                                    </span>
                                </label>
                            </div>
                            <div class="filter-option">
                                <label class="custom-checkbox">
                                    <input type="checkbox" class="filter-checkbox" name="document_type" value="file">
                                    <span class="checkmark"></span>
                                    <span class="option-text">
                                        <i class="fas fa-folder"></i>
                                        Academic Files
                                    </span>
                                </label>
                            </div>
                        </div>
                </div>

                    <!-- Faculty Filter -->
                    <div class="filter-section">
                        <div class="filter-header">
                            <h4 class="filter-title">Faculties & Departments</h4>
                            <button class="filter-expand" data-target="faculties">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="filter-content" id="faculties">
                                @if (count($faculties) > 0)
                                @foreach ($faculties as $faculty)
                                <div class="filter-option">
                                    <label class="custom-checkbox">
                                            <input type="checkbox" class="filter-checkbox faculty-checkbox" value="{{$faculty}}">
                                        <span class="checkmark"></span>
                                        <span class="option-text">{{ $faculty }}</span>
                                    </label>
                                </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>No faculties available</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Semester Filter -->
                    <div class="filter-section">
                        <div class="filter-header">
                            <h4 class="filter-title">Semesters</h4>
                            <button class="filter-expand" data-target="semesters">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                </div>
                        <div class="filter-content" id="semesters">
                            @if (count($semesters) > 0)
                                @foreach ($semesters as $semester)
                                <div class="filter-option">
                                    <label class="custom-checkbox">
                                            <input type="checkbox" class="filter-checkbox semester-checkbox" value="{{ $semester }}">
                                        <span class="checkmark"></span>
                                        <span class="option-text">{{ $semester }}</span>
                                        </label>
                                </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>No semesters available</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Academic Year Filter -->
                    <div class="filter-section">
                        <div class="filter-header">
                            <h4 class="filter-title">Academic Years</h4>
                            <button class="filter-expand" data-target="years">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                </div>
                        <div class="filter-content" id="years">
                            @if (count($years) > 0)
                                @foreach ($years as $year)
                                <div class="filter-option">
                                    <label class="custom-checkbox">
                                            <input type="checkbox" class="filter-checkbox year-checkbox" value="{{ $year }}">
                                        <span class="checkmark"></span>
                                        <span class="option-text">{{ $year }}</span>
                                        </label>
                                </div>
                                @endforeach
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-exclamation-circle"></i>
                                    <span>No years available</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tags Filter -->
                    @if (count($tags) > 0)
                    <div class="filter-section">
                        <div class="filter-header">
                            <h4 class="filter-title">Tags</h4>
                            <button class="filter-expand" data-target="tags">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                        <div class="filter-content" id="tags">
                            @foreach ($tags as $tag)
                            <div class="filter-option">
                                <label class="custom-checkbox">
                                    <input type="checkbox" class="filter-checkbox tag-checkbox" value="{{ $tag }}">
                                    <span class="checkmark"></span>
                                    <span class="option-text">
                                        <span class="tag-indicator"></span>
                                        {{ $tag }}
                                    </span>
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modern Document Grid -->
            <div class="portfolio-main-content">
                <!-- Loading States -->
                <div class="loading-state" id="loadingState" style="display: none;">
                    <div class="loading-animation">
                        <div class="loading-spinner"></div>
                        <span>Loading documents...</span>
                    </div>
                </div>

                <!-- Results Summary -->
                <div class="results-summary" id="resultsSummary">
                    <div class="results-info">
                        <span class="results-count">{{ (count($exams['exams']) ?? 0) + (count($exams['files']) ?? 0) }}</span>
                        <span class="results-text">documents found</span>
                    </div>
                    <button class="mobile-filter-btn" id="mobileFilterBtn">
                        <i class="fas fa-filter"></i>
                        <span>Filters</span>
                    </button>
                </div>

                <!-- Document Grid Container -->
                <div class="document-grid-container">
                    <div class="document-grid" id="documentGrid" data-view="grid">
                            @if (count($exams) > 0)
                                @foreach ($exams as $result)
                                @foreach ($result as $document)
                                    @if ($document instanceof \App\Models\Exam)
                                        <!-- Exam Document Card -->
                                        <div class="document-card exam-card" data-type="exam" data-faculty="{{ $document->faculty ?? '' }}" data-semester="{{ $document->semester ?? '' }}" data-year="{{ date('Y', strtotime($document->created_at)) }}" data-tags="{{ $document->tags ?? '' }}">
                                            <div class="card-header">
                                                <div class="document-type-badge exam-badge">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <span>Exam Paper</span>
                                                </div>
                                                <div class="document-actions">
                                                    @php
                                                        $extension = pathinfo($document->exam_document, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if ($extension === 'pdf')
                                                        <button class="action-btn preview-btn" data-url="{{ asset($document->exam_document) }}" title="Preview Document">
                                                            <i class="far fa-eye"></i>
                                                        </button>
                                                    @endif
                                                    <a href="{{ asset($document->exam_document) }}" download class="action-btn download-btn" title="Download Exam Paper">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                    @if($document->answer_key)
                                                        <a href="{{ asset($document->answer_key) }}" download class="action-btn answer-key-btn" title="Download Answer Key">
                                                            <i class="fas fa-key"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="card-thumbnail">
                                                @php
                                                    $extension = pathinfo($document->exam_document, PATHINFO_EXTENSION);
                                                @endphp
                                                <div class="document-preview">
                                                    @if ($extension == 'pdf')
                                                        <div class="file-icon pdf-icon">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </div>
                                                    @else
                                                        <div class="file-icon doc-icon">
                                                            <i class="fas fa-file-word"></i>
                                                        </div>
                                                    @endif
                                                    <div class="file-extension">{{ strtoupper($extension) }}</div>
                                                </div>
                                                <div class="course-code-overlay">{{ $document->course_code }}</div>
                                            </div>
                                            
                                            <div class="card-content">
                                                <div class="document-meta">
                                                    <div class="meta-item">
                                                        <i class="fas fa-clipboard-list"></i>
                                                        <span>{{ $document->exam_format }}</span>
                                                    </div>
                                                    <div class="meta-item">
                                                        <i class="far fa-clock"></i>
                                                        <span>{{ $document->duration }}</span>
                                                    </div>
                                                    <div class="meta-item">
                                                        <i class="far fa-calendar-alt"></i>
                                                        <span>{{ date('M Y', strtotime($document->exam_date)) }}</span>
                                                    </div>
                                                </div>
                                                
                                                <h3 class="document-title">
                                                    <a href="#" class="title-link">{{ $document->course_title }}</a>
                                                </h3>
                                                
                                                <div class="document-info">
                                                    <div class="semester-info">
                                                        <span class="semester-label">{{ $document->semester }}</span>
                                                        <span class="academic-year">{{ $document->academic_year }}</span>
                                                    </div>
                                                    <div class="faculty-info">{{ $document->faculty }}</div>
                                                </div>
                                                
                                                @if($document->answer_key)
                                                <div class="answer-key-indicator">
                                                    <div class="indicator-badge">
                                                        <i class="fas fa-key"></i>
                                                        <span>Answer Key Available</span>
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                <div class="card-footer">
                                                    <div class="instructor-info">
                                                        <div class="instructor-avatar">
                                                            <i class="fas fa-user-tie"></i>
                                                            </div>
                                                        <div class="instructor-details">
                                                            <span class="instructor-name">{{ $document->instructor_name }}</span>
                                                            <span class="instructor-role">Instructor</span>
                                                        </div>
                                                    </div>
                                                    <div class="upload-date">
                                                        <span>{{ $document->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <!-- File Document Card -->
                                        <div class="document-card file-card" data-type="file" data-year="{{ date('Y', strtotime($document->year_created)) }}">
                                            <div class="card-header">
                                                <div class="document-type-badge file-badge">
                                                    <i class="fas fa-archive"></i>
                                                    <span>Academic File</span>
                                                </div>
                                                <div class="document-actions">
                                                    @php
                                                        $fileExtension = pathinfo($document->document_file, PATHINFO_EXTENSION);
                                                    @endphp
                                                    @if($fileExtension === 'pdf')
                                                        <button class="action-btn preview-btn" data-url="{{ asset($document->document_file) }}" title="Preview Document">
                                                            <i class="far fa-eye"></i>
                                                        </button>
                                                    @endif
                                                    <a href="{{ asset($document->document_file) }}" download class="action-btn download-btn" title="Download File">
                                                        <i class="fas fa-download"></i>
                                                </a>
                                                </div>
                                            </div>
                                            
                                            <div class="card-thumbnail">
                                                <div class="document-preview">
                                                    @if ($fileExtension == 'pdf')
                                                        <div class="file-icon pdf-icon">
                                                            <i class="fas fa-file-pdf"></i>
                                                        </div>
                                                    @else
                                                        <div class="file-icon doc-icon">
                                                            <i class="fas fa-file-alt"></i>
                                                        </div>
                                                    @endif
                                                    <div class="file-extension">{{ strtoupper($fileExtension) }}</div>
                                                </div>
                                                <div class="file-type-overlay">{{ $document->file_format }}</div>
                                            </div>
                                            
                                            <div class="card-content">
                                                <div class="document-meta">
                                                    <div class="meta-item">
                                                        <i class="fas fa-file-code"></i>
                                                        <span>{{ $document->file_format }}</span>
                                                    </div>
                                                    <div class="meta-item">
                                                        <i class="far fa-calendar-plus"></i>
                                                        <span>{{ date('M Y', strtotime($document->year_created)) }}</span>
                                                    </div>
                                                    <div class="meta-item">
                                                        <i class="fas fa-university"></i>
                                                        <span>{{ $document->unit }}</span>
                                                    </div>
                                                </div>
                                                
                                                <h3 class="document-title">
                                                    <a href="#" class="title-link">{{ $document->file_title }}</a>
                                                </h3>
                                                
                                                <div class="document-info">
                                                    <div class="file-details">
                                                        <span class="file-unit">{{ $document->unit }}</span>
                                                        <span class="deposit-date">Deposited: {{ date('M Y', strtotime($document->year_deposit)) }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="file-size-info">
                                                    <div class="size-badge">
                                                        <i class="fas fa-database"></i>
                                                        <span>{{ $document->file_format }}</span>
                                                    </div>
                                                </div>
                                                
                                                <div class="card-footer">
                                                    <div class="depositor-info">
                                                        <div class="depositor-avatar">
                                                            <i class="fas fa-user"></i>
                                                            </div>
                                                        <div class="depositor-details">
                                                            <span class="depositor-name">{{ $document->depositor_name }}</span>
                                                            <span class="depositor-role">Depositor</span>
                                                        </div>
                                                    </div>
                                                    <div class="upload-date">
                                                        <span>{{ $document->created_at->diffForHumans() }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                @endforeach
                                @endforeach
                            @else
                            <div class="empty-state-container">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-folder-open"></i>
                                    </div>
                                    <h3 class="empty-title">No Documents Found</h3>
                                    <p class="empty-description">There are no documents matching your current filters. Try adjusting your search criteria or browse all documents.</p>
                                    <button class="clear-filters-btn">
                                        <i class="fas fa-refresh"></i>
                                        <span>Clear All Filters</span>
                                    </button>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>

                <!-- Advanced Pagination -->
                <div class="pagination-container" id="paginationContainer">
                    <div class="pagination-info">
                        <span>Showing <strong>1-{{ min(20, (count($exams['exams']) ?? 0) + (count($exams['files']) ?? 0)) }}</strong> of <strong>{{ (count($exams['exams']) ?? 0) + (count($exams['files']) ?? 0) }}</strong> documents</span>
                    </div>
                    <div class="pagination-controls">
                        <button class="pagination-btn prev-btn" disabled>
                            <i class="fas fa-chevron-left"></i>
                            <span>Previous</span>
                        </button>
                        <div class="pagination-numbers">
                            <button class="pagination-number active">1</button>
                        </div>
                        <button class="pagination-btn next-btn" disabled>
                            <span>Next</span>
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    <div class="pagination-options">
                        <select class="items-per-page-select" id="itemsPerPage">
                            <option value="20">20 per page</option>
                            <option value="40">40 per page</option>
                            <option value="60">60 per page</option>
                            <option value="100">100 per page</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
                    </div>


                    {{-- <div class="tab-pane fade" id="projects__two" role="tabpanel" aria-labelledby="projects__two">

                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_1.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge">Data & Tech</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Become a product Manager learn the
                                                    skills & job.
                                                </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                    <i class="icofont-arrow-right"></i>
                                                </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <img loading="lazy"  src="img/grid/grid_2.png" alt="grid">
                                <div class="gridarea__small__button">
                                    <div class="grid__badge blue__color">Mechanical</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Foundation course to under stand
                                                about softwere</a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_3.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge pink__color">Development</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Strategy law and with for organization
                                                Foundation
                                            </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_4.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge green__color">Ui & UX Design</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">The business Intelligence analyst with
                                                Course & 2024
                                            </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_5.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge orange__color">Data & Tech</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Become a product Manager learn the skills & job.
                                            </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> --}}

                </div>

                <div class="main__pagination__wrapper" data-aos="fade-up">
                    {{-- {{$exams->links()}} --}}
                </div>

            </div>


        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/portfolio.js') }}"></script>
@endpush
