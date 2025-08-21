@extends('layout.app')

@push('styles')
<style>
    /* Custom styling for the university crest in orbit */
    .orbit-icon-6 {
        animation: orbit-rotate 20s linear infinite;
        animation-delay: -16.67s; /* 6th position timing */
    }
    
    .crest-image {
        width: 40px;
        height: 40px;
        object-fit: contain;
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.3));
        transition: transform 0.3s ease;
    }
    
    .crest-image:hover {
        transform: scale(1.1);
    }
    
    /* Ensure the orbit path accommodates 6 icons */
    .orbit-path {
        width: 300px;
        height: 300px;
    }
    
    /* Adjust orbit icon positions for 6 icons */
    .orbit-icon-1 { transform: rotate(0deg) translateX(150px) rotate(0deg); }
    .orbit-icon-2 { transform: rotate(60deg) translateX(150px) rotate(-60deg); }
    .orbit-icon-3 { transform: rotate(120deg) translateX(150px) rotate(-120deg); }
    .orbit-icon-4 { transform: rotate(180deg) translateX(150px) rotate(-180deg); }
    .orbit-icon-5 { transform: rotate(240deg) translateX(150px) rotate(-240deg); }
    .orbit-icon-6 { transform: rotate(300deg) translateX(150px) rotate(-300deg); }
</style>
@endpush

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

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
            <div class="orbit-container">
                <div class="orbit-path"></div>
                <div class="orbit-icon orbit-icon-1">
                    <i class="icofont-graduation-cap"></i>
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
                <div class="orbit-icon orbit-icon-6">
                    <img src="{{ asset('img/crest.png') }}" alt="University Crest" class="crest-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side - Auth Forms -->
    <div class="auth-right-side">
        <div class="auth-tabs">
            <div class="tab-buttons">
                <button class="tab-btn active" data-tab="login">
                    <span class="tab-text">Sign In</span>
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
                        <h2 class="form-title">Welcome Back</h2>
                        <p class="form-subtitle">Sign in to your account</p>
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
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{route('login')}}" method="POST" class="animated-form">
                        @csrf
                        <div class="form-group">
                            <div class="input-container">
                                <input type="email" name="email" id="login-email" class="animated-input" placeholder="Enter your email" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('login-password')" style="display: none;">
                                    <i class="icofont-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="password" name="password" id="login-password" class="animated-input" placeholder="Enter your password" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                                    <i class="icofont-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-options">
                            <label class="checkbox-container">
                                <input type="checkbox" name="remember">
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

                    <form method="POST" action="{{ route('register') }}" class="animated-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <div class="input-container">
                                    <input type="text" name="first_name" id="register-firstname" class="animated-input" placeholder="First name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-container">
                                    <input type="text" name="last_name" id="register-lastname" class="animated-input" placeholder="Last name" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="email" name="email" id="register-email" class="animated-input" placeholder="Enter your email" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="password" name="password" id="register-password" class="animated-input" placeholder="Create a password" required>
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
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Function to initialize tabs
function initializeAuthTabs() {
    // Tab switching functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const formPanels = document.querySelectorAll('.auth-form-panel');
    
    // Check if elements exist before proceeding
    if (tabBtns.length === 0 || formPanels.length === 0) {
        return;
    }
    
    // Add click event listeners to tab buttons
    tabBtns.forEach((btn) => {
        if (btn) {
            btn.addEventListener('click', () => {
                const targetTab = btn.getAttribute('data-tab');
                
                if (!targetTab) return;
                
                // Remove active class from all buttons and panels
                tabBtns.forEach(b => b.classList.remove('active'));
                formPanels.forEach(p => p.classList.remove('active'));
                
                // Add active class to clicked button and corresponding panel
                btn.classList.add('active');
                
                const targetPanel = document.getElementById(targetTab + '-panel');
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        }
    });

    // Input focus effects
    const inputs = document.querySelectorAll('.animated-input');
    inputs.forEach(input => {
        if (input && input.parentElement) {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('focused');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('focused');
            });
        }
    });

    // Form submission animations
    const forms = document.querySelectorAll('.animated-form');
    forms.forEach(form => {
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.submit-btn');
                if (submitBtn) {
                    submitBtn.classList.add('loading');
                    
                    // Remove loading class after form submission
                    setTimeout(() => {
                        submitBtn.classList.remove('loading');
                    }, 2000);
                }
            });
        }
    });
    
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', initializeAuthTabs);

// Password toggle functionality
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggle = input.parentElement?.querySelector('.password-toggle i');
    
    if (input && toggle) {
        if (input.type === 'password') {
            input.type = 'text';
            toggle.className = 'icofont-eye-blocked';
        } else {
            input.type = 'password';
            toggle.className = 'icofont-eye';
        }
    }
}

// Add ripple effect to buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('submit-btn')) {
        const ripple = e.target.querySelector('.btn-ripple');
        if (ripple) {
            ripple.style.left = (e.offsetX - ripple.offsetWidth / 2) + 'px';
            ripple.style.top = (e.offsetY - ripple.offsetHeight / 2) + 'px';
            ripple.classList.add('active');
            
            setTimeout(() => {
                ripple.classList.remove('active');
            }, 600);
        }
    }
});
</script>
@endpush
