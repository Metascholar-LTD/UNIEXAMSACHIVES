@extends('super-admin.layout')

@section('title', 'User Roles')

@push('styles')
<style>
    /* System Font Stack */
    body {
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    }

    /* Centered Container */
    .page-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    /* Page Header Style */
    .page-header-modern {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.5rem;
    }

    .page-header-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .page-header-separator {
        width: 1px;
        height: 2rem;
        background-color: #d1d5db;
        margin: 0;
    }

    .page-header-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .page-header-breadcrumb i {
        font-size: 1rem;
    }

    .page-header-description {
        margin-top: 0.5rem;
        color: #6b7280;
        font-size: 0.875rem;
    }

    /* Stats Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 0.75rem;
        padding: 1.25rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
    }

    .stat-card-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }

    .stat-card-value {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
    }

    /* Modern Card */
    .modern-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .modern-card-header {
        background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
        color: #1f2937;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .modern-card-header h5 {
        margin: 0;
        font-weight: 600;
        font-size: 1.125rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .modern-card-body {
        padding: 1.5rem;
    }

    /* Table Styling */
    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table thead {
        background: #f9fafb;
    }

    .modern-table th {
        padding: 0.875rem 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }

    .modern-table td {
        padding: 1rem;
        border-bottom: 1px solid #f3f4f6;
        font-size: 0.875rem;
        color: #1f2937;
    }

    .modern-table tbody tr:hover {
        background: #f9fafb;
    }

    /* Badge Styling */
    .badge-modern {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .badge-super-admin {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-admin {
        background: #dbeafe;
        color: #1e40af;
    }

    .badge-user {
        background: #e0e7ff;
        color: #3730a3;
    }

    /* Action Buttons */
    .btn-modern {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
    }

    .btn-modern-primary {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(129, 140, 248, 0.05));
        color: #4338ca;
        border: 1px solid rgba(99, 102, 241, 0.2);
    }

    .btn-modern-primary:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(129, 140, 248, 0.1));
        transform: translateY(-1px);
    }

    .btn-modern-danger {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(248, 113, 113, 0.05));
        color: #991b1b;
        border: 1px solid rgba(239, 68, 68, 0.2);
    }

    .btn-modern-danger:hover {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.15), rgba(248, 113, 113, 0.1));
        transform: translateY(-1px);
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header-modern">
                <h1 class="page-header-title">User Roles</h1>
                <div class="page-header-separator"></div>
                <div class="page-header-breadcrumb">
                    <i class="icofont-users-alt-3"></i>
                    <span> - User Roles</span>
                </div>
            </div>
            <p class="page-header-description">Manage user roles and permissions</p>
        </div>
    </div>

    {{-- Statistics --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-card-label">Total Users</div>
            <div class="stat-card-value">{{ $users->total() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Super Admins</div>
            <div class="stat-card-value">{{ $superAdmins->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-card-label">Admins</div>
            <div class="stat-card-value">{{ $admins->count() }}</div>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="modern-card">
        <div class="modern-card-header">
            <h5>
                <i class="icofont-list"></i>
                All Users
            </h5>
        </div>
        <div class="modern-card-body">
            @if($users->count() > 0)
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Department</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->first_name }} {{ $user->last_name }}</strong>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <span class="badge-modern badge-super-admin">Super Admin</span>
                                @elseif($user->role == 'admin')
                                    <span class="badge-modern badge-admin">User</span>
                                @else
                                    <span class="badge-modern badge-user">Admin</span>
                                @endif
                            </td>
                            <td>{{ $user->department->name ?? 'N/A' }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                @if($user->isSuperAdmin())
                                    <form method="POST" action="{{ route('super-admin.users.revoke-super-admin', $user->id) }}" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to revoke Super Admin access from this user?')">
                                        @csrf
                                        <input type="hidden" name="confirm" value="1">
                                        <button type="submit" class="btn-modern btn-modern-danger">Revoke</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('super-admin.users.grant-super-admin', $user->id) }}" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to grant Super Admin access to this user?')">
                                        @csrf
                                        <input type="hidden" name="confirm" value="1">
                                        <button type="submit" class="btn-modern btn-modern-primary">Grant Super Admin</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
            @else
            <div class="text-center py-5">
                <i class="icofont-inbox" style="font-size: 3rem; color: #d1d5db;"></i>
                <p class="text-muted mt-3">No users found</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

