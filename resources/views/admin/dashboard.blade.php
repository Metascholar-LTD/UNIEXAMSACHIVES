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

                                        <div class="dashboard__section__title clean-section-title">
                                            <div class="title-content">
                                                <h4><i class="icofont-document"></i> Recent Uploaded Exams</h4>
                                            </div>
                                            <a href="{{route('dashboard.all.upload.document')}}" class="clean-see-more-btn">
                                                View All
                                            </a>
                                        </div>

                                        @if (count($recentlyUploadedExams) > 0)
                                            <div class="clean-exams-list">
                                                @foreach ($recentlyUploadedExams as $item )
                                                <div class="clean-exam-item" data-exam-id="{{ $item->id }}">
                                                    <div class="exam-icon">
                                                        @php
                                                            $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);
                                                        @endphp
                                                        @if ($extension == 'pdf')
                                                            <i class="icofont-file-pdf"></i>
                                                        @else
                                                            <i class="icofont-file-word"></i>
                                                        @endif
                                                    </div>
                                                    
                                                    <div class="exam-content">
                                                        <div class="exam-title">
                                                            <h5>{{ $item->course_title }}</h5>
                                                            <span class="exam-code">{{ $item->course_code }}</span>
                                                        </div>
                                                        
                                                        <div class="exam-info">
                                                            <span><i class="icofont-teacher"></i> {{ $item->instructor_name }}</span>
                                                            <span><i class="icofont-book-alt"></i> {{ $item->exam_format }}</span>
                                                            <span><i class="icofont-clock-time"></i> {{ $item->duration }}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="exam-actions">
                                                        <button class="clean-btn download-btn" onclick="downloadExam('{{ Storage::url($item->exam_document) }}', '{{ $item->course_title }}')" title="Download">
                                                            <i class="icofont-download"></i>
                                                        </button>
                                                        @if($item->answer_key)
                                                            <button class="clean-btn key-btn" onclick="downloadAnswerKey('{{ Storage::url($item->answer_key) }}', '{{ $item->course_title }} - Answer Key')" title="Answer Key">
                                                                <i class="icofont-key"></i>
                                                            </button>
                                                        @endif
                                                        <div class="status-indicator">
                                                            @if($item->is_approve)
                                                                <i class="icofont-check-circled" title="Approved"></i>
                                                            @else
                                                                <i class="icofont-clock-time" title="Pending"></i>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="clean-empty-state">
                                                <i class="icofont-document"></i>
                                                <p>No exams uploaded yet</p>
                                                <a href="{{route('dashboard.create')}}" class="clean-upload-btn">
                                                    Upload First Exam
                                                </a>
                                            </div>
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

<script>
// Simple download functions
function downloadExam(url, filename) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function downloadAnswerKey(url, filename) {
    const link = document.createElement('a');
    link.href = url;
    link.download = filename;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}
</script>

@endsection
