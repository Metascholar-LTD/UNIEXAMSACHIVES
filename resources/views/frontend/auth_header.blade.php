<header>
    <div class="headerarea headerarea__2 header__sticky header__area">
        <div class="container desktop__menu__wrapper uda-header-container">
            <div class="uda-navbar">
                <!-- Left: Logo Only -->
                <div class="uda-nav-left">
                    @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                        <a href="{{route('frontend.login')}}"><img loading="lazy" src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" class="uda-logo" alt="logo"></a>
                    @else
                        <a href="{{route('frontend.login')}}"><img loading="lazy" src="{{asset('img/cug_logo_new.jpeg')}}" class="uda-logo" alt="logo"></a>
                    @endif
                </div>

                <!-- Center: Empty - No System Title -->
                <div class="uda-nav-center">
                    <!-- Intentionally left empty for auth pages -->
                </div>

                <!-- Right: Language Switcher -->
                <div class="uda-nav-right">
                    <div class="language-switcher">
                        <button class="language-btn" id="languageToggle" title="Change Language">
                            <i class="icofont-globe"></i>
                        </button>
                        <div class="language-dropdown" id="languageDropdown">
                            <a href="#" class="language-option" data-lang="en">
                                <span class="flag">🇺🇸</span>
                                <span class="lang-name">English</span>
                            </a>
                            <a href="#" class="language-option" data-lang="fr">
                                <span class="flag">🇫🇷</span>
                                <span class="lang-name">Français</span>
                            </a>
                            <a href="#" class="language-option" data-lang="es">
                                <span class="flag">🇪🇸</span>
                                <span class="lang-name">Español</span>
                            </a>
                            <a href="#" class="language-option" data-lang="ar">
                                <span class="flag">🇸🇦</span>
                                <span class="lang-name">العربية</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mob_menu_wrapper">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                            <a href="{{route('frontend.login')}}"><img loading="lazy"  src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" style="width:200px; heigth:200px;" alt="logo"></a>
                        @else
                            <a href="{{route('frontend.login')}}"><img loading="lazy"  src="{{asset('img/cug_logo_new.jpeg')}}" style="width:200px; heigth:200px;" alt="logo"></a>
                        @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">
                        <div class="headerarea__right">
                            <!-- Mobile Language Switcher -->
                            <div class="language-switcher mobile-language-switcher">
                                <button class="language-btn mobile-language-btn" id="mobileLanguageToggle" title="Change Language">
                                    <i class="icofont-globe"></i>
                                </button>
                                <div class="language-dropdown mobile-language-dropdown" id="mobileLanguageDropdown">
                                    <a href="#" class="language-option" data-lang="en">
                                        <span class="flag">🇺🇸</span>
                                        <span class="lang-name">English</span>
                                    </a>
                                    <a href="#" class="language-option" data-lang="fr">
                                        <span class="flag">🇫🇷</span>
                                        <span class="lang-name">Français</span>
                                    </a>
                                    <a href="#" class="language-option" data-lang="es">
                                        <span class="flag">🇪🇸</span>
                                        <span class="lang-name">Español</span>
                                    </a>
                                    <a href="#" class="language-option" data-lang="ar">
                                        <span class="flag">🇸🇦</span>
                                        <span class="lang-name">العربية</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mobile-off-canvas">
                            <!-- Intentionally left empty for auth pages -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
    <div class="container desktop__menu__wrapper mt-3" id="successAlert">
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12">
                <div class="alert alert-success">
                    <p class="text-center">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        setTimeout(function() {
            document.getElementById('successAlert').style.display = 'none';
        }, 5000);
    </script>
    @endif
</header>
