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
                            <li>Create Exam Document</li>
                        </ul>
                    </div>
                </div>



            </div>
        </div>
    </div>

    {{-- <div class="shape__icon__2">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__1" src="../img/herobanner/herobanner__1.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__2" src="../img/herobanner/herobanner__2.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__3" src="../img/herobanner/herobanner__3.png" alt="photo">
        <img loading="lazy"  class=" shape__icon__img shape__icon__img__4" src="../img/herobanner/herobanner__5.png" alt="photo">
    </div> --}}

</div>
<div class="create__course sp_100">
    <div class="container">
       <div class="row">
           <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                <form action="{{route('dashboard.exam.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
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
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Instructor Name">Name of Faculty Member</label>
                                                    <input type="text" placeholder="Enter Instructor Name" name="instructor_name" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Course Code">Staff ID:</label>
                                                    <input type="text" placeholder="Enter Staff ID" name="student_id" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <div class="dashboard__select__heading">
                                                <span style="font-weight: 900; color:#000000">Department/Faculty:</span>
                                            </div>
                                            <div class="dashboard__selector">
                                            <select class="form-select" aria-label="Default select example" name="faculty" required>
                                                @if (count($departments) > 0)
                                                    @foreach ($departments as $department)
                                                        <option value="{{$department->name}}">{{$department->name}}</option>
                                                    @endforeach
                                                @else
                                                    <option value="No Department Added" disabled>No Department Added</option>
                                                @endif


                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Course Code">Email:</label>
                                                    <input type="text" placeholder="Enter Email" name="email" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Course Title">Phone Number</label>
                                                    <input type="number" placeholder="Enter Phone Number" name="phone_number" required>
                                                </div>
                                                {{-- <small class="create__course__small">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg> The Course Price Includes Your Author Fee.</small> --}}
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
                                                    <label for="Course Title">  Course Title</label>
                                                    <input type="text" placeholder="Enter Course Title" name="course_title" required>
                                                </div>
                                                {{-- <small class="create__course__small">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg> The Course Price Includes Your Author Fee.</small> --}}
                                            </div>
                                        </div>

                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Course Code">Course Code:</label>
                                                    <input type="text" placeholder="Enter Course Code" name="course_code" required>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- <div class="row"> --}}

                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="dashboard__select__heading">
                                                    <span>Semester/Term</span>
                                                </div>
                                                <div class="dashboard__selector">
                                                <select class="form-select" aria-label="Default select example" name="semester" required>
                                                    <option value="First Semester">First Semester</option>
                                                    <option value="Second Semester">Second Semester</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                                <div class="dashboard__select__heading">
                                                    <span>Academic Year</span>
                                                </div>
                                                <div class="dashboard__selector">
                                                <select class="form-select" aria-label="Default select example" name="academic_year" required>
                                                    @if (count($years) > 0)
                                                        @foreach ($years as $year)
                                                            <option value="{{$year->year}}">{{$year->year}}</option>
                                                        @endforeach
                                                    @else
                                                        <option value="No Academic Year Added" disabled>No Academic Year Added</option>
                                                    @endif


                                                </select>
                                                </div>
                                            </div>
                                        {{-- </div> --}}



                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Exam Information
                            </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="become__instructor__form">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="dashboard__select__heading">
                                                <span>Type Exams</span>
                                            </div>
                                            <div class="dashboard__selector">
                                            <select class="form-select" aria-label="Default select example" name="exams_type" required>
                                                <option value="Midterm">Midterm</option>
                                                <option value="Final Exams">Final</option>
                                                <option value="Quiz">Quiz</option>
                                            </select>
                                            </div>
                                        </div>

                                        <div class="col-xl-12 mt-2">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">Exam Date</label>
                                                    <input type="date" placeholder="pick date" name="exam_date" required>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="col-xl-12 mt-2">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="#">Duration of Exam</label>
                                                        <input type="text" placeholder="Enter Duration" name="duration" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-12 mt-2">
                                                <div class="dashboard__form__wraper">
                                                    <div class="dashboard__form__input">
                                                        <label for="#">Format of Exam</label>
                                                        <select class="form-select" aria-label="Default select example" name="exam_format" required>
                                                            <option value="In-Person Written">In-Person Written</option>
                                                            <option value="Online">Online</option>
                                                            <option value="Take-Home">Take-Home</option>
                                                            <option value="Oral">Oral</option>
                                                            <option value="Practical">Practical</option>
                                                        </select>
                                                        </div>
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
                                File Upload
                            </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="create__course__button">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">Exam Document(format: .pdf, .docx)</label>
                                                    <input type="file" placeholder="Select Exam Document" name="exam_document" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">Answer Key(format: .pdf, .docx)</label>
                                                    <input type="file" placeholder="Select Answer Key" name="answer_key">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            {{-- <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                Additional Information
                                </button>
                            </h2> --}}
                            {{-- <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="dashboard__form__wraper">
                                            <div class="dashboard__form__input">
                                                <label for="#">Tag/Keyword</label>
                                                <input type="text" placeholder="Enter Tag/Keywords" name="tags" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                </div>
                            </div> --}}
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <input type="checkbox" required> I, the undersigned, declare that the information provided above is accurate to the best of my knowledge and that the exam questions submitted are in accordance with the university's academic standards and policies.
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="create__course__bottom__button">
                            <button class="btn btn-primary" type="submit">Deposit Document</button>
                        </div>
                        </div>
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
