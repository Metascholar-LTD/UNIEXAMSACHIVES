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
                            <h4>Committees & Boards Management</h4>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCommitteeModal">
                                <i class="fas fa-plus"></i> Create Committee/Board
                            </button>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row mt-4">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Members</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($committees as $committee)
                                            <tr>
                                                <td>{{ $committee->id }}</td>
                                                <td><strong>{{ $committee->name }}</strong></td>
                                                <td>{{ Str::limit($committee->description ?? 'No description', 50) }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $committee->status === 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($committee->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info">{{ $committee->users_count }} members</span>
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-primary" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#manageUsersModal{{ $committee->id }}"
                                                            title="Manage Members">
                                                        <i class="fas fa-users"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editCommitteeModal{{ $committee->id }}"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <form action="{{ route('committees.destroy', $committee->id) }}" 
                                                          method="POST" 
                                                          style="display:inline-block;"
                                                          onsubmit="return confirm('Are you sure you want to delete this committee/board?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>

                                            {{-- Edit Modal for each committee --}}
                                            <div class="modal fade" id="editCommitteeModal{{ $committee->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Committee/Board</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="{{ route('committees.update', $committee->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label for="name{{ $committee->id }}" class="form-label">Name <span class="text-danger">*</span></label>
                                                                    <input type="text" class="form-control" id="name{{ $committee->id }}" 
                                                                           name="name" value="{{ $committee->name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="description{{ $committee->id }}" class="form-label">Description</label>
                                                                    <textarea class="form-control" id="description{{ $committee->id }}" 
                                                                              name="description" rows="3">{{ $committee->description }}</textarea>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status{{ $committee->id }}" class="form-label">Status <span class="text-danger">*</span></label>
                                                                    <select class="form-control" id="status{{ $committee->id }}" name="status" required>
                                                                        <option value="active" {{ $committee->status === 'active' ? 'selected' : '' }}>Active</option>
                                                                        <option value="inactive" {{ $committee->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Manage Users Modal for each committee --}}
                                            <div class="modal fade" id="manageUsersModal{{ $committee->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Manage Members - {{ $committee->name }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h6>Current Members ({{ $committee->users->count() }})</h6>
                                                            <div class="table-responsive mb-4">
                                                                <table class="table table-sm">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Name</th>
                                                                            <th>Email</th>
                                                                            <th>Action</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse ($committee->users as $user)
                                                                        <tr>
                                                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                                            <td>{{ $user->email }}</td>
                                                                            <td>
                                                                                <form action="{{ route('committees.remove-user', [$committee->id, $user->id]) }}" 
                                                                                      method="POST" style="display:inline-block;">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                                                            onclick="return confirm('Remove this user from the committee?');">
                                                                                        <i class="fas fa-user-minus"></i> Remove
                                                                                    </button>
                                                                                </form>
                                                                            </td>
                                                                        </tr>
                                                                        @empty
                                                                        <tr>
                                                                            <td colspan="3" class="text-center">No members yet</td>
                                                                        </tr>
                                                                        @endforelse
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <hr>

                                                            <h6>Add New Members</h6>
                                                            <form action="{{ route('committees.add-users', $committee->id) }}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label for="user_ids{{ $committee->id }}" class="form-label">Select Users</label>
                                                                    <select class="form-control" id="user_ids{{ $committee->id }}" 
                                                                            name="user_ids[]" multiple size="10" required>
                                                                        @foreach ($users as $user)
                                                                            @if (!$committee->users->contains($user->id))
                                                                            <option value="{{ $user->id }}">
                                                                                {{ $user->first_name }} {{ $user->last_name }} ({{ $user->email }})
                                                                            </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                    <small class="form-text text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple users</small>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">
                                                                    <i class="fas fa-user-plus"></i> Add Selected Users
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No committees/boards created yet.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Create Committee Modal --}}
<div class="modal fade" id="createCommitteeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create Committee/Board</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('committees.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

