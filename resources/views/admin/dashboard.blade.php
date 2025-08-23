@extends('layout.app')

@push('styles')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Recent Exams List View Styles */
    .recent-exams-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .recent-exam-card {
        display: flex;
        align-items: center;
        border-radius: 12px;
        padding: 1.25rem;
        min-height: 100px;
        background: white;
        border: 1px solid #f1f3f4;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .recent-exam-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 12px 0 0 12px;
    }

    .recent-exam-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .exam-card-header {
        height: 60px;
        width: 60px;
        border-radius: 12px;
        margin-right: 1rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .exam-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .exam-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .exam-card-body {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
    }

    .exam-main-info {
        flex: 1;
        min-width: 0;
        max-width: 300px;
    }

    .exam-title {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
        line-height: 1.3;
    }

    .exam-title a {
        color: inherit;
        text-decoration: none;
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
        display: block;
        max-width: 100%;
        word-wrap: break-word;
    }

    .exam-title a:hover {
        color: #007bff;
    }

    .exam-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .exam-meta .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .meta-item i {
        color: #007bff;
        font-size: 0.9rem;
        width: 16px;
        text-align: center;
    }

    .exam-instructor-section {
        min-width: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
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
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .instructor-avatar i {
        font-size: 1rem;
    }

    .instructor-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    .exam-actions {
        display: flex;
        gap: 0.5rem;
        min-width: 120px;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 0.1rem;
    }

    .action-btn {
        padding: 8px;
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
        min-width: 36px;
        height: 36px;
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

    .exam-status {
        min-width: 110px;
        display: flex;
        justify-content: center;
        flex-shrink: 0;
        margin-left: 0.1rem;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .exam-card-body {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .exam-main-info {
            max-width: 100%;
            min-width: 0;
        }
        
        .exam-instructor-section,
        .exam-actions,
        .exam-status {
            min-width: auto;
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .recent-exam-card {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
        }

        .exam-card-header {
            margin: 0 auto 1rem;
        }

        .exam-card-body {
            flex-direction: column;
            align-items: center;
            padding: 0;
            width: 100%;
        }

        .exam-main-info {
            text-align: center;
            margin-bottom: 1rem;
            width: 100%;
        }

        .exam-title {
            max-width: 100%;
            white-space: normal;
            text-align: center;
        }

        .exam-meta {
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .exam-instructor-section {
            justify-content: center;
            margin: 1rem 0;
            min-width: auto;
        }

        .exam-actions {
            margin-top: 1rem;
            width: 100%;
            justify-content: center;
        }

        .action-btn {
            flex: 1;
            max-width: 150px;
        }
    }
</style>
@endpush

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

                                        <div class="dashboard__section__title clean-section-title">
                                            <div class="title-content">
                                                <h4><i class="icofont-document"></i> Recent Uploaded Exams</h4>
                                            </div>
                                            <a href="{{route('dashboard.all.upload.document')}}" class="clean-see-more-btn">
                                                View All
                                            </a>
                                        </div>

                                        @if (count($recentlyUploadedExams) > 0)
                                            <div class="recent-exams-list">
                                                @foreach ($recentlyUploadedExams as $item )
                                                <div class="recent-exam-card" data-exam-id="{{ $item->id }}">
                                                    <div class="exam-card-header">
                                                        <div class="exam-header-info">
                                                            <div class="exam-icon">
                                                                @php
                                                                    $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);
                                                                @endphp
                                                                @if ($extension == 'pdf')
                                                                    <i class="icofont-file-pdf"></i>
                                                                @else
                                                                    <i class="icofont-file-word"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="exam-card-body">
                                                        <div class="exam-main-info">
                                                            <h4 class="exam-title">
                                                                <a href="#" title="{{ $item->course_title }} - {{ $item->course_code }}">{{ $item->course_title }} - {{ $item->course_code }}</a>
                                                            </h4>
                                                            <div class="exam-meta">
                                                                <div class="meta-item">
                                                                    <i class="fas fa-file-alt"></i>
                                                                    <span>{{ $item->exam_format }}</span>
                                                                </div>
                                                                <div class="meta-item">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span>{{ $item->duration }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="exam-instructor-section">
                                                            <div class="instructor-info">
                                                                <div class="instructor-avatar">
                                                                    <i class="fas fa-user-graduate"></i>
                                                                </div>
                                                                <div class="instructor-name">{{ $item->instructor_name }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="exam-actions">
                                                            <a href="{{ asset($item->exam_document) }}" download class="action-btn primary" title="Download Exam Paper">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            @if($item->answer_key)
                                                                <a href="{{ asset($item->answer_key) }}" download class="action-btn secondary" title="Download Answer Key">
                                                                    <i class="fas fa-key"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="exam-status">
                                                            @if($item->is_approve)
                                                                <span class="status-badge approved">
                                                                    <i class="fas fa-check-circle"></i>
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
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="clean-empty-state">
                                                <i class="icofont-document"></i>
                                                <p>No exams uploaded yet</p>
                                                <a href="{{route('dashboard.create')}}" class="clean-upload-btn">
                                                    Upload First Exam
                                                </a>
                                            </div>
                                        @endif
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

<script>
// Simple success message function for downloads
function showDownloadSuccess(message) {
    // Create a simple success notification
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    
    // Add animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
    
    // Add slideOut animation
    const slideOutStyle = document.createElement('style');
    slideOutStyle.textContent = `
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(slideOutStyle);
}

// Add click event listeners to download buttons
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-btn, .key-btn');
    
    downloadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isAnswerKey = this.classList.contains('key-btn');
            const message = isAnswerKey ? 'Answer key download started!' : 'Exam download started!';
            showDownloadSuccess(message);
        });
    });
});
</script>

@endsection
