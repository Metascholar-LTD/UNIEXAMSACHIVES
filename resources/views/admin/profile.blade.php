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
                        
                        <!-- Profile Header Section -->
                        <div class="profile-header mb-4">
                            <div class="row align-items-center">
                                <div class="col-lg-8">
                                    <div class="profile-header-content">
                                        <h2 class="profile-title mb-2">
                                            <i class="fas fa-user-circle me-3 text-primary"></i>
                                            My Profile
                                        </h2>
                                        <p class="profile-subtitle text-muted mb-0">
                                            Manage your account information and preferences
                                        </p>
                                    </div>
                                </div>
                                <div class="col-lg-4 text-end">
                                    <div class="profile-status">
                                        <span class="status-badge {{ $data->is_approve ? 'status-approved' : 'status-pending' }}">
                                            <i class="fas {{ $data->is_approve ? 'fa-check-circle' : 'fa-clock' }} me-2"></i>
                                            {{ $data->is_approve ? 'Approved' : 'Pending Approval' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Content -->
                        <div class="row">
                            <!-- Profile Picture Section -->
                            <div class="col-lg-4 col-md-12 mb-4">
                                <div class="profile-card profile-picture-card">
                                    <div class="profile-picture-wrapper text-center">
                                        <div class="profile-picture-container">
                                            @if($data->profile_picture)
                                                <img src="{{ asset('profile_pictures/' . $data->profile_picture) }}" 
                                                     alt="Profile Picture" 
                                                     class="profile-picture" 
                                                     id="profilePicturePreview">
                                            @else
                                                <div class="profile-picture-placeholder" id="profilePicturePreview">
                                                    <i class="fas fa-user fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            
                                            <div class="profile-picture-overlay">
                                                <label for="profilePictureInput" class="upload-btn">
                                                    <i class="fas fa-camera"></i>
                                                    <span>Change Photo</span>
                                                </label>
                                            </div>
                                        </div>
                                        
                                        <input type="file" 
                                               id="profilePictureInput" 
                                               name="profile_picture" 
                                               accept="image/*" 
                                               class="d-none">
                                        
                                        <div class="profile-info mt-3">
                                            <h4 class="profile-name">{{ $data->first_name }} {{ $data->last_name }}</h4>
                                            <p class="profile-email text-muted">{{ $data->email }}</p>
                                            <div class="profile-meta">
                                                <span class="meta-item">
                                                    <i class="fas fa-calendar-alt me-2"></i>
                                                    Member since {{ $data->created_at->format('M Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Details Section -->
                            <div class="col-lg-8 col-md-12">
                                <div class="profile-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-edit me-2"></i>
                                            Personal Information
                                        </h5>
                                    </div>
                                    
                                    <div class="card-body">
                                        @if(session('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fas fa-check-circle me-2"></i>
                                                {{ session('success') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        @if($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                <strong>Please fix the following errors:</strong>
                                                <ul class="mb-0 mt-2">
                                                    @foreach($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                            </div>
                                        @endif

                                        <form action="{{ route('dashboard.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                                            @csrf
                                            @method('PUT')
                                            
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="first_name" class="form-label">
                                                        <i class="fas fa-user me-2 text-primary"></i>
                                                        First Name
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg @error('first_name') is-invalid @enderror" 
                                                           id="first_name" 
                                                           name="first_name" 
                                                           value="{{ old('first_name', $data->first_name) }}" 
                                                           placeholder="Enter your first name"
                                                           required>
                                                    @error('first_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label for="last_name" class="form-label">
                                                        <i class="fas fa-user me-2 text-primary"></i>
                                                        Last Name
                                                    </label>
                                                    <input type="text" 
                                                           class="form-control form-control-lg @error('last_name') is-invalid @enderror" 
                                                           id="last_name" 
                                                           name="last_name" 
                                                           value="{{ old('last_name', $data->last_name) }}" 
                                                           placeholder="Enter your last name"
                                                           required>
                                                    @error('last_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">
                                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                                    Email Address
                                                </label>
                                                <input type="email" 
                                                       class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                                       id="email" 
                                                       name="email" 
                                                       value="{{ old('email', $data->email) }}" 
                                                       placeholder="Enter your email address"
                                                       required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="profile_picture" class="form-label">
                                                        <i class="fas fa-image me-2 text-primary"></i>
                                                        Profile Picture
                                                    </label>
                                                    <input type="file" 
                                                           class="form-control @error('profile_picture') is-invalid @enderror" 
                                                           id="profile_picture" 
                                                           name="profile_picture" 
                                                           accept="image/*">
                                                    <div class="form-text">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Supported formats: JPEG, PNG, JPG, GIF (Max: 5MB)
                                                    </div>
                                                    @error('profile_picture')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-calendar me-2 text-primary"></i>
                                                        Registration Date
                                                    </label>
                                                    <div class="form-control-plaintext">
                                                        <span class="badge bg-light text-dark">
                                                            <i class="fas fa-clock me-1"></i>
                                                            {{ $data->created_at->format('d M Y, h:i A') }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-actions mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg me-3">
                                                    <i class="fas fa-save me-2"></i>
                                                    Update Profile
                                                </button>
                                                <button type="reset" class="btn btn-outline-secondary btn-lg">
                                                    <i class="fas fa-undo me-2"></i>
                                                    Reset Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <!-- Account Statistics Card -->
                                <div class="profile-card mt-4">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">
                                            <i class="fas fa-chart-bar me-2"></i>
                                            Account Statistics
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row text-center">
                                            <div class="col-md-4 mb-3">
                                                <div class="stat-item">
                                                    <div class="stat-icon bg-primary">
                                                        <i class="fas fa-calendar-check"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <h4 class="stat-number">{{ $data->created_at->diffInDays(now()) }}</h4>
                                                        <p class="stat-label">Days Active</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="stat-item">
                                                    <div class="stat-icon bg-success">
                                                        <i class="fas fa-check-circle"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <h4 class="stat-number">{{ $data->is_approve ? '100%' : '0%' }}</h4>
                                                        <p class="stat-label">Account Status</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="stat-item">
                                                    <div class="stat-icon bg-info">
                                                        <i class="fas fa-shield-alt"></i>
                                                    </div>
                                                    <div class="stat-content">
                                                        <h4 class="stat-number">{{ $data->is_admin ? 'Admin' : 'User' }}</h4>
                                                        <p class="stat-label">Role</p>
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
</div>

<!-- Custom CSS for Profile Page -->
<style>
.profile-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.profile-title {
    font-weight: 700;
    margin: 0;
}

.profile-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-weight: 600;
    font-size: 0.9rem;
}

.status-approved {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 2px solid #28a745;
}

.status-pending {
    background: rgba(255, 193, 7, 0.2);
    color: #ffc107;
    border: 2px solid #ffc107;
}

.profile-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: none;
    overflow: hidden;
    transition: all 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.12);
}

.profile-picture-card {
    text-align: center;
    padding: 2rem;
}

.profile-picture-container {
    position: relative;
    display: inline-block;
    margin-bottom: 1rem;
}

.profile-picture, .profile-picture-placeholder {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.profile-picture-placeholder {
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
}

.profile-picture-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.profile-picture-container:hover .profile-picture-overlay {
    opacity: 1;
}

.upload-btn {
    color: white;
    cursor: pointer;
    text-align: center;
    padding: 1rem;
}

.upload-btn i {
    display: block;
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.profile-name {
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.profile-email {
    font-size: 0.95rem;
    margin-bottom: 1rem;
}

.profile-meta {
    font-size: 0.9rem;
    color: #6c757d;
}

.meta-item {
    display: inline-flex;
    align-items: center;
}

.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
    padding: 1.5rem;
}

.card-title {
    color: #2c3e50;
    font-weight: 600;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.75rem;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control-lg {
    padding: 1rem 1.25rem;
    font-size: 1rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

.form-actions {
    padding-top: 1.5rem;
    border-top: 1px solid #e9ecef;
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.btn-outline-secondary {
    border: 2px solid #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.stat-item {
    padding: 1.5rem;
    text-align: center;
}

.stat-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.5rem;
}

.stat-number {
    font-size: 1.75rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

.alert {
    border-radius: 10px;
    border: none;
    padding: 1rem 1.25rem;
}

.alert-success {
    background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
    color: #155724;
}

.alert-danger {
    background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
    color: #721c24;
}

.badge {
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    border-radius: 20px;
}

.bg-light {
    background: #f8f9fa !important;
    color: #495057 !important;
}

@media (max-width: 768px) {
    .profile-header {
        padding: 1.5rem;
        text-align: center;
    }
    
    .profile-picture, .profile-picture-placeholder {
        width: 120px;
        height: 120px;
    }
    
    .form-actions {
        text-align: center;
    }
    
    .btn {
        margin-bottom: 0.5rem;
        width: 100%;
    }
}
</style>

<!-- JavaScript for Profile Picture Preview -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profilePictureInput = document.getElementById('profilePictureInput');
    const profilePicturePreview = document.getElementById('profilePicturePreview');
    
    if (profilePictureInput) {
        profilePictureInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        if (profilePicturePreview.tagName === 'IMG') {
                            profilePicturePreview.src = e.target.result;
                        } else {
                            // Replace placeholder with image
                            profilePicturePreview.outerHTML = `<img src="${e.target.result}" alt="Profile Picture" class="profile-picture" id="profilePicturePreview">`;
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    alert('Please select a valid image file.');
                }
            }
        });
    }
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    });
});
</script>
@endsection
