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

                                        <div class="dashboard__section__title modern-section-title">
                                            <div class="title-content">
                                                <div class="title-icon">
                                                    <i class="icofont-document"></i>
                                                </div>
                                                <div class="title-text">
                                                    <h4>Recent Uploaded Exams Paper</h4>
                                                    <p class="section-subtitle">Your latest exam contributions to the archive</p>
                                                </div>
                                            </div>
                                            <a href="{{route('dashboard.all.upload.document')}}" class="modern-see-more-btn">
                                                <span>See More</span>
                                                <i class="icofont-long-arrow-right"></i>
                                            </a>
                                        </div>

                                        @if (count($recentlyUploadedExams) > 0)
                                            <div class="modern-exams-grid">
                                                @foreach ($recentlyUploadedExams as $item )
                                                <div class="modern-exam-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}" data-exam-id="{{ $item->id }}">
                                                    <div class="exam-card-header">
                                                        <div class="exam-type-badge">
                                                            @php
                                                                $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);
                                                            @endphp
                                                            @if ($extension == 'pdf')
                                                                <i class="icofont-file-pdf"></i>
                                                                <span>PDF</span>
                                                            @else
                                                                <i class="icofont-file-word"></i>
                                                                <span>DOC</span>
                                                            @endif
                                                        </div>
                                                        <div class="exam-actions">
                                                            <button class="action-btn download-btn" onclick="downloadExam('{{ Storage::url($item->exam_document) }}', '{{ $item->course_title }}')" title="Download Exam">
                                                                <i class="icofont-download"></i>
                                                            </button>
                                                            @if($item->answer_key)
                                                                <button class="action-btn answer-key-btn" onclick="downloadAnswerKey('{{ Storage::url($item->answer_key) }}', '{{ $item->course_title }} - Answer Key')" title="Download Answer Key">
                                                                    <i class="icofont-key"></i>
                                                                </button>
                                                            @endif
                                                            <button class="action-btn preview-btn" onclick="previewExam('{{ $item->id }}')" title="Preview Details">
                                                                <i class="icofont-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="exam-card-body">
                                                        <div class="exam-title">
                                                            <h3>{{ $item->course_title }}</h3>
                                                            <div class="exam-code">{{ $item->course_code }}</div>
                                                        </div>
                                                        
                                                        <div class="exam-meta">
                                                            <div class="meta-item">
                                                                <div class="meta-icon">
                                                                    <i class="icofont-teacher"></i>
                                                                </div>
                                                                <div class="meta-content">
                                                                    <span class="meta-label">Instructor</span>
                                                                    <span class="meta-value">{{ $item->instructor_name }}</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="meta-item">
                                                                <div class="meta-icon">
                                                                    <i class="icofont-book-alt"></i>
                                                                </div>
                                                                <div class="meta-content">
                                                                    <span class="meta-label">Format</span>
                                                                    <span class="meta-value">{{ $item->exam_format }}</span>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="meta-item">
                                                                <div class="meta-icon">
                                                                    <i class="icofont-clock-time"></i>
                                                                </div>
                                                                <div class="meta-content">
                                                                    <span class="meta-label">Duration</span>
                                                                    <span class="meta-value">{{ $item->duration }}</span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="exam-details">
                                                            <div class="detail-row">
                                                                <div class="detail-item">
                                                                    <i class="icofont-calendar"></i>
                                                                    <span>{{ $item->faculty }}</span>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <i class="icofont-calendar"></i>
                                                                    <span>{{ $item->semester }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="detail-row">
                                                                <div class="detail-item">
                                                                    <i class="icofont-calendar"></i>
                                                                    <span>{{ $item->academic_year }}</span>
                                                                </div>
                                                                <div class="detail-item">
                                                                    <i class="icofont-calendar"></i>
                                                                    <span>{{ $item->exam_date }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="exam-card-footer">
                                                        <div class="upload-info">
                                                            <i class="icofont-clock-time"></i>
                                                            <span>Uploaded {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                                        </div>
                                                        <div class="exam-status">
                                                            @if($item->is_approve)
                                                                <span class="status-badge status-approved">
                                                                    <i class="icofont-check-circled"></i>
                                                                    Approved
                                                                </span>
                                                            @else
                                                                <span class="status-badge status-pending">
                                                                    <i class="icofont-clock-time"></i>
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="empty-state">
                                                <div class="empty-icon">
                                                    <i class="icofont-document"></i>
                                                </div>
                                                <h3>No Exams Uploaded Yet</h3>
                                                <p>Start building your exam archive by uploading your first exam paper</p>
                                                <a href="{{route('dashboard.create')}}" class="upload-first-btn">
                                                    <i class="icofont-upload"></i>
                                                    Upload Your First Exam
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

<!-- Exam Preview Modal -->
<div class="modal fade" id="examPreviewModal" tabindex="-1" aria-labelledby="examPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="examPreviewModalLabel">Exam Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="examPreviewModalBody">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// Download exam function
function downloadExam(url, filename) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Show success notification if available
    if (typeof showNotification === 'function') {
        showNotification('success', 'Download Started!', `${filename} is being downloaded`);
    }
}

// Download answer key function
function downloadAnswerKey(url, filename) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    // Show success notification if available
    if (typeof showNotification === 'function') {
        showNotification('success', 'Answer Key Downloaded!', `${filename} is being downloaded`);
    }
}

// Preview exam function
function previewExam(examId) {
    // For now, we'll show a simple preview
    // In a real implementation, you could fetch exam details via AJAX
    const modal = new bootstrap.Modal(document.getElementById('examPreviewModal'));
    const modalBody = document.getElementById('examPreviewModalBody');
    
    // Find the exam data from the DOM
    const examCard = document.querySelector(`[data-exam-id="${examId}"]`);
    if (examCard) {
        const title = examCard.querySelector('.exam-title h3').textContent;
        const code = examCard.querySelector('.exam-code').textContent;
        const instructor = examCard.querySelector('.meta-item:first-child .meta-value').textContent;
        
        modalBody.innerHTML = `
            <div class="exam-preview-content">
                <div class="preview-header">
                    <h4>${title}</h4>
                    <span class="preview-code">${code}</span>
                </div>
                <div class="preview-details">
                    <div class="detail-group">
                        <label>Instructor:</label>
                        <span>${instructor}</span>
                    </div>
                    <div class="detail-group">
                        <label>Status:</label>
                        <span class="status-badge status-approved">Approved</span>
                    </div>
                </div>
                <div class="preview-actions">
                    <button class="btn btn-primary" onclick="downloadExam('exam-url', '${title}')">
                        <i class="icofont-download"></i> Download Exam
                    </button>
                    <button class="btn btn-warning" onclick="downloadAnswerKey('answer-key-url', '${title} - Answer Key')">
                        <i class="icofont-key"></i> Download Answer Key
                    </button>
                </div>
            </div>
        `;
    }
    
    modal.show();
}

// Add smooth animations to exam cards
document.addEventListener('DOMContentLoaded', function() {
    const examCards = document.querySelectorAll('.modern-exam-card');
    
    examCards.forEach((card, index) => {
        // Add staggered animation delay
        card.style.animationDelay = `${index * 0.1}s`;
        
        // Add hover effects
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
    
    // Add click effects to action buttons
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = 'scale(1)';
            }, 150);
        });
    });
});
</script>

<style>
/* Modal styling */
.modal-content {
    border-radius: 16px;
    border: none;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
}

.modal-header {
    border-bottom: 1px solid rgba(226, 232, 240, 0.6);
    padding: 1.5rem;
}

.modal-body {
    padding: 2rem;
}

.modal-footer {
    border-top: 1px solid rgba(226, 232, 240, 0.6);
    padding: 1.5rem;
}

.exam-preview-content {
    text-align: center;
}

.preview-header h4 {
    color: #1f2937;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.preview-code {
    display: inline-block;
    padding: 6px 16px;
    background: rgba(59, 130, 246, 0.1);
    color: #1d4ed8;
    border-radius: 8px;
    font-weight: 600;
    font-size: 0.875rem;
}

.preview-details {
    margin: 2rem 0;
    text-align: left;
}

.detail-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(226, 232, 240, 0.6);
}

.detail-group:last-child {
    border-bottom: none;
}

.detail-group label {
    font-weight: 600;
    color: #6b7280;
}

.preview-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.preview-actions .btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 12px 24px;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.preview-actions .btn:hover {
    transform: translateY(-2px);
}
</style>

@endsection
