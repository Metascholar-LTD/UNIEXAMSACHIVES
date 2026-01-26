@extends('super-admin.layout')

@section('title', 'System Licences')

@push('styles')
<style>
    body {
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
    }

    .page-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 1.5rem;
    }

    .page-header-modern {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2rem;
    }

    .page-header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .page-header-title {
        font-size: 1.875rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .btn-add {
        background-color: #3b82f6;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-add:hover {
        background-color: #2563eb;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    }

    .modern-card {
        background: white;
        border-radius: 1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        border: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .modern-card-header {
        background: #f9fafb;
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .modern-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
        margin: 0;
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

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .btn-action {
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        font-weight: 600;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .btn-toggle {
        background-color: #f59e0b;
        color: white;
    }

    .btn-toggle:hover {
        background-color: #d97706;
    }

    .btn-edit {
        background-color: #3b82f6;
        color: white;
    }

    .btn-edit:hover {
        background-color: #2563eb;
    }

    .btn-delete {
        background-color: #ef4444;
        color: white;
    }

    .btn-delete:hover {
        background-color: #dc2626;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        padding: 2rem;
        border-radius: 0.75rem;
        max-width: 600px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }

    .close-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #6b7280;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #374151;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        font-size: 1rem;
    }

    .form-input:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn-submit {
        background-color: #3b82f6;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #2563eb;
    }

    .btn-cancel {
        background-color: #6b7280;
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        cursor: pointer;
    }

    .btn-cancel:hover {
        background-color: #4b5563;
    }

    .alert {
        padding: 1rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background-color: #d1fae5;
        color: #065f46;
        border: 1px solid #10b981;
    }

    .alert-error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #ef4444;
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
<div class="page-container">
    <div class="page-header-modern">
        <div class="page-header-left">
            <h1 class="page-header-title">System Licences</h1>
        </div>
        <button class="btn-add" onclick="openAddModal()">
            <i class="icofont-plus"></i>
            Add New Licence
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            {{ session('error') }}
        </div>
    @endif

    <div class="modern-card">
        <div class="table-container">
            <table class="licenses-table">
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Licence</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Actions</th>
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
                            <td>
                                <div class="action-buttons">
                                    <form action="{{ route('super-admin.licenses.toggle-status', $license->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn-action btn-toggle">
                                            <i class="icofont-{{ $license->is_active ? 'eye-blocked' : 'eye' }}"></i>
                                            {{ $license->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <button class="btn-action btn-edit" onclick="openEditModal({{ $license->id }}, '{{ $license->name }}', '{{ addslashes($license->description) }}', {{ $license->is_active ? 'true' : 'false' }})">
                                        <i class="icofont-edit"></i>
                                        Edit
                                    </button>
                                    <form action="{{ route('super-admin.licenses.destroy', $license->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this license?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-delete">
                                            <i class="icofont-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="5" class="text-center" style="padding: 2rem; color: #6b7280;">No licenses found.</td>
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

<!-- Add/Edit Modal -->
<div id="licenseModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title" id="modalTitle">Add New Licence</h2>
            <button class="close-btn" onclick="closeModal()">&times;</button>
        </div>
        <form id="licenseForm" method="POST">
            @csrf
            <input type="hidden" id="licenseId" name="license_id">
            <div id="methodField"></div>
            
            <div class="form-group">
                <label class="form-label" for="name">Licence Name</label>
                <input type="text" class="form-input" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label class="form-label" for="description">Description</label>
                <textarea class="form-input" id="description" name="description" rows="4" required></textarea>
            </div>
            
            <div class="form-group">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" class="form-checkbox" id="is_active" name="is_active" checked>
                    <span>Active</span>
                </label>
            </div>
            
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal()">Cancel</button>
                <button type="submit" class="btn-submit">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Add New Licence';
    document.getElementById('licenseForm').action = '{{ route("super-admin.licenses.store") }}';
    document.getElementById('licenseId').value = '';
    document.getElementById('name').value = '';
    document.getElementById('description').value = '';
    document.getElementById('is_active').checked = true;
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('licenseModal').classList.add('show');
}

function openEditModal(id, name, description, isActive) {
    document.getElementById('modalTitle').textContent = 'Edit Licence';
    document.getElementById('licenseForm').action = '{{ route("super-admin.licenses.update", ":id") }}'.replace(':id', id);
    document.getElementById('licenseId').value = id;
    document.getElementById('name').value = name;
    document.getElementById('description').value = description;
    document.getElementById('is_active').checked = isActive;
    document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('licenseModal').classList.add('show');
}

function closeModal() {
    document.getElementById('licenseModal').classList.remove('show');
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('licenseModal');
    if (event.target == modal) {
        closeModal();
    }
}

// Change page size
function changePageSize(size) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', size);
    url.searchParams.set('page', '1'); // Reset to first page
    window.location.href = url.toString();
}
</script>
@endsection
