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
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif
                        
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="dashboard__form">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Header Section -->
                                                <div class="dashboard__inner">
                                                    <div class="dashboard__inner__head">
                                                        <div class="dashboard__inner__head__left">
                                                            <p class="dashboard__inner__head__subtitle">View all replies for this memo</p>
                                                        </div>
                                                    </div>

                                                    <!-- Original Memo Card -->
                                                    <div class="card mb-4">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">
                                                                <i class="icofont-document"></i> Original Memo
                                                            </h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <h6 class="text-primary">{{ $recipient->campaign->subject }}</h6>
                                                                    <p class="text-muted mb-2">
                                                                        <i class="icofont-user"></i> From: {{ $recipient->campaign->creator->first_name }} {{ $recipient->campaign->creator->last_name }}
                                                                    </p>
                                                                    <p class="text-muted mb-3">
                                                                        <i class="icofont-calendar"></i> {{ $recipient->campaign->created_at->format('M d, Y \a\t h:i A') }}
                                                                    </p>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="memo-stats">
                                                                        <div class="stat-item">
                                                                            <span class="stat-label">Total Replies:</span>
                                                                            <span class="stat-value">{{ $replies->total() }}</span>
                                                                        </div>
                                                                        <div class="stat-item">
                                                                            <span class="stat-label">Reference:</span>
                                                                            <span class="stat-value">{{ $recipient->campaign->reference }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<style>
.memo-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border-left: 4px solid #007bff;
}

.memo-stats {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
}

.stat-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 8px;
}

.stat-label {
    font-weight: 500;
    color: #6c757d;
}

.stat-value {
    font-weight: 600;
    color: #007bff;
}

.reply-item {
    background: #f8f9fa;
    border-left: 4px solid #28a745 !important;
}

.reply-header {
    border-bottom: 1px solid #dee2e6;
    padding-bottom: 10px;
}

.reply-content {
    background: white;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.attachments-list {
    background: white;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.attachment-item {
    padding: 10px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    background: white;
    transition: all 0.3s ease;
}

.attachment-item:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-1px);
}

.attachment-name {
    font-weight: 500;
    color: #007bff;
}

.attachment-size {
    font-size: 0.875rem;
}
</style>
@endsection
