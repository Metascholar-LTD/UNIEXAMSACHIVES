@extends('layout.app')

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
    console.log('Initializing auth tabs...');
    
    // Tab switching functionality
    const tabBtns = document.querySelectorAll('.tab-btn');
    const formPanels = document.querySelectorAll('.auth-form-panel');
    
    console.log('Found tab buttons:', tabBtns.length);
    console.log('Found form panels:', formPanels.length);
    
    // Check if elements exist before proceeding
    if (tabBtns.length === 0) {
        console.error('No tab buttons found! Check if .tab-btn elements exist.');
        console.log('Available elements with similar classes:', document.querySelectorAll('[class*="tab"]'));
        return;
    }
    
    if (formPanels.length === 0) {
        console.error('No form panels found! Check if .auth-form-panel elements exist.');
        console.log('Available elements with similar classes:', document.querySelectorAll('[class*="panel"]'));
        return;
    }
    
    // Debug: Check initial state
    console.log('Initial state:');
    tabBtns.forEach((btn, i) => {
        console.log(`Button ${i}:`, btn.getAttribute('data-tab'), 'Active:', btn.classList.contains('active'));
    });
    formPanels.forEach((panel, i) => {
        console.log(`Panel ${i}:`, panel.id, 'Active:', panel.classList.contains('active'), 'Display:', window.getComputedStyle(panel).display);
    });
    
    // Add click event listeners to tab buttons
    tabBtns.forEach((btn) => {
        if (btn) { // Additional null check
            btn.addEventListener('click', () => {
                try {
                    const targetTab = btn.getAttribute('data-tab');
                    console.log('Clicked tab:', targetTab);
                    
                    if (!targetTab) {
                        console.error('No data-tab attribute found on button');
                        return;
                    }
                    
                    // Remove active class from all buttons and panels
                    tabBtns.forEach(b => b.classList.remove('active'));
                    formPanels.forEach(p => p.classList.remove('active'));
                    
                    // Add active class to clicked button and corresponding panel
                    btn.classList.add('active');
                    
                    const targetPanel = document.getElementById(targetTab + '-panel');
                    console.log('Target panel:', targetPanel);
                    
                    if (targetPanel) {
                        targetPanel.classList.add('active');
                        console.log('Tab switched successfully to:', targetTab);
                        console.log('Panel classes after switch:', targetPanel.className);
                        console.log('Panel display after switch:', window.getComputedStyle(targetPanel).display);
                    } else {
                        console.error('Could not find panel for tab:', targetTab);
                        console.log('Available panels:', Array.from(formPanels).map(p => p.id));
                    }
                } catch (error) {
                    console.error('Error in tab click handler:', error);
                }
            });
        }
    });

    // Input focus effects - with null checks
    const inputs = document.querySelectorAll('.animated-input');
    console.log('Found animated inputs:', inputs.length);
    if (inputs.length > 0) {
        inputs.forEach((input, index) => {
            if (input && input.parentElement) {
                try {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });
                    
                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('focused');
                    });
                    console.log(`Input ${index} event listeners added successfully`);
                } catch (error) {
                    console.error(`Error adding event listeners to input ${index}:`, error);
                }
            } else {
                console.warn(`Input ${index} or its parent element not found:`, input);
            }
        });
    }

    // Form submission animations - with null checks
    const forms = document.querySelectorAll('.animated-form');
    console.log('Found animated forms:', forms.length);
    if (forms.length > 0) {
        forms.forEach((form, index) => {
            if (form) {
                try {
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
                    console.log(`Form ${index} event listener added successfully`);
                } catch (error) {
                    console.error(`Error adding event listener to form ${index}:`, error);
                }
            } else {
                console.warn(`Form ${index} not found`);
            }
        });
    }
    
    console.log('Auth tabs initialized successfully');
    
    // Manual test function
    window.testTabSwitch = function(tabName) {
        console.log('Manual test: switching to', tabName);
        const targetPanel = document.getElementById(tabName + '-panel');
        if (targetPanel) {
            // Remove active from all
            formPanels.forEach(p => p.classList.remove('active'));
            tabBtns.forEach(b => b.classList.remove('active'));
            
            // Add active to target
            targetPanel.classList.add('active');
            const targetBtn = document.querySelector(`[data-tab="${tabName}"]`);
            if (targetBtn) targetBtn.classList.add('active');
            
            console.log('Manual switch complete. Panel display:', window.getComputedStyle(targetPanel).display);
        }
    };
    
    // Debug function to check DOM structure
    window.debugDOM = function() {
        console.log('=== DOM Debug Info ===');
        console.log('Document ready state:', document.readyState);
        console.log('Body children count:', document.body.children.length);
        
        const authTabs = document.querySelector('.auth-tabs');
        console.log('Auth tabs container:', authTabs);
        
        if (authTabs) {
            console.log('Auth tabs children:', authTabs.children);
            console.log('Tab buttons in auth-tabs:', authTabs.querySelectorAll('.tab-btn').length);
            console.log('Form panels in auth-tabs:', authTabs.querySelectorAll('.auth-form-panel').length);
        }
        
        // Check specific elements
        console.log('Tab buttons by class:', document.querySelectorAll('.tab-btn').length);
        console.log('Form panels by class:', document.querySelectorAll('.auth-form-panel').length);
        console.log('Login panel by ID:', document.getElementById('login-panel'));
        console.log('Register panel by ID:', document.getElementById('register-panel'));
    };
    
    // Run debug function
    debugDOM();
    
    // Additional debugging for specific elements
    console.log('=== Element Debug ===');
    console.log('Tab buttons found:', document.querySelectorAll('.tab-btn').length);
    console.log('Form panels found:', document.querySelectorAll('.auth-form-panel').length);
    console.log('Login panel:', document.getElementById('login-panel'));
    console.log('Register panel:', document.getElementById('register-panel'));
    console.log('Auth tabs container:', document.querySelector('.auth-tabs'));
    
    // Check if CSS is loaded
    const computedStyle = window.getComputedStyle(document.body);
    console.log('Body computed styles loaded:', computedStyle.fontFamily !== '');
}

// Try multiple approaches to ensure DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded fired');
    initializeAuthTabs();
});

// Fallback with setTimeout
setTimeout(function() {
    console.log('setTimeout fallback fired');
    if (document.readyState === 'loading') {
        console.log('Document still loading, waiting...');
        setTimeout(initializeAuthTabs, 500);
    } else {
        initializeAuthTabs();
    }
}, 100);

// Additional fallback for edge cases
window.addEventListener('load', function() {
    console.log('Window load event fired');
    // Check if tabs were already initialized
    if (!document.querySelector('.tab-btn.active')) {
        console.log('Tabs not initialized yet, trying again...');
        initializeAuthTabs();
    }
});

// Password toggle functionality
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    if (!input) {
        console.error('Password input not found:', inputId);
        return;
    }
    
    const toggle = input.parentElement?.querySelector('.password-toggle i');
    if (!toggle) {
        console.error('Password toggle button not found for input:', inputId);
        return;
    }
    
    if (input.type === 'password') {
        input.type = 'text';
        toggle.className = 'icofont-eye-blocked';
    } else {
        input.type = 'password';
        toggle.className = 'icofont-eye';
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
