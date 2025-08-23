@extends('layout.app')

@push('styles')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                                                @php
                                                    $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);
                                                @endphp
                                                <div class="document-card {{ strtolower($extension) }}-card" data-exam-id="{{ $item->id }}">
                                                    <div class="document-card-header">
                                                        <div class="document-header-info">
                                                            <div class="document-icon">
                                                                @if (strtolower($extension) == 'pdf')
                                                                    <i class="fas fa-file-pdf"></i>
                                                                @elseif (in_array(strtolower($extension), ['doc', 'docx']))
                                                                    <i class="fas fa-file-word"></i>
                                                                @elseif (in_array(strtolower($extension), ['xls', 'xlsx']))
                                                                    <i class="fas fa-file-excel"></i>
                                                                @elseif (in_array(strtolower($extension), ['ppt', 'pptx']))
                                                                    <i class="fas fa-file-powerpoint"></i>
                                                                @else
                                                                    <i class="fas fa-file-alt"></i>
                                                                @endif
                                                            </div>
                                                            <div class="document-type-badge">{{ strtoupper($extension) }}</div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="document-card-body">
                                                        <div class="document-main-info">
                                                            <h4 class="document-title">
                                                                <a href="#" title="{{ $item->course_title }}">{{ $item->course_title }}</a>
                                                            </h4>
                                                            <div class="document-meta">
                                                                <div class="meta-item">
                                                                    <i class="fas fa-file-alt"></i>
                                                                    <span>{{ $item->exam_format }}</span>
                                                                </div>
                                                                <div class="meta-item">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span>{{ $item->duration }}</span>
                                                                </div>
                                                                <div class="meta-item">
                                                                    <i class="fas fa-hashtag"></i>
                                                                    <span>{{ $item->course_code }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="document-instructor-section">
                                                            <div class="instructor-info">
                                                                <div class="instructor-avatar">
                                                                    <i class="fas fa-user-graduate"></i>
                                                                </div>
                                                                <div class="instructor-name">{{ $item->instructor_name }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="document-actions">
                                                            <a href="{{ asset($item->exam_document) }}" download class="action-btn primary">
                                                                <i class="fas fa-download"></i>
                                                                Exam Paper
                                                            </a>
                                                            @if($item->answer_key)
                                                                <a href="{{ asset($item->answer_key) }}" download class="action-btn secondary">
                                                                    <i class="fas fa-key"></i>
                                                                    Answer Key
                                                                </a>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="status-indicator">
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
                                                <i class="fas fa-folder-open"></i>
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

<style>
    /* Recent Exams List View Styles - Same as Documents Page */
    .recent-exams-list {
        margin-top: 1rem;
    }

    .recent-exams-list .document-card {
        display: flex;
        align-items: center;
        border-radius: 12px;
        margin-bottom: 1rem;
        padding: 1rem;
        min-height: 100px;
        background: white;
        border: 1px solid #f1f3f4;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
    }

    .recent-exams-list .document-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .recent-exams-list .document-card-header {
        height: 60px;
        width: 60px;
        border-radius: 12px;
        margin-right: 1rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .recent-exams-list .document-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .recent-exams-list .document-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .recent-exams-list .document-type-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 0.6rem;
        font-weight: 500;
        color: #6c757d;
        border: 1px solid rgba(255, 255, 255, 0.4);
        opacity: 0.8;
    }

    .recent-exams-list .document-card-body {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .recent-exams-list .document-main-info {
        flex: 1;
        min-width: 0;
    }

    .recent-exams-list .document-title {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
        line-height: 1.3;
    }

    .recent-exams-list .document-title a {
        color: inherit;
        text-decoration: none;
    }

    .recent-exams-list .document-title a:hover {
        color: #007bff;
    }

    .recent-exams-list .document-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .recent-exams-list .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .recent-exams-list .meta-item i {
        color: #007bff;
        font-size: 0.9rem;
        width: 16px;
        text-align: center;
    }

    /* Date and calendar icons keep original color */
    .recent-exams-list .meta-item .fa-calendar-alt,
    .recent-exams-list .meta-item .fa-clock {
        color: #6c757d;
    }

    .recent-exams-list .document-instructor-section {
        min-width: 150px;
        flex-shrink: 0;
    }

    .recent-exams-list .instructor-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .recent-exams-list .instructor-avatar {
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

    .recent-exams-list .instructor-avatar i {
        font-size: 1rem;
    }

    .recent-exams-list .instructor-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
    }

    .recent-exams-list .document-actions {
        display: flex;
        gap: 0.5rem;
        flex-shrink: 0;
    }

    .recent-exams-list .action-btn {
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
        white-space: nowrap;
    }

    .recent-exams-list .action-btn:hover {
        text-decoration: none;
    }

    .recent-exams-list .action-btn.primary {
        border-color: #007bff;
        background: #007bff;
        color: white;
    }

    .recent-exams-list .action-btn.primary:hover {
        background: #0056b3;
        border-color: #0056b3;
        color: white;
    }

    .recent-exams-list .action-btn.secondary {
        border-color: #6c757d;
        background: white;
        color: #6c757d;
    }

    .recent-exams-list .action-btn.secondary:hover {
        border-color: #6c757d;
        background: #6c757d;
        color: white;
    }

    .recent-exams-list .status-indicator {
        margin-left: 1rem;
        flex-shrink: 0;
    }

    .recent-exams-list .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .recent-exams-list .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .recent-exams-list .status-badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    /* File type colors */
    .recent-exams-list .pdf-card .document-card-header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
    }

    /* PDF badge styling for better contrast */
    .recent-exams-list .pdf-card .document-type-badge {
        color: #ff6b6b;
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.6);
    }

    .recent-exams-list .doc-card .document-card-header,
    .recent-exams-list .docx-card .document-card-header {
        background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
    }

    .recent-exams-list .xls-card .document-card-header,
    .recent-exams-list .xlsx-card .document-card-header {
        background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
    }

    .recent-exams-list .ppt-card .document-card-header,
    .recent-exams-list .pptx-card .document-card-header {
        background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);
    }

    .recent-exams-list .document-card-header {
        background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .recent-exams-list .document-card {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
        }

        .recent-exams-list .document-card-header {
            margin: 0 auto 1rem;
        }

        .recent-exams-list .document-card-body {
            flex-direction: column;
            align-items: center;
            padding: 0;
            width: 100%;
        }

        .recent-exams-list .document-main-info {
            text-align: center;
            margin-bottom: 1rem;
            width: 100%;
        }

        .recent-exams-list .document-title {
            max-width: 100%;
            white-space: normal;
            text-align: center;
        }

        .recent-exams-list .document-meta {
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .recent-exams-list .document-instructor-section {
            justify-content: center;
            margin: 1rem 0;
            min-width: auto;
        }

        .recent-exams-list .document-actions {
            margin-top: 1rem;
            width: 100%;
            justify-content: center;
        }

        .recent-exams-list .action-btn {
            flex: 1;
            max-width: 150px;
        }

        .recent-exams-list .status-indicator {
            margin: 1rem 0 0 0;
        }
    }
</style>

@endsection
