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
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.3);
        border-radius: 12px;
        padding: 12px 16px;
        margin-top: 16px;
        text-align: center;
    }

    .admin-portal-notice p {
        margin: 0;
        font-size: 0.9rem;
        color: #991b1b;
        font-weight: 500;
    }

    .admin-portal-link {
        color: #ef4444;
        text-decoration: none;
        font-weight: 600;
        border-bottom: 1px solid #ef4444;
        transition: all 0.3s ease;
    }

    .admin-portal-link:hover {
        color: #dc2626;
        border-bottom-color: #dc2626;
    }

    /* Forgot password link styling */
    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin: 1rem 0;
    }

    .forgot-password-link {
        color: #6b7280;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border-bottom: 1px solid transparent;
    }

    .forgot-password-link:hover {
        color: #3b82f6;
        border-bottom-color: #3b82f6;
        text-decoration: none;
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
                        <div class="admin-portal-notice">
                            <p><strong>Note:</strong> This portal is exclusively for Regular users. Administrative users should use the <a href="{{ route('admin.login') }}" class="admin-portal-link">Admin Portal</a> instead.</p>
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
                            <a href="{{ route('password.request') }}" class="forgot-password-link">
                                Forgot Password?
                            </a>
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
                                <select name="staff_category" id="register-staff-category" class="animated-input">
                                    <option value="" disabled selected>Choose your Staff Category</option>
                                    <option value="Junior Staff">Junior Staff</option>
                                    <option value="Senior Staff">Senior Staff</option>
                                    <option value="Senior Member (Non-Teaching)">Senior Member (Non-Teaching)</option>
                                    <option value="Senior Member (Teaching)">Senior Member (Teaching)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <select name="position_id" id="register-position" class="animated-input">
                                    <option value="" selected>Choose your Position (Optional)</option>
                                    @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="input-container">
                                <input type="password" name="password" id="register-password" class="animated-input" placeholder="Create a temporary password" required>
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

// Language switcher functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize both desktop and mobile language switchers
    initializeLanguageSwitcher('languageToggle', 'languageDropdown');
    initializeLanguageSwitcher('mobileLanguageToggle', 'mobileLanguageDropdown');
    
    // Load saved language preference
    loadSavedLanguage();
});

function initializeLanguageSwitcher(toggleId, dropdownId) {
    const languageToggle = document.getElementById(toggleId);
    const languageDropdown = document.getElementById(dropdownId);
    
    if (languageToggle && languageDropdown) {
        // Toggle dropdown on button click
        languageToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            languageDropdown.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!languageToggle.contains(e.target) && !languageDropdown.contains(e.target)) {
                languageDropdown.classList.remove('show');
            }
        });
        
        // Handle language selection
        const languageOptions = languageDropdown.querySelectorAll('.language-option');
        languageOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedLang = this.getAttribute('data-lang');
                
                // Update button to show selected language
                const flag = this.querySelector('.flag').textContent;
                const langName = this.querySelector('.lang-name').textContent;
                
                // You can implement actual language switching logic here
                console.log('Language selected:', selectedLang, langName);
                
                // Update both desktop and mobile buttons
                updateLanguageButtons(flag, langName);
                
                // Close all dropdowns
                document.querySelectorAll('.language-dropdown').forEach(dropdown => {
                    dropdown.classList.remove('show');
                });
                
                // Store selected language in localStorage
                localStorage.setItem('selectedLanguage', selectedLang);
                
                // Show success message (optional)
                showLanguageChangeMessage(langName);
            });
        });
    }
}

function updateLanguageButtons(flag, langName) {
    // Update all language toggle buttons
    const allLanguageToggles = document.querySelectorAll('.language-btn');
    allLanguageToggles.forEach(toggle => {
        toggle.innerHTML = `<span class="flag">${flag}</span>`;
        toggle.title = `Current: ${langName}`;
    });
    
    // Return to globe icon after 3 seconds
    setTimeout(() => {
        allLanguageToggles.forEach(toggle => {
            toggle.innerHTML = `<i class="icofont-globe"></i>`;
            toggle.title = `Change Language (Current: ${langName})`;
        });
    }, 3000);
}

function loadSavedLanguage() {
    const savedLang = localStorage.getItem('selectedLanguage');
    if (savedLang) {
        // Find the corresponding language option
        const languageOption = document.querySelector(`[data-lang="${savedLang}"]`);
        if (languageOption) {
            const flag = languageOption.querySelector('.flag').textContent;
            const langName = languageOption.querySelector('.lang-name').textContent;
            
            // Update buttons but don't auto-return to globe on page load
            const allLanguageToggles = document.querySelectorAll('.language-btn');
            allLanguageToggles.forEach(toggle => {
                toggle.innerHTML = `<span class="flag">${flag}</span>`;
                toggle.title = `Current: ${langName}`;
            });
        }
    }
}

// Function to show language change message using modern notification system
function showLanguageChangeMessage(langName) {
    // Use the modern notification system if available
    if (typeof showNotification === 'function') {
        showNotification('success', 'Language Changed!', `Language changed to ${langName}`);
    } else {
        // Fallback to simple message
        const messageDiv = document.createElement('div');
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            padding: 12px 20px;
            border-radius: 6px;
            background: #28a745;
            color: white;
            font-size: 14px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        messageDiv.textContent = `Language changed to ${langName}`;
        
        document.body.appendChild(messageDiv);
        
        // Animate in
        setTimeout(() => {
            messageDiv.style.transform = 'translateX(0)';
        }, 100);
        
        // Remove after 3 seconds
        setTimeout(() => {
            messageDiv.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(messageDiv);
            }, 300);
        }, 3000);
    }
}

// Typewriter Effect for Subtitle
function typewriterEffect() {
    const subtitle = document.getElementById('typewriter-subtitle');
    const texts = [
        'Secure Digital Repository',
        'Academic Excellence',
        'Knowledge Preservation',
        'Innovation Hub'
    ];
    let currentIndex = 0;
    let isTyping = true;
    let charIndex = 0;
    
    function type() {
        const currentText = texts[currentIndex];
        if (isTyping && charIndex < currentText.length) {
            subtitle.textContent = currentText.slice(0, charIndex + 1);
            charIndex++;
            setTimeout(type, 100); // Typing speed
        } else if (isTyping && charIndex >= currentText.length) {
            // Finished typing, wait 2 seconds
            setTimeout(() => {
                isTyping = false;
                erase();
            }, 2000);
        }
    }
    
    function erase() {
        const currentText = texts[currentIndex];
        if (!isTyping && charIndex > 0) {
            subtitle.textContent = currentText.slice(0, charIndex - 1);
            charIndex--;
            setTimeout(erase, 50); // Erasing speed (faster than typing)
        } else if (!isTyping && charIndex <= 0) {
            // Finished erasing, move to next text
            currentIndex = (currentIndex + 1) % texts.length;
            isTyping = true;
            charIndex = 0;
            setTimeout(type, 500); // Small pause before restarting
        }
    }
    
    // Start the typewriter effect
    type();
}

// Initialize typewriter effect when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Start typewriter effect after a short delay
    setTimeout(typewriterEffect, 1000);
});
</script>
@endpush
