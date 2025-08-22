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
                        <h2 class="heading">Exams Deposition Form</h2>
                        <p>Please fill out the form below to upload and archive your exam document.</p>
                    </div>
                    <div class="breadcrumb__inner">
                        <ul>
                            <li><a href="{{route('dashboard')}}">Home</a></li>
                            <li>Edit Exam Document</li>
                        </ul>
                    </div>
                </div>



            </div>
        </div>
    </div>

    {{-- <div class="shape__icon__2">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__1" src="../../../img/herobanner/herobanner__1.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__2" src="../../../img/herobanner/herobanner__2.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__3" src="../img/herobanner/herobanner__3.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__4" src="../img/herobanner/herobanner__5.png" alt="photo">
    </div> --}}

</div>
<div class="create__course sp_100">
    <div class="container">
       <div class="row">
           <div class="col-xl-8 col-lg-8 col-md-8 col-12">
            <form action="{{ route('exams.update', $exam->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="create__course__accordion__wraper">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Basic Information
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="become__instructor__form">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="Instructor Name">Name of Faculty Member</label>
                                                        <input type="text" name="instructor_name" value="{{ old('instructor_name', $exam->instructor_name) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="Staff ID">Staff ID</label>
                                                        <input type="text" name="student_id" value="{{ old('student_id', $exam->student_id) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="dashboard__selector">
                                                    <label for="department">Department</label>

                                                    <select class="form-select" name="faculty" required>
                                                        @foreach ($departments as $department)
                                                            <option value="{{ $department->name }}" {{ $exam->faculty == $department->name ? 'selected' : '' }}>{{ $department->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="Email">Email</label>
                                                        <input type="text" name="email" value="{{ old('email', $exam->email) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="Phone Number">Phone Number</label>
                                                        <input type="number" name="phone_number" value="{{ old('phone_number', $exam->phone_number) }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                     Course Details
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse show" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="become__instructor__form">
                                        <div class="row">
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="course_title">Course Title</label>
                                                        <input type="text" name="course_title" value="{{ $exam->course_title ?? '' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="course_code">Course Code</label>
                                                        <input type="text" name="course_code" value="{{ $exam->course_code ?? '' }}" required>
                                                    </div>
                                                </div>
                                            </div>
                        
                        
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="dashboard__select__heading">
                                                    <span>Semester/Term</span>
                                                </div>
                                                <div class="dashboard__selector">
                                                    <select class="form-select" name="semester" required>
                                                        <option value="First Semester" {{ ($exam->semester ?? '') == 'First Semester' ? 'selected' : '' }}>First Semester</option>
                                                        <option value="Second Semester" {{ ($exam->semester ?? '') == 'Second Semester' ? 'selected' : '' }}>Second Semester</option>
                                                    </select>
                                                </div>
                                            </div>
                        
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="dashboard__select__heading">
                                                    <span>Academic Year</span>
                                                </div>
                                                <div class="dashboard__selector">
                                                    <select class="form-select" name="academic_year" required>
                                                        @if (count($years) > 0)
                                                            @foreach ($years as $year)
                                                                <option value="{{$year->year}}" {{ ($exam->academic_year ?? '') == $year->year ? 'selected' : '' }}>{{$year->year}}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="No Academic Year Added" disabled>No Academic Year Added</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                                    Exam Information
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="become__instructor__form">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="dashboard__selector">
                                                    <select class="form-select" name="exams_type" required>
                                                        <option value="Midterm" {{ $exam->exams_type == 'Midterm' ? 'selected' : '' }}>Midterm</option>
                                                        <option value="Final Exams" {{ $exam->exams_type == 'Final Exams' ? 'selected' : '' }}>Final</option>
                                                        <option value="Quiz" {{ $exam->exams_type == 'Quiz' ? 'selected' : '' }}>Quiz</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 mt-2">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="Exam Date">Exam Date</label>
                                                        <input type="date" name="exam_date" value="{{ $exam->exam_date->format('Y-m-d') }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 mt-2">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="Duration">Duration of Exam</label>
                                                        <input type="text" name="duration" value="{{ $exam->duration }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 mt-2">
                                                <div class="dashboard__selector">
                                                    <select class="form-select" name="exam_format" required>
                                                        <option value="In-Person Written" {{ $exam->exam_format == 'In-Person Written' ? 'selected' : '' }}>In-Person Written</option>
                                                        <option value="Online" {{ $exam->exam_format == 'Online' ? 'selected' : '' }}>Online</option>
                                                        <option value="Take-Home" {{ $exam->exam_format == 'Take-Home' ? 'selected' : '' }}>Take-Home</option>
                                                        <option value="Oral" {{ $exam->exam_format == 'Oral' ? 'selected' : '' }}>Oral</option>
                                                        <option value="Practical" {{ $exam->exam_format == 'Practical' ? 'selected' : '' }}>Practical</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                                     Exam File Upload
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="create__course__button">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="exam_document">Exam Document (Format: .pdf, .docx)</label>
                                                        <input type="file" name="exam_document" accept=".pdf,.docx">
                                                        @if ($exam->exam_document)
                                                            <p class="text-success">Current File: <a class="text-success" href="{{ asset($exam->exam_document) }}" target="_blank">View Document</a></p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                        
                                            <div class="col-xl-12">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="answer_key">Answer Key (Format: .pdf, .docx)</label>
                                                        <input type="file" name="answer_key" accept=".pdf,.docx">
                                                        @if ($exam->answer_key)
                                                            <p class="text-success">Current File: <a class="text-success" href="{{ Storage::url($exam->answer_key) }}}" target="_blank">View Answer Key</a></p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                        
                                         
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Update Exam</button>
                </div>
            </form>
            
            </div>


           <div class="col-xl-4 col-lg-4 col-md-4 col-12">
               <div class="create__course__wraper">
                   <div class="create__course__title">
                       <h4>Upload Tips</h4>
                   </div>
                   <div class="create__course__list">
                       <ul>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               1. Check File Formats: Ensure your files are in the accepted formats (e.g., PDF, DOCX, JPEG) as specified by the platform or recipient.
                           </li>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               2. Compress Large Files: Use file compression tools to reduce the size of large files for faster upload times and to meet size limits.
                           </li>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               3. Use Descriptive Filenames: Name your files clearly and descriptively, including relevant details (Physics_Assignment_1_JaneDoe.pdf) to make them easily identifiable.
                           </li>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               4. Secure Sensitive Information: If uploading sensitive or personal information, ensure the platform is secure and consider encrypting files.
                           </li>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               5. Check Internet Connection: A stable and fast internet connection is crucial for successful uploads, especially for larger files.
                           </li>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               6. Use Batch Uploads: When possible, upload multiple files at once or use a folder upload feature to save time.
                           </li>
                           <li>
                               {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                               7. Follow Uploading Instructions: Adhere to any specific instructions given (e.g., file naming conventions, order of upload) to ensure a smooth process.
                           </li>
                           <li>
                            {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg> --}}
                            8. Preview Before Submitting: If the platform allows, preview your upload to catch any errors or formatting issues before final submission.
                           </li>
                           <li>
                            9. Keep Backup Copies: Always keep a backup copy of your files in case of upload failures or data loss.
                           </li>
                           <li>
                            10. Confirm Upload Success: Wait for confirmation that your upload was successful, which may come in the form of a confirmation page, email, or notification.
                           </li>

                       </ul>
                   </div>
               </div>
           </div>
       </div>
    </div>
   </div>
@endsection
