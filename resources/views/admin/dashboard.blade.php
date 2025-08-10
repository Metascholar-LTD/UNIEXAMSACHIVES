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
                            <h4>Dashboard</h4>
                        </div>
                        @auth
                            @if(auth()->user()->is_admin)
                            <div class="row">
                                {{-- exams --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_total_papers}}</span>

                                                </div>
                                                <p>Total Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_approve_papers}}</span>

                                                </div>
                                                <p>Approved Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_pending_papers}}</span>

                                                </div>
                                                <p>Pending Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Files --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_total_files}}</span>

                                                </div>
                                                <p>Total Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_approve_files}}</span>

                                                </div>
                                                <p>Approved Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_pending_files}}</span>

                                                </div>
                                                <p>Pending Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                            @unless(auth()->user()->is_admin)
                            <div class="row">
                                {{-- Exams --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_papers}}</span>

                                                </div>
                                                <p>Total Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_approved_papers}}</span>

                                                </div>
                                                <p>Approved Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_pending_papers}}</span>

                                                </div>
                                                <p>Pending Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Files --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_files}}</span>

                                                </div>
                                                <p>Total Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_approved_files}}</span>

                                                </div>
                                                <p>Approved Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_pending_files}}</span>

                                                </div>
                                                <p>Pending Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Users --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__2.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_users}}</span>

                                                </div>
                                                <p>Total Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$dailyVisits}}</span>

                                                </div>
                                                <p>Daily Active Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$totalVisits}}</span>

                                                </div>
                                                <p>Total Active Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            @endunless

                        @endauth

                    </div>

                    @auth
                        @unless(auth()->user()->is_admin)

                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="dashboard__content__wraper admin__content__wrapper">

                                        <div class="dashboard__section__title">
                                            <h4>Recent Uploaded Exams Paper</h4>
                                            <a href="{{route('dashboard.all.upload.document')}}">See More...</a>
                                        </div>

                                        <div class="dashboard__recent__course">
                                            @if (count($recentlyUploadedExams) > 0)
                                                @foreach ($recentlyUploadedExams as $item )
                                                <div class="dashboard__recent__course__single">
                                                    <div class="dashboard__recent__course__img">
                                                        <a href="{{ Storage::url($item->exam_document) }}" download="">
                                                            @php
                                                            $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);

                                                            @endphp
                                                            @if ($extension == 'pdf')
                                                                <img loading="lazy"  src="/img/pdf.jpg" alt="grid">
                                                            @else
                                                            <img loading="lazy"  src="/img/word.png" alt="grid">

                                                            @endif
                                                        </a>

                                                    </div>
                                                    <div class="dashboard__recent__course__content">
                                                        <div class="dashboard__recent__course__heading">
                                                            <h3><a href="#"> {{$item->course_title}}</a></h3>
                                                        </div>
                                                        <div class="dashboard__recent__course__meta">
                                                            <ul>
                                                                <li>
                                                                    <i class="icofont-teacher"></i> <a
                                                                        href=".#">{{$item->instructor_name}}</a>
                                                                </li>
                                                                <li>
                                                                    <i class="icofont-book-alt"></i> {{$item->exam_format}}
                                                                </li>

                                                                <li>
                                                                    <i class="icofont-clock-time"></i> {{$item->duration}}
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                            <p>No Document Uploaded yet</p>
                                            @endif
                                        </div>
                                </div>
                            </div>
                        @endunless
                    @endauth
                </div>
            </div>


        </div>
    </div>

</div>
@endsection
