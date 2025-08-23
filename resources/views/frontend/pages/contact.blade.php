@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<div class="contactarea sp_bottom_100 sp_top_100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12" data-aos="fade-up">
                <div class="section__title text-center">
                    <div class="section__title__button">
                        <div class="default__small__button">Contact Us</div>
                    </div>
                    <div class="section__title__heading">
                        <h2>Get In Touch With Us</h2>
                    </div>
                    <div class="section__title__content">
                        <p>Have questions or need assistance? We're here to help you with any inquiries about our services.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xl-8 col-lg-8" data-aos="fade-up">
                <div class="contactarea__form">
                    <div class="contactarea__form__heading">
                        <h3>Send us a Message</h3>
                    </div>
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <input type="text" name="name" placeholder="Your Name" required>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-6">
                                <div class="form-group">
                                    <input type="email" name="email" placeholder="Your Email" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" name="subject" placeholder="Subject" required>
                        </div>
                        <div class="form-group">
                            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="default__button">Send Message <i class="icofont-long-arrow-right"></i></button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-xl-4 col-lg-4" data-aos="fade-up">
                <div class="contactarea__info">
                    <div class="contactarea__info__heading">
                        <h3>Contact Information</h3>
                    </div>
                    <div class="contactarea__info__content">
                        <div class="contactarea__info__item">
                            <div class="contactarea__info__icon">
                                <i class="icofont-envelope"></i>
                            </div>
                            <div class="contactarea__info__text">
                                <h6>Email</h6>
                                <p>support@academicdigital.space</p>
                            </div>
                        </div>
                        
                        <div class="contactarea__info__item">
                            <div class="contactarea__info__icon">
                                <i class="icofont-globe"></i>
                            </div>
                            <div class="contactarea__info__text">
                                <h6>Website</h6>
                                <p><a href="http://academicdigital.space/" target="_blank">academicdigital.space</a></p>
                            </div>
                        </div>
                        
                        <div class="contactarea__info__item">
                            <div class="contactarea__info__icon">
                                <i class="icofont-clock-time"></i>
                            </div>
                            <div class="contactarea__info__text">
                                <h6>Business Hours</h6>
                                <p>Monday - Friday: 9:00 AM - 6:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
