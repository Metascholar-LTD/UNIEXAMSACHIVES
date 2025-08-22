@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')
<div class="breadcrumbarea">

    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="breadcrumb__content__wraper" data-aos="fade-up">
                    <div class="breadcrumb__title">
                        <h2 class="heading">All Documents</h2>
                    </div>
                    <div class="breadcrumb__inner">
                        <ul>
                            <li><a href="{{route('dashboard')}}">Home</a></li>
                            <li>All Documents</li>
                        </ul>
                    </div>
                </div>



            </div>
        </div>
    </div>

    {{-- <div class="shape__icon__2">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__1" src="img/herobanner/herobanner__1.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__2" src="img/herobanner/herobanner__2.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__3" src="img/herobanner/herobanner__3.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__4" src="img/herobanner/herobanner__5.png" alt="photo">
    </div> --}}

</div>
<div class="coursearea sp_top_100 sp_bottom_100">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="course__text__wraper" data-aos="fade-up">
                    <div class="course__text">
                        <p> All Documents Uploaded </p>
                    </div>
                    <div class="course__icon">
                        <ul class="nav property__team__tap" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#" class="single__tab__link active" data-bs-toggle="tab" data-bs-target="#projects__one"><i class="icofont-layout"></i>
                                    </a>
                            </li>
                            {{-- <li class="nav-item" role="presentation">
                                <a href="#" class="single__tab__link" data-bs-toggle="tab" data-bs-target="#projects__two"><i class="icofont-listine-dots"></i>
                                </a>
                            </li> --}}

                            {{-- <li class="short__by__new">
                                <select class="form-select" aria-label="Default select example">
                                        <option selected>Sort by New</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                      </select>
                            </li> --}}



                        </ul>
                    </div>
                </div>

            </div>
            <div class="col-xl-3 col-lg-3 col-md-4 col-12">
                <div class="course__sidebar__wraper" data-aos="fade-up">
                    <div class="course__heading">
                        <h5>Search here</h5>
                    </div>
                    <form action="{{ route('exam.search') }}" method="GET">
                        <div class="course__input">
                            <input type="text" name="query" placeholder="Search for exams paper">
                            <div class="search__button">
                                <button type="submit"><i class="icofont-search-1"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="course__sidebar__wraper" data-aos="fade-up">
                    <div class="categori__wraper">
                        <div class="course__heading">
                            <h5>Faculties/Departments</h5>
                        </div>
                        <div class="course__categories__list">
                            <ul>
                                @if (count($faculties) > 0)
                                    @foreach ($faculties as $faculty )
                                    <li>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox faculty-checkbox" value="{{$faculty}}">
                                            {{ $faculty }}
                                        </label>
                                    </li>
                                    @endforeach
                                @else
                                <li>No Faculty</li>
                                @endif

                            </ul>
                        </div>


                    </div>
                </div>
                <div class="course__sidebar__wraper" data-aos="fade-up">
                    <div class="course__heading">
                        <h5>Tag</h5>
                    </div>
                    <div class="course__tag__list">
                        <ul>
                            @if (count($tags) > 0)
                                @foreach ($tags as $tag)
                                <li>
                                    <label>
                                        <input type="checkbox" class="filter-checkbox tag-checkbox" value="{{ $tag }}">
                                        {{ $tag }}
                                    </label>
                                </li>
                                @endforeach
                            @else
                            <li>No tags</li>
                            @endif

                        </ul>
                    </div>

                </div>

                <div class="course__sidebar__wraper" data-aos="fade-up">
                    <div class="course__heading">
                        <h5>Semesters</h5>
                    </div>
                    <div class="course__skill__list">
                        <ul>
                            @if (count($semesters) > 0)
                                @foreach ($semesters as $semester)
                                    <li>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox semester-checkbox" value="{{ $semester }}">
                                            {{ $semester }}
                                        </label>
                                    </li>
                                @endforeach
                            @else
                                <li>No Semester</li>
                            @endif

                        </ul>
                    </div>

                </div>

                <div class="course__sidebar__wraper" data-aos="fade-up">
                    <div class="course__heading">
                        <h5>Years</h5>
                    </div>
                    <div class="course__skill__list">
                        <ul>
                            @if (count($years) > 0)
                                @foreach ($years as $year)
                                    <li>
                                        <label>
                                            <input type="checkbox" class="filter-checkbox year-checkbox" value="{{ $year }}">
                                            {{ $year }}
                                        </label>
                                    </li>
                                @endforeach
                            @else
                                <li>No Year</li>
                            @endif

                        </ul>
                    </div>

                </div>


            </div>

            <div class="col-xl-9 col-lg-9 col-md-8 col-12">

                <div class="tab-content tab__content__wrapper with__sidebar__content" id="myTabContent">


                    <div class="tab-pane fade  active show" id="projects__one" role="tabpanel" aria-labelledby="projects__one">

                        <div class="row" id="exam-list">
                            @if (count($exams) > 0)
                                @foreach ($exams as $result)
                                @foreach ($result as $exam)
                                    <div class="col-xl-4 col-lg-6 col-md-12 col-sm-6 col-12" data-aos="fade-up">
                                        @if ($exam instanceof \App\Models\Exam)
                                        <div class="gridarea__wraper gridarea__wraper__2">
                                            <div class="gridarea__img">
                                                <a href="{{ asset($exam->exam_document) }}" download>
                                                    @php
                                                        $extension = pathinfo($exam->exam_document, PATHINFO_EXTENSION);

                                                    @endphp
                                                    @if ($extension == 'pdf')
                                                        <img loading="lazy"  src="/img/pdf.jpg" alt="grid">
                                                    @else
                                                    <img loading="lazy"  src="/img/word.png" alt="grid">

                                                    @endif

                                                </a>
                                                <div class="gridarea__small__button">
                                                    <div class="grid__badge">{{$exam->course_code}}</div>
                                                </div>
                                                <div class="gridarea__small__icon">
                                                    {{-- <a href="#"><i class="icofont-heart-alt"></i></a> --}}
                                                </div>

                                            </div>
                                            <div class="gridarea__content">
                                                <div class="gridarea__list">
                                                    <ul>
                                                        <li>
                                                            <i class="icofont-book-alt"></i> {{$exam->exam_format}}
                                                        </li>
                                                        <li>
                                                            <i class="icofont-clock-time"></i> {{$exam->duration}}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="gridarea__heading">
                                                    <h3><a href="#">{{$exam->course_title}}</a></h3>
                                                </div>
                                                <div class="gridarea__price">
                                                    <span style="font-size: 14px"> <a href="{{ asset($exam->exam_document) }}" download><i class="fas fa-download"></i> Paper </a></span>
                                                    @if($exam->answer_key)
                                                        <span style="font-size: 14px"> <a href="{{ asset($exam->answer_key) }}" download><i class="fas fa-download"></i> Answer Key</a></span>
                                                    @endif

                                                </div>
                                                <div class="gridarea__bottom">

                                                    <a href="instructor-details.html">
                                                        <div class="gridarea__small__img">
                                                            <img loading="lazy"  src="/img/grid/grid_small_1.jpg" alt="grid">
                                                            <div class="gridarea__small__content">
                                                                <h6>{{$exam->instructor_name}}</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @else
                                        <div class="gridarea__wraper gridarea__wraper__2">
                                            <div class="gridarea__img">
                                                <a href="{{ Storage::url($exam->document_file) }}" download>
                                                    @php
                                                        $extension = pathinfo($exam->document_file, PATHINFO_EXTENSION);

                                                    @endphp
                                                    @if ($extension == 'pdf')
                                                        <img loading="lazy"  src="/img/pdf.jpg" alt="grid">
                                                    @else
                                                    <img loading="lazy"  src="/img/word.png" alt="grid">

                                                    @endif

                                                </a>
                                                <div class="gridarea__small__button">
                                                    <div class="grid__badge">File</div>
                                                </div>
                                                <div class="gridarea__small__icon">
                                                    {{-- <a href="#"><i class="icofont-heart-alt"></i></a> --}}
                                                </div>

                                            </div>
                                            <div class="gridarea__content">
                                                <div class="gridarea__list">
                                                    <ul>
                                                        <li>
                                                            <i class="icofont-book-alt"></i> {{$exam->file_format}}
                                                        </li>
                                                        <li>
                                                            <i class="icofont-clock-time"></i> {{$exam->year_deposit}}
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="gridarea__heading">
                                                    <h3><a href="#">{{$exam->file_title}}</a></h3>
                                                </div>
                                                <div class="gridarea__price">
                                                    <span style="font-size: 14px"> <a href="{{ Storage::url($exam->document_file) }}" download><i class="fas fa-download"></i> File </a></span>
                                                </div>
                                                <div class="gridarea__bottom">

                                                    <a href="instructor-details.html">
                                                        <div class="gridarea__small__img">
                                                            <img loading="lazy"  src="/img/grid/grid_small_1.jpg" alt="grid">
                                                            <div class="gridarea__small__content">
                                                                <h6>{{$exam->depositor_name}}</h6>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                @endforeach
                                @endforeach
                            @else
                                <h5 class="text-center">No Exams Uploaded Yet!</h5>
                            @endif
                        </div>

                    </div>


                    {{-- <div class="tab-pane fade" id="projects__two" role="tabpanel" aria-labelledby="projects__two">

                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_1.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge">Data & Tech</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Become a product Manager learn the
                                                    skills & job.
                                                </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                    <i class="icofont-arrow-right"></i>
                                                </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <img loading="lazy"  src="img/grid/grid_2.png" alt="grid">
                                <div class="gridarea__small__button">
                                    <div class="grid__badge blue__color">Mechanical</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Foundation course to under stand
                                                about softwere</a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_3.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge pink__color">Development</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Strategy law and with for organization
                                                Foundation
                                            </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_4.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge green__color">Ui & UX Design</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">The business Intelligence analyst with
                                                Course & 2024
                                            </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="gridarea__wraper gridarea__wraper__2 gridarea__course__list" data-aos="fade-up">
                            <div class="gridarea__img">
                                <a href="course-details.html"><img loading="lazy"  src="img/grid/grid_5.png" alt="grid"></a>
                                <div class="gridarea__small__button">
                                    <div class="grid__badge orange__color">Data & Tech</div>
                                </div>
                                <div class="gridarea__small__icon">
                                    <a href="#"><i class="icofont-heart-alt"></i></a>
                                </div>

                            </div>
                            <div class="gridarea__content">
                                <div class="gridarea__list">
                                    <ul>
                                        <li>
                                            <i class="icofont-book-alt"></i> 23 Lesson
                                        </li>
                                        <li>
                                            <i class="icofont-clock-time"></i> 1 hr 30 min
                                        </li>
                                    </ul>
                                </div>
                                <div class="gridarea__heading">
                                    <h3><a href="course-details.html">Become a product Manager learn the skills & job.
                                            </a></h3>
                                </div>
                                <div class="gridarea__price">
                                    $32.00 <del>/ $67.00</del>
                                    <span>Free.</span>

                                </div>
                                <div class="gridarea__bottom">
                                    <div class="gridarea__bottom__left">
                                        <a href="instructor-details.html">
                                            <div class="gridarea__small__img">
                                                <img loading="lazy"  src="img/grid/grid_small_1.jpg" alt="grid">
                                                <div class="gridarea__small__content">
                                                    <h6>Mirnsdo .H</h6>
                                                </div>
                                            </div>
                                        </a>

                                        <div class="gridarea__star">
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <i class="icofont-star"></i>
                                            <span>(44)</span>
                                        </div>
                                    </div>

                                    <div class="gridarea__details">
                                        <a href="course-details.html">Know Details
                                                <i class="icofont-arrow-right"></i>
                                            </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> --}}

                </div>

                <div class="main__pagination__wrapper" data-aos="fade-up">
                    {{-- {{$exams->links()}} --}}
                </div>

            </div>


        </div>
    </div>
</div>
@endsection

