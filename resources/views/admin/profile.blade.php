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
                            <div class="col-lg-4 col-md-4">
                                <div class="dashboard__form">Registration Date</div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="dashboard__form">{{$data->created_at->format('d M Y')}}</div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="dashboard__form dashboard__form__margin">First Name</div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="dashboard__form dashboard__form__margin">{{$data->first_name}}</div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="dashboard__form dashboard__form__margin">Last Name</div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="dashboard__form dashboard__form__margin">{{$data->last_name}}</div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="dashboard__form dashboard__form__margin">Status</div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="dashboard__form dashboard__form__margin">{{$data->is_approve ? 'Approved':'Unapproved'}}</div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="dashboard__form dashboard__form__margin">Email</div>
                            </div>
                            <div class="col-lg-8 col-md-8">
                                <div class="dashboard__form dashboard__form__margin">{{$data->email}}</div>
                            </div>
                           
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
