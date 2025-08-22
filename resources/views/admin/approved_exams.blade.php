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
                            <h4>Approved Exams </h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table example">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Title</th>
                                                <th>Crse. ID</th>
                                                <th>Doc ID</th>
                                                {{-- <th>Date & Time</th>
                                                <th>Name of Faculty Member</th>
                                                <th>Student ID</th>
                                                <th>Faculty</th>
                                                <th>File Format</th>
                                                <th>File Size</th> --}}
                                                {{-- <th>Download</th> --}}
                                                <th>Semester</th>
                                                {{-- <th>Aca Yr</th> --}}
                                                <th>ExamType</th>
                                                {{-- <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>Duration of Exam</th>
                                                <th>Format of Exam</th> --}}
                                                <th>Status</th>
                                                <th>Question</th>
                                                <th>Answer</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($exams) > 0)
                                                @foreach ($exams as $exam)
                                                    <tr>
                                                        <td>{{$exam->id}}</td>
                                                        <td>{{$exam->course_title}}</td>
                                                        <td>{{$exam->course_code}}</td>
                                                        <td>{{$exam->document_id}}</td>
                                                        {{-- <td>{{$exam->exam_date->format('d M Y')}}</td>
                                                        <td>{{$exam->instructor_name}}</td>
                                                        <td>{{$exam->student_id}}</td>
                                                        <td>{{$exam->faculty}}</td>
                                                        <td>{{ pathinfo($exam->exam_document, PATHINFO_EXTENSION) }}</td>
                                                        <td>{{ round(filesize(public_path(Storage::url($exam->exam_document))) / 1024, 2) }} KB</td> --}}
                                                        <td>{{$exam->semester}}</td>
                                                        {{-- <td>{{$exam->academic_year}}</td> --}}
                                                        <td>{{$exam->exams_type}}</td>
                                                        {{-- <td>{{$exam->email}}</td>
                                                        <td>{{$exam->phone_number}}</td>
                                                        <td>{{$exam->duration}}</td>
                                                        <td>{{$exam->exam_format}}</td> --}}
                                                        <td>
                                                            @if ($exam->is_approve)
                                                                <span class="dashboard__td text-success">Approved</span>
                                                            @else
                                                                <span class="dashboard__td dashboard__td__2 text-danger">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(pathinfo($exam->exam_document, PATHINFO_EXTENSION) === 'pdf')
                                                                <a href="{{ asset($exam->exam_document) }}" target="_blank">
                                                                    <i class="fas fa-eye"></i> 
                                                                </a>
                                                            @endif
                                                            <a href="{{ asset($exam->exam_document) }}" download><i class="fas fa-download"></i></a>
                                                        </td>
                                                        <td>
                                                            @if($exam->answer_key && pathinfo($exam->answer_key, PATHINFO_EXTENSION) === 'pdf')
                                                                <a href="{{ asset($exam->answer_key) }}" target="_blank">
                                                                    <i class="fas fa-eye"></i> 
                                                                </a>
                                                            @endif
                                                            @if($exam->answer_key)
                                                                <a href="{{ asset($exam->answer_key) }}" download><i class="fas fa-download"></i> </a>
                                                            @endif

                                                        </td>
                                                        <td>
                                                            {{$exam->created_at->format('d M Y')}}
                                                        </td>

                                                        {{-- <td>
                                                            <div class="d-flex">
                                                                @if (!$exam->is_approve)
                                                                    <form action="{{ route('exams.approve', $exam->id) }}" method="post">
                                                                        @csrf
                                                                        <button type="submit" class="btn btn-success btn-sm me-1">Approve</button>
                                                                    </form>
                                                                @endif

                                                                <form action="{{ route('exams.destroy', $exam->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                                </form>
                                                            </div>
                                                        </td> --}}
                                                    </tr>
                                                @endforeach
                                
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
