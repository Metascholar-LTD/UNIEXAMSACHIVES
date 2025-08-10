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
                            <h4>Departments</h4>
                            <a href="#" id="triggerDepartmentModal" class="btn btn-primary">Create Department/Faculty</a>

                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table example">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Name</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($departments) > 0)
                                            @foreach ($departments as $department)
                                            <tr>
                                                <td>{{ $department->id }}</td>
                                                <td>{{ $department->name }}</td>
                                                <td>
                                                    <a href="{{ route('departments.edit', $department->id) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                                                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display:inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
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
