@extends('layout.app')

@push('styles')
<style>
    /* Custom styling for the university crest in orbit */
    .crest-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid rgba(255, 255, 255, 0.8);
        background: rgba(255, 255, 255, 0.1);
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        transition: transform 0.3s ease;
        padding: 2px;
    }
    
    .crest-image:hover {
        transform: scale(1.1);
        border-color: rgba(255, 255, 255, 1);
        background: rgba(255, 255, 255, 0.2);
    }
    
    /* Ensure the orbit animation works properly with the image */
    .orbit-icon-1 {
        transform: rotate(0deg) translateX(150px) rotate(0deg);
    }

    /* Admin portal notice styling */
    .admin-portal-notice {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 16px;
        text-align: center;
    }

    .admin-portal-notice p {
        margin: 0;
        font-size: 0.9rem;
        color: #1e40af;
        font-weight: 500;
    }

    .admin-portal-link {
        color: #3b82f6;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px solid #3b82f6;
        transition: all 0.3s ease;
    }

    .admin-portal-link:hover {
        color: #1e40af;
        border-bottom-color: #1e40af;
    }
</style>
@endpush

@section('content')
@include('frontend.auth_header')
@include('frontend.theme_shadow')
@include('components.modern-notifications')

<div class="modern-auth-container">
    <!-- Left Side - Animated Background -->
    <div class="auth-left-side">
        <div class="ripple-background">
            <div class="ripple-circle ripple-1"></div>
            <div class="ripple-circle ripple-2"></div>
            <div class="ripple-circle ripple-3"></div>
            <div class="ripple-circle ripple-4"></div>
        </div>
        
        <div class="tech-orbit-display">
            <h1 class="orbit-title">University Digital Archive</h1>
            <h2 class="orbit-subtitle" id="typewriter-subtitle"></h2>
            <div class="orbit-container">
                <div class="orbit-path"></div>
                <div class="orbit-icon orbit-icon-1">
                    <img src="{{ asset('img/crest.ico') }}" alt="University Crest" class="crest-image">
                </div>
                <div class="orbit-icon orbit-icon-2">
                    <i class="icofont-book"></i>
                </div>
                <div class="orbit-icon orbit-icon-3">
                    <i class="icofont-library"></i>
                </div>
                <div class="orbit-icon orbit-icon-4">
                    <i class="icofont-document"></i>
                </div>
                <div class="orbit-icon orbit-icon-5">
                    <i class="icofont-search-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Auth Forms -->
    <div class="auth-right-side">
        <div class="auth-tabs">
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="login">
                    <span class="tab-text">LOGIN SUPER ADMIN</span>
                    <div class="tab-indicator"></div>
                </button>
                <button class="tab-btn" data-tab="register">
                    <span class="tab-text">Sign Up</span>
                    <div class="tab-indicator"></div>
                </button>
            </div>

            <!-- Login Form -->
            <div class="auth-form-panel active" id="login-panel">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="form-title">SUPER ADMIN ACCESS</h2>
                        <p class="form-subtitle">Sign in to your super admin account</p>
                        <div class="admin-portal-notice">
                            <p><strong>Restricted Access:</strong> This portal is exclusively for administrative users. Regular users should use the <a href="{{ route('frontend.login') }}" class="admin-portal-link">standard login</a>.</p>
                        </div>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.login.user') }}" class="animated-form">
                        @csrf
                        <div class="form-group">
                            <div class="input-container">
                                <input type="email" name="email" id="login-email" class="animated-input" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="password" name="password" id="login-password" class="animated-input" placeholder="Enter your password" required autocomplete="current-password">
                                <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                                    <i class="icofont-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <span class="checkmark"></span>
                                Remember me
                            </label>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Sign In</span>
                            <div class="btn-ripple"></div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Register Form -->
            <div class="auth-form-panel" id="register-panel">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="form-title">Create Account</h2>
                        <p class="form-subtitle">Join our digital archive community</p>
                        <div class="admin-portal-notice">
                            <p><strong>Note:</strong> New accounts created here will have access to the administrative system.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="animated-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <div class="input-container">
                                    <input type="text" name="first_name" id="register-firstname" class="animated-input" placeholder="First name" value="{{ old('first_name') }}" required autocomplete="given-name">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-container">
                                    <input type="text" name="last_name" id="register-lastname" class="animated-input" placeholder="Last name" value="{{ old('last_name') }}" required autocomplete="family-name">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="email" name="email" id="register-email" class="animated-input" placeholder="Enter your email" value="{{ old('email') }}" required autocomplete="email">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <select name="department_id" id="register-department" class="animated-input">
                                    <option value="" disabled selected>Choose your Department/Faculty/Unit</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="password" name="password" id="register-password" class="animated-input" placeholder="Create a temporary password" required autocomplete="new-password">
                                <button type="button" class="password-toggle" onclick="togglePassword('register-password')">
                                    <i class="icofont-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="submit-btn">
                            <span>Create Account</span>
                            <div class="btn-ripple"></div>
                        </button>
                    </form>

                    <div class="form-footer">
                        <p class="terms-text">By creating an account, you agree to our <a href="#" class="terms-link">Terms of Service</a> and <a href="#" class="terms-link">Privacy Policy</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Password toggle functionality
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggleBtn = input.nextElementSibling;
    const icon = toggleBtn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('icofont-eye');
        icon.classList.add('icofont-eye-blocked');
    } else {
        input.type = 'password';
        icon.classList.remove('icofont-eye-blocked');
        icon.classList.add('icofont-eye');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const authPanels = document.querySelectorAll('.auth-form-panel');

    // Tab switching functionality
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab');
            
            // Update active tab button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            // Update active panel
            authPanels.forEach(panel => {
                panel.classList.remove('active');
                if (panel.id === `${targetTab}-panel`) {
                    panel.classList.add('active');
                }
            });
        });
    });

    // Typewriter effect for subtitle
    const typewriterElement = document.getElementById('typewriter-subtitle');
    const texts = [
        'Registry Communication System',
        'Advanced User Portal',
        'Secure Access Gateway',
        'Administrative Hub'
    ];
    let textIndex = 0;
    let charIndex = 0;
    let isDeleting = false;

    function typeWriter() {
        const currentText = texts[textIndex];
        
        if (isDeleting) {
            typewriterElement.textContent = currentText.substring(0, charIndex - 1);
            charIndex--;
        } else {
            typewriterElement.textContent = currentText.substring(0, charIndex + 1);
            charIndex++;
        }

        if (!isDeleting && charIndex === currentText.length) {
            setTimeout(() => {
                isDeleting = true;
            }, 2000);
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            textIndex = (textIndex + 1) % texts.length;
        }

        const speed = isDeleting ? 100 : 150;
        setTimeout(typeWriter, speed);
    }

    if (typewriterElement) {
        typeWriter();
    }

    // Form validation and enhancement
    const forms = document.querySelectorAll('.animated-form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('.submit-btn');
            const btnText = submitBtn.querySelector('span');
            
            // Show loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Processing...';
            
            // Re-enable after a delay (in case of validation errors)
            setTimeout(() => {
                submitBtn.disabled = false;
                btnText.textContent = submitBtn.classList.contains('submit-btn') ? 'Sign In' : 'Create Account';
            }, 3000);
        });
    });

    // Input focus effects
    const inputs = document.querySelectorAll('.animated-input');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            if (!this.value) {
                this.parentElement.classList.remove('focused');
            }
        });
    });
});
</script>
@endpush
