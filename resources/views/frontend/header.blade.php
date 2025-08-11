<header>
    <div class="headerarea headerarea__2 header__sticky header__area">
        <div class="container desktop__menu__wrapper uda-header-container">
            <div class="uda-navbar">
                <!-- Left: Logo -->
                <div class="uda-nav-left">
                    @if (Auth::check())
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                            <a href="{{route('dashboard')}}"><img loading="lazy" src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" class="uda-logo" alt="logo"></a>
                        @else
                            <a href="{{route('dashboard')}}"><img loading="lazy" src="{{asset('img/cug_logo_new.jpeg')}}" class="uda-logo" alt="logo"></a>
                        @endif
                    @else
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                            <a href="{{route('frontend.login')}}"><img loading="lazy" src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" class="uda-logo" alt="logo"></a>
                        @else
                            <a href="{{route('frontend.login')}}"><img loading="lazy" src="{{asset('img/cug_logo_new.jpeg')}}" class="uda-logo" alt="logo"></a>
                        @endif
                    @endif
                </div>

                <!-- Center: Title Pill -->
                <div class="uda-nav-center">
                    @php
                        $udaTitle = (count($systemDetail) > 0 && $systemDetail[0]->title) ? $systemDetail[0]->title : 'University Digital Archive System';
                    @endphp
                    <div class="uda-title-pill">{{ $udaTitle }}</div>
                </div>

                <!-- Right: Auth Buttons -->
                <div class="uda-nav-right">
                    @if (Auth::check())
                        <a href="{{route('logout')}}" class="uda-btn">Logout</a>
                    @else
                        <a href="{{route('frontend.login')}}" class="uda-btn">Register / Login</a>
                    @endif
                </div>
            </div>
        </div>


        <div class="container-fluid mob_menu_wrapper">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                    @if (Auth::check())
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                        <a href="{{route('dashboard')}}"><img loading="lazy"  src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" style="width:200px; heigth:200px;" alt="logo"></a>
                        @else
                            <a href="{{route('dashboard')}}"><img loading="lazy"  src="{{asset('img/cug_logo_new.jpeg')}}" style="width:200px; heigth:200px;" alt="logo"></a>

                        @endif

                    @else
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                            <a href="{{route('frontend.login')}}"><img loading="lazy"  src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" style="width:200px; heigth:200px;" alt="logo"></a>
                        @else
                            <a href="{{route('frontend.login')}}"><img loading="lazy"  src="{{asset('img/cug_logo_new.jpeg')}}" style="width:200px; heigth:200px;" alt="logo"></a>

                        @endif
                    @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">

                        <div class="headerarea__right">

                            {{-- <div class="header__cart">
                                <a href="#"> <i class="icofont-cart-alt"></i></a>
                                <div class="header__right__dropdown__wrapper">
                                    <div class="header__right__dropdown__inner">
                                        <div class="single__header__right__dropdown">

                                            <div class="header__right__dropdown__img">
                                                <a href="#">
                                                    <img loading="lazy"  src="img/grid/cart1.jpg" alt="photo">
                                                </a>
                                            </div>
                                            <div class="header__right__dropdown__content">

                                                <a href="shop-product.html">Web Directory</a>
                                                <p>1 x <span class="price">$ 80.00</span></p>

                                            </div>
                                            <div class="header__right__dropdown__close">
                                                <a href="#"><i class="icofont-close-line"></i></a>
                                            </div>
                                        </div>

                                        <div class="single__header__right__dropdown">

                                            <div class="header__right__dropdown__img">
                                                <a href="#">
                                                    <img loading="lazy"  src="img/grid/cart2.jpg" alt="photo">
                                                </a>
                                            </div>
                                            <div class="header__right__dropdown__content">

                                                <a href="shop-product.html">Design Minois</a>
                                                <p>1 x <span class="price">$ 60.00</span></p>

                                            </div>
                                            <div class="header__right__dropdown__close">
                                                <a href="#"><i class="icofont-close-line"></i></a>
                                            </div>
                                        </div>

                                        <div class="single__header__right__dropdown">

                                            <div class="header__right__dropdown__img">
                                                <a href="#">
                                                    <img loading="lazy"  src="img/grid/cart3.jpg" alt="photo">
                                                </a>
                                            </div>
                                            <div class="header__right__dropdown__content">

                                                <a href="shop-product.html">Crash Course</a>
                                                <p>1 x <span class="price">$ 70.00</span></p>

                                            </div>
                                            <div class="header__right__dropdown__close">
                                                <a href="#"><i class="icofont-close-line"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="dropdown__price">Total: <span>$1,100.00</span>
                                    </p>
                                    <div class="header__right__dropdown__button">
                                        <a href="#" class="white__color">VIEW
                                    CART</a>
                                        <a href="#" class="blue__color">CHECKOUT</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <div class="mobile-off-canvas">
                            {{-- <a class="mobile-aside-button" href="#"><i class="icofont-navigation-menu"></i></a> --}}
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


