@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')
<div class="loginarea sp_top_100 sp_bottom_100">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-md-8 offset-md-2" data-aos="fade-up">
                <ul class="nav  tab__button__wrap text-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="single__tab__link active" data-bs-toggle="tab" data-bs-target="#projects__one" type="button">LogIn</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="single__tab__link" data-bs-toggle="tab" data-bs-target="#projects__two" type="button">SignUp</button>
                    </li>
                </ul>
            </div>


            <div class="tab-content tab__content__wrapper" id="myTabContent" data-aos="fade-up">

                <div class="tab-pane fade active show" id="projects__one" role="tabpanel" aria-labelledby="projects__one">
                    <div class="col-xl-8 col-md-8 offset-md-2">
                        <div class="loginarea__wraper">
                            <div class="login__heading">
                                <h5 class="login__title">LogIn</h5>
                                <p class="login__description">Log into your account</p>
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

                            <form action="{{route('login')}}" method="POST">
                                @csrf
                                <div class="login__form">
                                    <label class="form__label">Email</label>
                                    <input class="common__login__input" type="text" name="email" placeholder="Your username or email" required>

                                </div>
                                <div class="login__form">
                                    <label class="form__label">Password</label>
                                    <input class="common__login__input" type="password" name="password" placeholder="Password" required>

                                </div>
                                <div class="login__form d-flex justify-content-between flex-wrap gap-2">
                                    <div class="form__check">
                                        <input id="forgot" type="checkbox" >
                                        <label for="forgot"> Remember me</label>
                                    </div>
                                    {{-- <div class="text-end login__form__link">
                                        <a href="#">Forgot your password?</a>
                                    </div> --}}
                                </div>
                                <div class="login__button">
                                    <button type="submit" class="default__button">Login</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="projects__two" role="tabpanel" aria-labelledby="projects__two">
                    <div class="col-xl-8 offset-md-2">
                        <div class="loginarea__wraper">
                            <div class="login__heading">
                                <h5 class="login__title">SignUp</h5>
                                <p class="login__description">Fill in your credentials to create an account</p>
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

                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <div class="login__form">
                                    <label class="form__label">First Name</label>
                                    <input class="common__login__input" type="text" name="first_name" placeholder="Your first name" required>
                                </div>
                                <div class="login__form">
                                    <label class="form__label">Last Name</label>
                                    <input class="common__login__input" type="text" name="last_name" placeholder="Your last name" required>
                                </div>
                                <div class="login__form">
                                    <label class="form__label">Email</label>
                                    <input class="common__login__input" type="email" name="email" placeholder="Your email" required>
                                </div>
                                <div class="login__form">
                                    <label class="form__label">Password</label>
                                    <input class="common__login__input" type="password" name="password" placeholder="Password" required>
                                </div>
                                <div class="login__button">
                                    <button type="submit" class="default__button">Register</button>
                                </div>
                            </form>




                        </div>
                    </div>

                </div>



            </div>

        </div>

        <div class=" login__shape__img educationarea__shape_image">
            <img loading="lazy"  class="hero__shape hero__shape__1" src="img/education/hero_shape2.png" alt="Shape">
            <img loading="lazy"  class="hero__shape hero__shape__2" src="img/education/hero_shape3.png" alt="Shape">
            <img loading="lazy"  class="hero__shape hero__shape__3" src="img/education/hero_shape4.png" alt="Shape">
            <img loading="lazy"  class="hero__shape hero__shape__4" src="img/education/hero_shape5.png" alt="Shape">
        </div>


    </div>
</div>

@endsection
