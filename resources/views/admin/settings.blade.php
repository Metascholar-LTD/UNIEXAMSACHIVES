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
                            <h4>My Profile</h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12 aos-init aos-animate" data-aos="fade-up">
                                <ul class="nav  about__button__wrap dashboard__button__wrap" id="myTab"
                                    role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="single__tab__link active" data-bs-toggle="tab"
                                            data-bs-target="#projects__one" type="button" aria-selected="true"
                                            role="tab">Profile</button>
                                    </li>
                                    {{-- <li class="nav-item" role="presentation">
                                        <button class="single__tab__link" data-bs-toggle="tab"
                                            data-bs-target="#projects__two" type="button" aria-selected="false"
                                            role="tab" tabindex="-1">Password</button>
                                    </li> --}}


                                </ul>
                            </div>


                            <div class="tab-content tab__content__wrapper aos-init aos-animate"
                                id="myTabContent" data-aos="fade-up">

                                <div class="tab-pane fade active show" id="projects__one" role="tabpanel"
                                    aria-labelledby="projects__one">
                                    <div class="row">
                                        <div class="col-xl-12">


                                            <form action="{{route('dashboard.user.info')}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label >First Name</label>
                                                                <input type="text" name="first_name" placeholder="first name" value="{{$data->first_name}}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label >Last Name</label>
                                                                <input type="text" name="last_name" placeholder="Last name" value="{{$data->last_name}}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label >Email</label>
                                                                <input type="email" name="email" placeholder="email" value="{{$data->email}}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="dashboard__form__wraper">
                                                            <div class="dashboard__form__input">
                                                                <label>Profile Picture</label>
                                                                
                                                                <!-- Current Profile Picture Display -->
                                                                @if($data->profile_picture)
                                                                    <div class="current-profile-pic mb-3">
                                                                        <img src="{{ asset('profile_pictures/' . $data->profile_picture) }}" 
                                                                             alt="Current Profile Picture" 
                                                                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #e6e0ff;">
                                                                        <p class="text-muted mt-2">Current Profile Picture</p>
                                                                    </div>
                                                                @endif
                                                                
                                                                <input type="file" name="profile_picture" 
                                                                       accept="image/jpeg,image/png,image/jpg,image/gif" 
                                                                       class="form-control" 
                                                                       onchange="previewImage(this)">
                                                                
                                                                <!-- Image Preview -->
                                                                <div id="imagePreview" class="mt-3" style="display: none;">
                                                                    <img id="previewImg" src="" alt="Preview" 
                                                                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; border: 3px solid #e6e0ff;">
                                                                    <p class="text-muted mt-2">New Profile Picture Preview</p>
                                                                </div>
                                                                
                                                                <small class="form-text text-muted">
                                                                    Supported formats: JPEG, PNG, JPG, GIF. Max size: 5MB
                                                                </small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="dashboard__form__button">
                                                            <button type="submit" class="default__button" >Update Info</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                </div>

                                {{-- <div class="tab-pane fade" id="projects__two" role="tabpanel"
                                    aria-labelledby="projects__two">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >Current Password</label>
                                                    <input type="text" placeholder="Current password">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >New Password</label>
                                                    <input type="text" placeholder="New Password">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >Re-Type New Password</label>
                                                    <input type="text" placeholder="Re-Type New Password">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__button">
                                                <a class="default__button" href="#">Update Password</a>
                                            </div>
                                        </div>

                                    </div>

                                </div> --}}

                                {{-- <div class="tab-pane fade" id="projects__three" role="tabpanel"
                                    aria-labelledby="projects__three">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-facebook">
                                                            <path
                                                                d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z">
                                                            </path>
                                                        </svg>
                                                        Facebook</label>
                                                    <input type="text" placeholder="https://facebook.com/">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-twitter">
                                                            <path
                                                                d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                                            </path>
                                                        </svg>
                                                        Twitter</label>
                                                    <input type="text" placeholder="https://twitter.com/">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-linkedin">
                                                            <path
                                                                d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z">
                                                            </path>
                                                            <rect x="2" y="9" width="4" height="12"></rect>
                                                            <circle cx="4" cy="4" r="2"></circle>
                                                        </svg>
                                                        Linkedin</label>
                                                    <input type="text" placeholder="https://linkedin.com/">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-layout">
                                                            <rect x="3" y="3" width="18" height="18" rx="2"
                                                                ry="2"></rect>
                                                            <line x1="3" y1="9" x2="21" y2="9"></line>
                                                            <line x1="9" y1="21" x2="9" y2="9"></line>
                                                        </svg>
                                                        Website</label>
                                                    <input type="text" placeholder="https://website.com/">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label >

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-github">
                                                            <path
                                                                d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22">
                                                            </path>
                                                        </svg>
                                                        Github</label>
                                                    <input type="text" placeholder="https://github.com/">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__button">
                                                <a class="default__button" href="#">Update Password</a>
                                            </div>
                                        </div>

                                    </div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.current-profile-pic {
    text-align: center;
}

.current-profile-pic img {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.current-profile-pic img:hover {
    transform: scale(1.05);
}

#imagePreview {
    text-align: center;
}

#imagePreview img {
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    border: 3px solid #28a745;
}

.dashboard__form__input input[type="file"] {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f8f9fa;
}

.dashboard__form__input input[type="file"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
</style>

<script>
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Form validation
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form[action*="dashboard.user.info"]');
    const fileInput = document.querySelector('input[name="profile_picture"]');
    
    form.addEventListener('submit', function(e) {
        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const maxSize = 5 * 1024 * 1024; // 5MB
            
            if (file.size > maxSize) {
                e.preventDefault();
                alert('Profile picture size must be less than 5MB');
                return false;
            }
            
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                e.preventDefault();
                alert('Please select a valid image file (JPEG, PNG, JPG, or GIF)');
                return false;
            }
        }
    });
});
</script>

@endsection
