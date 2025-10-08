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
                        <h2 class="heading">Edit File Deposition</h2>
                        <p>Update the details of your archived exam document.</p>
                    </div>
                    <div class="breadcrumb__inner">
                        <ul>
                            <li><a href="{{route('dashboard')}}">Home</a></li>
                            <li>Edit File</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="create__course sp_100">
    <div class="container">
       <div class="row">
           <div class="col-xl-8 col-lg-8 col-md-8 col-12">
                <form action="{{route('files.update', $file->id)}}" method="post" enctype="multipart/form-data">
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
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Instructor Name"> Depositor's Name</label>
                                                    <input type="text" placeholder="Enter Depositor's Name" name="depositor_name" value="{{ old('depositor_name', $file->depositor_name) }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Course Code">Email</label>
                                                    <input type="text" placeholder="Enter Email" name="email" value="{{ old('email', $file->email) }}" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="Course Title">Phone Number</label>
                                                    <input type="number" placeholder="Enter Phone Number" name="phone_number" value="{{ old('phone_number', $file->phone_number) }}" required>
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
                                File Details
                            </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="create__course__button">
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">File Title</label>
                                                    <input type="text" placeholder="Enter File Title" name="file_title" value="{{ old('file_title', $file->file_title) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">File Format</label>
                                                    <select class="form-select" aria-label="Default select example" name="file_format" required>
                                                        <option value="Pdf" {{ old('file_format', $file->file_format) == 'Pdf' ? 'selected' : '' }}>Pdf</option>
                                                        <option value="Word" {{ old('file_format', $file->file_format) == 'Word' ? 'selected' : '' }}>Word</option>
                                                        <option value="Excel" {{ old('file_format', $file->file_format) == 'Excel' ? 'selected' : '' }}>Excel</option>
                                                        <option value="Csv" {{ old('file_format', $file->file_format) == 'Csv' ? 'selected' : '' }}>Csv</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">Date and Year Created</label>
                                                    <input type="date" placeholder="Enter Date and Year Deposited" name="year_created" value="{{ old('year_created', $file->year_created) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">Date and Year Deposited</label>
                                                    <input type="date" placeholder="Enter Date and Year Deposited" name="year_deposit" value="{{ old('year_deposit', $file->year_deposit) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="dashboard__form__wraper">
                                                <div class="dashboard__form__input">
                                                    <label for="#">Current File: 
                                                        <a href="{{ asset($file->document_file) }}" target="_blank" class="text-primary">
                                                            <i class="fas fa-eye"></i> View
                                                        </a>
                                                    </label>
                                                    <input type="file" placeholder="Choose a file to upload" name="document_file">
                                                    <small class="text-muted">Leave blank to keep existing file</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="true" aria-controls="collapseFour">
                                Unit
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="dashboard__form__wraper">
                                            <div class="dashboard__form__input">
                                                <label for="#">Select the unit where the Deposited File Belong</label>
                                                <select class="form-select" aria-label="Default select example" name="unit" required>
                                                    @foreach([
                                                        'Registry',
                                                        'School of Nursing and Midwifery',
                                                        'Assurance Directorate',
                                                        'Directorate',
                                                        'Finance Directorate',
                                                        'Works and Physical Development Office',
                                                        'Audit',
                                                        'Guidance and Counselling Unit',
                                                        'The University Library',
                                                        'Human Resource Unit',
                                                        'Hostels',
                                                        'Faculty of Economics and Business Administration',
                                                        'Faculty of Education',
                                                        'School of Public Health and Allied Science',
                                                        'Faculty of Religious and Social Sciences',
                                                        'Faculty of Computing, Engineering and Mathematical Sciences'
                                                    ] as $unitOption)
                                                        <option value="{{ $unitOption }}" {{ old('unit', $file->unit) == $unitOption ? 'selected' : '' }}>
                                                            {{ $unitOption }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <input type="checkbox" required checked> I confirm that I have the necessary permissions to update this file in the university's archives.
                        </div>

                        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                            <div class="create__course__bottom__button">
                                <button class="btn btn-primary" type="submit">Update File</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

           <div class="col-xl-4 col-lg-4 col-md-4 col-12">
               <div class="create__course__wraper">
                   <div class="create__course__title">
                       <h4>Edit Tips</h4>
                   </div>
                   <div class="create__course__list">
                       <ul>
                           <li>1. Verify all information before submitting changes.</li>
                           <li>2. Only upload new files if necessary to replace the existing one.</li>
                           <li>3. Keep file naming consistent with university standards.</li>
                           <li>4. Double-check dates for accuracy.</li>
                           <li>5. Contact the archives department if you need to make special changes.</li>
                       </ul>
                   </div>
               </div>
           </div>
       </div>
    </div>
</div>
@endsection