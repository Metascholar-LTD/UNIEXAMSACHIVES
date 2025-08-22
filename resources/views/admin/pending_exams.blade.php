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
                        <!-- Modern Header Section -->
                        <div class="modern-page-header">
                            <div class="header-content">
                                <div class="header-left">
                                    <h1 class="page-title">
                                        <i class="icofont-clock-time text-warning"></i>
                                        Pending Exams
                                    </h1>
                                    <p class="page-subtitle">Manage and review exams awaiting approval</p>
                                </div>
                                <div class="header-right">
                                    <div class="stats-card">
                                        <div class="stats-number">{{ count($exams) }}</div>
                                        <div class="stats-label">Total Pending</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modern Content Section -->
                        <div class="modern-content-section">
                            @if (count($exams) > 0)
                                <div class="modern-exams-grid">
                                    @foreach ($exams as $exam)
                                        <div class="modern-exam-card">
                                            <div class="card-header">
                                                <div class="exam-id">
                                                    <span class="id-badge">#{{ $exam->id }}</span>
                                                </div>
                                                <div class="exam-status">
                                                    <span class="status-badge status-pending">
                                                        <i class="icofont-clock-time"></i>
                                                        Pending
                                                    </span>
                                                </div>
                                            </div>
                                            
                                            <div class="card-body">
                                                <div class="exam-info">
                                                    <div class="info-row">
                                                        <label>Course Title:</label>
                                                        <span class="info-value">{{ $exam->course_title }}</span>
                                                    </div>
                                                    <div class="info-row">
                                                        <label>Course Code:</label>
                                                        <span class="info-value">{{ $exam->course_code }}</span>
                                                    </div>
                                                    <div class="info-row">
                                                        <label>Document ID:</label>
                                                        <span class="info-value">{{ $exam->document_id }}</span>
                                                    </div>
                                                    <div class="info-row">
                                                        <label>Semester:</label>
                                                        <span class="info-value">{{ $exam->semester }}</span>
                                                    </div>
                                                    <div class="info-row">
                                                        <label>Exam Type:</label>
                                                        <span class="info-value">{{ $exam->exams_type }}</span>
                                                    </div>
                                                    <div class="info-row">
                                                        <label>Uploaded:</label>
                                                        <span class="info-value">{{ $exam->created_at->format('M d, Y') }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-actions">
                                                <div class="action-buttons">
                                                    <!-- View/Download Exam Document -->
                                                    <div class="action-group">
                                                        <label class="action-label">Exam Document:</label>
                                                        <div class="button-group">
                                                            @if(pathinfo($exam->exam_document, PATHINFO_EXTENSION) === 'pdf')
                                                                <a href="{{ asset($exam->exam_document) }}" target="_blank" class="btn btn-outline-primary btn-sm" title="View PDF">
                                                                    <i class="icofont-eye"></i>
                                                                </a>
                                                            @endif
                                                            <a href="{{ asset($exam->exam_document) }}" download class="btn btn-outline-success btn-sm" title="Download">
                                                                <i class="icofont-download"></i>
                                                            </a>
                                                        </div>
                                                    </div>

                                                    <!-- View/Download Answer Key -->
                                                    @if($exam->answer_key)
                                                        <div class="action-group">
                                                            <label class="action-label">Answer Key:</label>
                                                            <div class="button-group">
                                                                @if(pathinfo($exam->answer_key, PATHINFO_EXTENSION) === 'pdf')
                                                                    <a href="{{ asset($exam->answer_key) }}" target="_blank" class="btn btn-outline-info btn-sm" title="View PDF">
                                                                        <i class="icofont-eye"></i>
                                                                    </a>
                                                                @endif
                                                                <a href="{{ asset($exam->answer_key) }}" download class="btn btn-outline-secondary btn-sm" title="Download">
                                                                    <i class="icofont-download"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Management Actions -->
                                                <div class="management-actions">
                                                    <a href="{{ route('exams.edit', $exam->id) }}" class="btn btn-warning btn-sm" title="Edit Exam">
                                                        <i class="icofont-edit"></i>
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('exams.destroy', $exam->id) }}" method="post" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete Exam" onclick="return confirm('Are you sure you want to delete this exam?')">
                                                            <i class="icofont-trash"></i>
                                                            Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="icofont-inbox text-muted"></i>
                                    </div>
                                    <h3 class="empty-title">No Pending Exams</h3>
                                    <p class="empty-description">All exams have been processed. Great job!</p>
                                    <a href="{{ route('dashboard.create') }}" class="btn btn-primary">
                                        <i class="icofont-plus"></i>
                                        Upload New Exam
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add modern CSS styles -->
<style>
.modern-page-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 2rem;
    margin-bottom: 2rem;
    color: white;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.header-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2rem;
}

.header-left .page-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0 0 0.5rem 0;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-left .page-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
}

.stats-card {
    background: rgba(255,255,255,0.2);
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    backdrop-filter: blur(10px);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-top: 0.25rem;
}

.modern-content-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.modern-exams-grid {
    display: grid;
    gap: 1.5rem;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
}

.modern-exam-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}

.modern-exam-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.12);
    border-color: #3b82f6;
}

.card-header {
    background: #f8fafc;
    padding: 1rem 1.5rem;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.id-badge {
    background: #3b82f6;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 600;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}

.card-body {
    padding: 1.5rem;
}

.exam-info {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #f1f5f9;
}

.info-row:last-child {
    border-bottom: none;
}

.info-row label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
}

.info-value {
    font-weight: 500;
    color: #1e293b;
    text-align: right;
}

.card-actions {
    background: #f8fafc;
    padding: 1.5rem;
    border-top: 1px solid #e5e7eb;
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.action-group {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.action-label {
    font-weight: 600;
    color: #64748b;
    font-size: 0.875rem;
}

.button-group {
    display: flex;
    gap: 0.5rem;
}

.btn-sm {
    padding: 0.375rem 0.75rem;
    font-size: 0.875rem;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.2s ease;
}

.btn-outline-primary {
    border-color: #3b82f6;
    color: #3b82f6;
}

.btn-outline-primary:hover {
    background: #3b82f6;
    color: white;
}

.btn-outline-success {
    border-color: #10b981;
    color: #10b981;
}

.btn-outline-success:hover {
    background: #10b981;
    color: white;
}

.btn-outline-info {
    border-color: #06b6d4;
    color: #06b6d4;
}

.btn-outline-info:hover {
    background: #06b6d4;
    color: white;
}

.btn-outline-secondary {
    border-color: #6b7280;
    color: #6b7280;
}

.btn-outline-secondary:hover {
    background: #6b7280;
    color: white;
}

.management-actions {
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
    padding-top: 1rem;
    border-top: 1px solid #e5e7eb;
}

.btn-warning {
    background: #f59e0b;
    border-color: #f59e0b;
    color: white;
}

.btn-warning:hover {
    background: #d97706;
    border-color: #d97706;
    color: white;
}

.btn-danger {
    background: #ef4444;
    border-color: #ef4444;
    color: white;
}

.btn-danger:hover {
    background: #dc2626;
    border-color: #dc2626;
    color: white;
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-icon {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.empty-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: #6b7280;
    margin-bottom: 2rem;
}

.btn-primary {
    background: #3b82f6;
    border-color: #3b82f6;
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.btn-primary:hover {
    background: #2563eb;
    border-color: #2563eb;
    color: white;
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .modern-exams-grid {
        grid-template-columns: 1fr;
    }
    
    .action-group {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .management-actions {
        flex-direction: column;
    }
}
</style>
@endsection
