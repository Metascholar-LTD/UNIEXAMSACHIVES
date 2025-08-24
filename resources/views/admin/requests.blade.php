@extends('layout.app')

@push('styles')
<!-- Inter Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Modern Requests Management Page Styles - Consistent Theme */
    * {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }
    
    .requests-hero {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 50%, #f59e0b 100%);
        padding: 60px 0 40px;
        position: relative;
        overflow: hidden;
    }

    .requests-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="requests-grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(245,158,11,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23requests-grid)" /></svg>');
        opacity: 0.7;
    }

    .requests-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: #92400e;
        margin-bottom: 1rem;
        background: linear-gradient(135deg, #92400e 0%, #b45309 50%, #d97706 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-subtitle {
        font-size: 1.1rem;
        color: #92400e;
        margin-bottom: 2rem;
    }

    .hero-stats {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
    }

    .stat-item {
        background: rgba(255, 255, 255, 0.9);
        padding: 1.5rem 2rem;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .stat-number {
        display: block;
        font-size: 2rem;
        font-weight: 800;
        color: #92400e;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #92400e;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Search and Filter Section */
    .search-filter-section {
        background: white;
        padding: 2rem 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .search-box {
        display: flex;
        max-width: 500px;
        margin: 0 auto 1.5rem;
        background: white;
        border-radius: 25px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: 2px solid #f3f4f6;
    }

    .search-input {
        flex: 1;
        padding: 15px 20px;
        border: none;
        outline: none;
        font-size: 1rem;
        background: transparent;
    }

    .search-btn {
        padding: 15px 20px;
        background: #f59e0b;
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #d97706;
    }

    .filter-tabs {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .filter-tab {
        padding: 10px 20px;
        border: 2px solid #f3f4f6;
        border-radius: 25px;
        color: #6b7280;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        background: white;
    }

    .filter-tab:hover,
    .filter-tab.active {
        border-color: #f59e0b;
        background: #f59e0b;
        color: white;
        text-decoration: none;
    }

    /* Modern Request Cards */
    .requests-section {
        background: #f9fafb;
        padding: 3rem 0;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .requests-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(450px, 1fr));
        gap: 1.5rem;
    }

    .request-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        border: 1px solid #f3f4f6;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .request-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .request-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .request-card-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 700;
        font-size: 1.8rem;
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
        flex-shrink: 0;
    }

    .user-info {
        flex: 1;
        min-width: 0;
    }

    .user-name {
        font-size: 1.4rem;
        font-weight: 600;
        color: #111827;
        margin: 0 0 0.5rem 0;
        line-height: 1.3;
    }

    .user-email {
        font-size: 0.95rem;
        color: #6b7280;
        margin: 0;
        word-break: break-all;
    }

    .request-details {
        margin-bottom: 1.5rem;
    }

    .request-reason {
        background: #fef3c7;
        border: 1px solid #fde68a;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .request-reason h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #92400e;
        margin: 0 0 0.5rem 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .request-reason p {
        font-size: 0.95rem;
        color: #92400e;
        margin: 0;
        line-height: 1.5;
    }

    .request-meta {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .meta-item {
        background: #f9fafb;
        padding: 0.75rem;
        border-radius: 8px;
        border: 1px solid #f3f4f6;
    }

    .meta-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .meta-value {
        font-size: 0.9rem;
        color: #111827;
        font-weight: 500;
    }

    .request-actions {
        display: flex;
        gap: 0.8rem;
        flex-wrap: wrap;
    }

    .action-btn {
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        background: white;
        color: #6b7280;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        border: none;
        min-width: 100px;
        justify-content: center;
    }

    .action-btn:hover {
        text-decoration: none;
        transform: translateY(-2px);
    }

    .action-btn.approve {
        background: #10b981;
        color: white;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
    }

    .action-btn.approve:hover {
        background: #059669;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
    }

    .action-btn.reject {
        background: #ef4444;
        color: white;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
    }

    .action-btn.reject:hover {
        background: #dc2626;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
    }

    .action-btn.view {
        background: #3b82f6;
        color: white;
        box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
    }

    .action-btn.view:hover {
        background: #2563eb;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
    }

    .no-requests {
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 20px;
        border: 2px dashed #d1d5db;
    }

    .no-requests i {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .no-requests h4 {
        font-size: 1.5rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .no-requests p {
        color: #9ca3af;
        margin: 0;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 2rem;
        border-radius: 20px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .close {
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        color: #6b7280;
        transition: color 0.3s ease;
    }

    .close:hover {
        color: #111827;
    }

    .modal-header {
        margin-bottom: 1.5rem;
        padding-right: 2rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }

    .modal-body {
        margin-bottom: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        border-color: #f59e0b;
    }

    .form-textarea {
        width: 100%;
        padding: 12px 16px;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.3s ease;
        resize: vertical;
        min-height: 100px;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #f59e0b;
    }

    .modal-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn {
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-secondary {
        background: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background: #4b5563;
    }

    .btn-danger {
        background: #ef4444;
        color: white;
    }

    .btn-danger:hover {
        background: #dc2626;
    }

    @media (max-width: 768px) {
        .requests-list {
            grid-template-columns: 1fr;
        }
        
        .request-meta {
            grid-template-columns: 1fr;
        }
        
        .hero-stats {
            flex-direction: column;
            align-items: center;
        }
        
        .stat-item {
            width: 100%;
            max-width: 300px;
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
                    <!-- Hero Section -->
                    <div class="requests-hero">
                        <div class="container">
                            <div class="requests-hero-content">
                                <h1 class="hero-title">Manage Access Requests</h1>
                                <p class="hero-subtitle">Review and manage requests for advance communication system access</p>
                                
                                <div class="hero-stats">
                                    <div class="stat-item">
                                        <span class="stat-number">{{ count($requests) }}</span>
                                        <div class="stat-label">Pending Requests</div>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">{{ \App\Models\User::where('admin_access_approved_at', '!=', null)->count() }}</span>
                                        <div class="stat-label">Approved</div>
                                    </div>
                                    <div class="stat-item">
                                        <span class="stat-number">{{ \App\Models\User::where('admin_access_rejected_at', '!=', null)->count() }}</span>
                                        <div class="stat-label">Rejected</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Search and Filter Section -->
                    <div class="search-filter-section">
                        <div class="container">
                            <div class="search-box">
                                <input type="text" class="search-input" id="searchInput" placeholder="Search requests by name or email...">
                                <button class="search-btn" onclick="performSearch()">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            
                            <div class="filter-tabs">
                                <a href="#" class="filter-tab active" data-filter="all">All Requests</a>
                                <a href="#" class="filter-tab" data-filter="recent">Recent</a>
                                <a href="#" class="filter-tab" data-filter="urgent">Urgent</a>
                            </div>
                        </div>
                    </div>

                    <!-- Requests Section -->
                    <div class="requests-section">
                        <div class="container">
                            @if (count($requests) > 0)
                                <div class="requests-list">
                                    @foreach ($requests as $request)
                                        <div class="request-card" data-search="{{ strtolower($request->first_name . ' ' . $request->last_name . ' ' . $request->email) }}">
                                            <div class="request-card-header">
                                                <div class="user-avatar">
                                                    {{ strtoupper(substr($request->first_name, 0, 1) . substr($request->last_name, 0, 1)) }}
                                                </div>
                                                <div class="user-info">
                                                    <h3 class="user-name">{{ $request->first_name }} {{ $request->last_name }}</h3>
                                                    <p class="user-email">{{ $request->email }}</p>
                                                </div>
                                            </div>
                                            
                                            <div class="request-details">
                                                <div class="request-reason">
                                                    <h4>Reason for Access</h4>
                                                    <p>{{ Str::limit($request->admin_access_reason, 150) }}</p>
                                                </div>
                                                
                                                <div class="request-meta">
                                                    <div class="meta-item">
                                                        <div class="meta-label">Requested On</div>
                                                        <div class="meta-value">{{ $request->admin_access_requested_at ? \Carbon\Carbon::parse($request->admin_access_requested_at)->format('M d, Y') : 'N/A' }}</div>
                                                    </div>
                                                    @if($request->admin_access_supervisor)
                                                    <div class="meta-item">
                                                        <div class="meta-label">Supervisor</div>
                                                        <div class="meta-value">{{ $request->admin_access_supervisor }}</div>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="request-actions">
                                                <button class="action-btn view" onclick="viewRequestDetails({{ $request->id }})">
                                                    <i class="fas fa-eye"></i>
                                                    View Details
                                                </button>
                                                
                                                <form action="{{ route('requests.approve', $request->id) }}" method="post" style="display: inline;">
                                                    @csrf
                                                    <button type="submit" class="action-btn approve" onclick="return confirm('Are you sure you want to approve this access request?')">
                                                        <i class="fas fa-check"></i>
                                                        Approve
                                                    </button>
                                                </form>
                                                
                                                <button class="action-btn reject" onclick="showRejectModal({{ $request->id }})">
                                                    <i class="fas fa-times"></i>
                                                    Reject
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="no-requests">
                                    <i class="fas fa-inbox"></i>
                                    <h4>No Pending Requests</h4>
                                    <p>There are no pending access requests at the moment.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRejectModal()">&times;</span>
        <div class="modal-header">
            <h3 class="modal-title">Reject Access Request</h3>
        </div>
        <div class="modal-body">
            <form id="rejectForm" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rejection_reason" class="form-label">Reason for Rejection</label>
                    <textarea name="rejection_reason" id="rejection_reason" class="form-textarea" placeholder="Please provide a reason for rejecting this access request..." required></textarea>
                </div>
            </form>
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeRejectModal()">Cancel</button>
            <button class="btn btn-danger" onclick="submitRejection()">Reject Request</button>
        </div>
    </div>
</div>

<!-- Request Details Modal -->
<div id="requestDetailsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeRequestDetailsModal()">&times;</span>
        <div class="modal-header">
            <h3 class="modal-title">Request Details</h3>
        </div>
        <div class="modal-body" id="requestDetailsContent">
            <!-- Content will be loaded here -->
        </div>
        <div class="modal-actions">
            <button class="btn btn-secondary" onclick="closeRequestDetailsModal()">Close</button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Search and Filter functionality for Requests Management
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const requestCards = document.querySelectorAll('.request-card');
    const filterTabs = document.querySelectorAll('.filter-tab');

    // Search functionality
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        requestCards.forEach(card => {
            const searchData = card.getAttribute('data-search');
            if (searchData.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Filter functionality
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.getAttribute('data-filter');
            
            // Apply filter logic here if needed
            console.log('Filter applied:', filter);
        });
    });
});

// Modal functionality
let currentRequestId = null;

function showRejectModal(requestId) {
    currentRequestId = requestId;
    document.getElementById('rejectModal').style.display = 'block';
    document.getElementById('rejectForm').action = `/dashboard/requests/${requestId}/reject-access`;
}

function closeRejectModal() {
    document.getElementById('rejectModal').style.display = 'none';
    document.getElementById('rejection_reason').value = '';
    currentRequestId = null;
}

function submitRejection() {
    const reason = document.getElementById('rejection_reason').value.trim();
    if (!reason) {
        alert('Please provide a reason for rejection.');
        return;
    }
    
    document.getElementById('rejectForm').submit();
}

function viewRequestDetails(requestId) {
    // Load request details via AJAX or show in modal
    // For now, we'll just show a simple message
    document.getElementById('requestDetailsContent').innerHTML = `
        <p>Loading request details...</p>
        <p>Request ID: ${requestId}</p>
        <p>This would typically load detailed information about the request.</p>
    `;
    document.getElementById('requestDetailsModal').style.display = 'block';
}

function closeRequestDetailsModal() {
    document.getElementById('requestDetailsModal').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const rejectModal = document.getElementById('rejectModal');
    const requestDetailsModal = document.getElementById('requestDetailsModal');
    
    if (event.target === rejectModal) {
        closeRejectModal();
    }
    
    if (event.target === requestDetailsModal) {
        closeRequestDetailsModal();
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeRejectModal();
        closeRequestDetailsModal();
    }
});
</script>
@endpush
