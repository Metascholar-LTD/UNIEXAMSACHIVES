@extends('layout.app')

@push('styles')
<style>
    .modern-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .table-container {
        overflow-x: auto;
    }

    .licenses-table {
        width: 100%;
        border-collapse: collapse;
    }

    .licenses-table thead {
        background: #f9fafb;
    }

    .licenses-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        font-weight: 600;
        color: #374151;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 2px solid #e5e7eb;
    }

    .licenses-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        color: #1f2937;
    }

    .licenses-table tbody tr:hover {
        background: #f9fafb;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .status-badge.active {
        background-color: #10b981;
        color: white;
    }

    .status-badge.inactive {
        background-color: #ef4444;
        color: white;
    }

    /* Pagination Styles */
    .pagination-wrapper {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
        flex-wrap: wrap;
    }

    .pagination-info {
        font-size: 0.875rem;
        color: #6b7280;
        white-space: nowrap;
    }

    .pagination-info strong {
        color: #1f2937;
        font-weight: 600;
    }

    .pagination-controls {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pagination {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        gap: 0.25rem;
    }

    .pagination-item {
        display: inline-block;
    }

    .pagination-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        padding: 0 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        background: white;
        color: #374151;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .pagination-link:hover:not(.disabled):not(.active) {
        background: #f3f4f6;
        border-color: #d1d5db;
        color: #1f2937;
    }

    .pagination-link.active {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
        font-weight: 600;
    }

    .pagination-link.disabled {
        color: #9ca3af;
        cursor: not-allowed;
        background: #f9fafb;
        opacity: 0.5;
    }

    .pagination-link.icon {
        width: 2.5rem;
        padding: 0;
    }

    .pagination-ellipsis {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        height: 2.5rem;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .page-size-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .page-size-label {
        font-size: 0.875rem;
        color: #6b7280;
        white-space: nowrap;
    }

    .page-size-select {
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background: white;
        color: #374151;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .page-size-select:hover {
        border-color: #9ca3af;
    }

    .page-size-select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    @media (max-width: 768px) {
        .pagination-wrapper {
            flex-direction: column;
            align-items: stretch;
        }

        .pagination-controls {
            justify-content: center;
        }

        .page-size-selector {
            justify-content: center;
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
                            <h4>System Licences</h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="modern-card">
                                    <div class="table-container">
                                        <table class="licenses-table">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Licence</th>
                                                    <th>Description</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if ($licenses->count() > 0)
                                                    @foreach ($licenses as $license)
                                                    <tr>
                                                        <td>{{ $licenses->firstItem() + $loop->index }}</td>
                                                        <td><strong>{{ $license->name }}</strong></td>
                                                        <td>{{ $license->description }}</td>
                                                        <td>
                                                            <span class="status-badge {{ $license->is_active ? 'active' : 'inactive' }}">
                                                                {{ $license->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="4" class="text-center" style="padding: 2rem; color: #6b7280;">No licenses found.</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($licenses->hasPages())
                                    <div class="pagination-wrapper">
                                        <div class="pagination-info">
                                            Showing <strong>{{ $licenses->firstItem() }}</strong> to <strong>{{ $licenses->lastItem() }}</strong> of <strong>{{ $licenses->total() }}</strong> results
                                        </div>
                                        
                                        <div class="pagination-controls">
                                            <ul class="pagination">
                                                {{-- Previous Page Link --}}
                                                @if ($licenses->onFirstPage())
                                                    <li class="pagination-item">
                                                        <span class="pagination-link icon disabled">
                                                            <i class="icofont-arrow-left"></i>
                                                        </span>
                                                    </li>
                                                @else
                                                    <li class="pagination-item">
                                                        <a href="{{ $licenses->previousPageUrl() }}" class="pagination-link icon">
                                                            <i class="icofont-arrow-left"></i>
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- Pagination Elements --}}
                                                @php
                                                    $currentPage = $licenses->currentPage();
                                                    $lastPage = $licenses->lastPage();
                                                    $startPage = max(1, $currentPage - 2);
                                                    $endPage = min($lastPage, $currentPage + 2);
                                                @endphp

                                                @if($startPage > 1)
                                                    <li class="pagination-item">
                                                        <a href="{{ $licenses->url(1) }}" class="pagination-link">1</a>
                                                    </li>
                                                    @if($startPage > 2)
                                                        <li class="pagination-item">
                                                            <span class="pagination-ellipsis">...</span>
                                                        </li>
                                                    @endif
                                                @endif

                                                @for ($i = $startPage; $i <= $endPage; $i++)
                                                    <li class="pagination-item">
                                                        @if ($i == $currentPage)
                                                            <span class="pagination-link active">{{ $i }}</span>
                                                        @else
                                                            <a href="{{ $licenses->url($i) }}" class="pagination-link">{{ $i }}</a>
                                                        @endif
                                                    </li>
                                                @endfor

                                                @if($endPage < $lastPage)
                                                    @if($endPage < $lastPage - 1)
                                                        <li class="pagination-item">
                                                            <span class="pagination-ellipsis">...</span>
                                                        </li>
                                                    @endif
                                                    <li class="pagination-item">
                                                        <a href="{{ $licenses->url($lastPage) }}" class="pagination-link">{{ $lastPage }}</a>
                                                    </li>
                                                @endif

                                                {{-- Next Page Link --}}
                                                @if ($licenses->hasMorePages())
                                                    <li class="pagination-item">
                                                        <a href="{{ $licenses->nextPageUrl() }}" class="pagination-link icon">
                                                            <i class="icofont-arrow-right"></i>
                                                        </a>
                                                    </li>
                                                @else
                                                    <li class="pagination-item">
                                                        <span class="pagination-link icon disabled">
                                                            <i class="icofont-arrow-right"></i>
                                                        </span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>

                                        <div class="page-size-selector">
                                            <span class="page-size-label">Per page:</span>
                                            <select class="page-size-select" onchange="changePageSize(this.value)">
                                                <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5</option>
                                                <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('per_page', 10) == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Change page size
function changePageSize(size) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', size);
    url.searchParams.set('page', '1'); // Reset to first page
    window.location.href = url.toString();
}
</script>
@endsection
