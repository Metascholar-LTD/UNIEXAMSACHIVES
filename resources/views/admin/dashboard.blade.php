@extends('layout.app')

@section('content')
<style>
/* Exam Card Styles */
.exam-card {
    background: #ffffff;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.exam-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.exam-card__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem 1.25rem 0.75rem;
    border-bottom: 1px solid #f8f9fa;
}

.exam-card__icon {
    display: flex;
    align-items: center;
}

.file-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.file-icon.pdf {
    background: linear-gradient(135deg, #dc3545, #c82333);
}

.file-icon.word {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.exam-card__actions {
    display: flex;
    gap: 0.5rem;
}

.exam-card__actions .btn {
    padding: 0.375rem 0.75rem;
    border-radius: 8px;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.exam-card__actions .btn:hover {
    transform: scale(1.05);
}

.exam-card__body {
    padding: 1rem 1.25rem;
}

.exam-card__title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.exam-card__title a {
    color: #2c3e50;
    transition: color 0.2s ease;
}

.exam-card__title a:hover {
    color: #007bff;
}

.exam-card__meta {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.meta-item i {
    width: 16px;
    font-size: 1rem;
}

.meta-label {
    color: #6c757d;
    font-weight: 500;
    min-width: 70px;
}

.meta-value {
    color: #495057;
    font-weight: 600;
}

.exam-card__footer {
    padding: 0.75rem 1.25rem 1.25rem;
    border-top: 1px solid #f8f9fa;
    background: #f8f9fa;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: #e3f2fd;
    color: #1976d2;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 500;
}

.status-badge.status-uploaded {
    background: #e8f5e8;
    color: #2e7d32;
}

/* Empty State Styles */
.empty-state {
    background: #f8f9fa;
    border-radius: 12px;
    border: 2px dashed #dee2e6;
}

.empty-state__icon {
    color: #adb5bd;
}

/* Dashboard Section Title Enhancement */
.dashboard__section__title h4 {
    color: #2c3e50;
    font-weight: 600;
    font-size: 1.25rem;
}

.dashboard__section__title p {
    font-size: 0.9rem;
    color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .exam-card__header {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
    
    .exam-card__actions {
        align-self: flex-end;
    }
    
    .meta-item {
        flex-wrap: wrap;
    }
    
    .meta-label {
        min-width: auto;
    }
}

/* Button enhancements */
.btn-outline-primary {
    border-width: 2px;
    font-weight: 500;
}

.btn-outline-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
}

.btn-primary {
    font-weight: 500;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
}
</style>

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
                            <h4>Dashboard</h4>
                        </div>
                        @auth
                            @if(auth()->user()->is_admin)
                            <div class="row">
                                {{-- exams --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_total_papers}}</span>

                                                </div>
                                                <p>Total Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_approve_papers}}</span>

                                                </div>
                                                <p>Approved Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_pending_papers}}</span>

                                                </div>
                                                <p>Pending Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Files --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_total_files}}</span>

                                                </div>
                                                <p>Total Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_approve_files}}</span>

                                                </div>
                                                <p>Approved Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_pending_files}}</span>

                                                </div>
                                                <p>Pending Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                            @unless(auth()->user()->is_admin)
                            <div class="row">
                                {{-- Exams --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_papers}}</span>

                                                </div>
                                                <p>Total Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_approved_papers}}</span>

                                                </div>
                                                <p>Approved Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_pending_papers}}</span>

                                                </div>
                                                <p>Pending Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Files --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_files}}</span>

                                                </div>
                                                <p>Total Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_approved_files}}</span>

                                                </div>
                                                <p>Approved Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_pending_files}}</span>

                                                </div>
                                                <p>Pending Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Users --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__2.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_users}}</span>

                                                </div>
                                                <p>Total Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$dailyVisits}}</span>

                                                </div>
                                                <p>Daily Active Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$totalVisits}}</span>

                                                </div>
                                                <p>Total Active Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            @endunless

                        @endauth

                    </div>

                    @auth
                        @unless(auth()->user()->is_admin)

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="dashboard__content__wraper admin__content__wrapper">

                                        <div class="dashboard__section__title d-flex justify-content-between align-items-center mb-4">
                                            <div>
                                                <h4 class="mb-2">
                                                    <i class="icofont-file-text me-2 text-primary"></i>
                                                    Recent Uploaded Exams Paper
                                                </h4>
                                                <p class="text-muted mb-0">Latest exam documents uploaded to the system</p>
                                            </div>
                                            <a href="{{route('dashboard.all.upload.document')}}" class="btn btn-outline-primary btn-sm">
                                                <i class="icofont-eye me-1"></i>
                                                View All
                                            </a>
                                        </div>

                                        <div class="row">
                                            @if (count($recentlyUploadedExams) > 0)
                                                @foreach ($recentlyUploadedExams as $item )
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-12 mb-4">
                                                    <div class="exam-card h-100">
                                                        <div class="exam-card__header">
                                                            <div class="exam-card__icon">
                                                                @php
                                                                $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);
                                                                @endphp
                                                                @if ($extension == 'pdf')
                                                                    <div class="file-icon pdf">
                                                                        <i class="icofont-file-pdf"></i>
                                                                    </div>
                                                                @else
                                                                    <div class="file-icon word">
                                                                        <i class="icofont-file-document"></i>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="exam-card__actions">
                                                                <a href="{{ Storage::url($item->exam_document) }}" download="" 
                                                                   class="btn btn-sm btn-primary" 
                                                                   title="Download">
                                                                    <i class="icofont-download"></i>
                                                                </a>
                                                                <a href="{{ Storage::url($item->exam_document) }}" 
                                                                   target="_blank" 
                                                                   class="btn btn-sm btn-outline-secondary" 
                                                                   title="Preview">
                                                                    <i class="icofont-eye"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="exam-card__body">
                                                            <h5 class="exam-card__title">
                                                                <a href="#" class="text-decoration-none">{{$item->course_title}}</a>
                                                            </h5>
                                                            
                                                            <div class="exam-card__meta">
                                                                <div class="meta-item">
                                                                    <i class="icofont-teacher text-primary"></i>
                                                                    <span class="meta-label">Instructor:</span>
                                                                    <span class="meta-value">{{$item->instructor_name}}</span>
                                                                </div>
                                                                
                                                                <div class="meta-item">
                                                                    <i class="icofont-book-alt text-success"></i>
                                                                    <span class="meta-label">Format:</span>
                                                                    <span class="meta-value">{{$item->exam_format}}</span>
                                                                </div>
                                                                
                                                                <div class="meta-item">
                                                                    <i class="icofont-clock-time text-warning"></i>
                                                                    <span class="meta-label">Duration:</span>
                                                                    <span class="meta-value">{{$item->duration}}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="exam-card__footer">
                                                            <div class="exam-card__status">
                                                                <span class="status-badge status-uploaded">
                                                                    <i class="icofont-upload"></i>
                                                                    Recently Uploaded
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                            <div class="col-12">
                                                <div class="empty-state text-center py-5">
                                                    <div class="empty-state__icon mb-3">
                                                        <i class="icofont-file-text text-muted" style="font-size: 4rem;"></i>
                                                    </div>
                                                    <h5 class="text-muted mb-2">No Documents Uploaded Yet</h5>
                                                    <p class="text-muted mb-3">Start by uploading your first exam paper to see it appear here.</p>
                                                    <a href="{{route('dashboard.all.upload.document')}}" class="btn btn-primary">
                                                        <i class="icofont-upload me-2"></i>
                                                        Upload First Document
                                                    </a>
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endunless
                    @endauth
                </div>
            </div>


        </div>
    </div>

</div>
@endsection
