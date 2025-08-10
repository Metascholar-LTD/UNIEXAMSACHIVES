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
                            <h4>Pending Files </h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table example">
                                        <thead>
                                            <tr>
                                                <th>SN</th>
                                                <th>Depositor's Name</th>
                                                <th>File Title</th>
                                                <th>Document ID</th>
                                                <th>Date</th>
                                                {{-- <th>Email</th>
                                                <th>Phone Number</th>
                                                <th>File Format</th>
                                                <th>File Size</th>
                                                <th>Download</th>
                                                
                                                <th>Date and Year Deposited</th>
                                                <th>Unit</th> --}}
                                                <th>Status</th>
                                                <th>File</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($files) > 0)
                                                @foreach ($files as $file)
                                                    <tr>
                                                        <td>{{$file->id}}</td>
                                                        <td>{{$file->depositor_name}}</td>
                                                        <td>{{$file->file_title}}</td>
                                                        <td>{{$file->document_id}}</td>
                                                        <td>{{$file->year_created}}</td>
                                                        {{-- <td>{{$file->email}}</td>
                                                        <td>{{$file->phone_number}}</td>
                                                        <td>{{ pathinfo($file->document_file, PATHINFO_EXTENSION) }}</td>
                                                        <td>{{ round(filesize(public_path(Storage::url($file->document_file))) / 1024, 2) }} KB</td>
                                                        <td></td>
                                                        
                                                        <td>{{$file->year_deposit}}</td>
                                                        <td>{{$file->unit}}</td> --}}
                                                        <td>
                                                            @if ($file->is_approve)
                                                                <span class="dashboard__td text-success">Approved</span>
                                                            @else
                                                                <span class="dashboard__td dashboard__td__2 text-danger">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(pathinfo($file->document_file, PATHINFO_EXTENSION) === 'pdf')
                                                                <a href="{{ Storage::url($file->document_file) }}" target="_blank">
                                                                    <i class="fas fa-eye"></i> 
                                                                </a>
                                                            @endif
                                                            <a href="{{ Storage::url($file->document_file) }}" download><i class="fas fa-download"></i> </a>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <a href="{{ route('files.edit', $file->id) }}" class="btn btn-sm btn-outline-warning me-2" title="Edit">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                                <form action="{{ route('file.destroy', $file->id) }}" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                   

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
