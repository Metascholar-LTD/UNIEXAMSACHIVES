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
                            <h4>System Licences</h4>
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                    <table class="table example">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Licence</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (count($licenses) > 0)
                                                @foreach ($licenses as $index => $license)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td><strong>{{ $license->name }}</strong></td>
                                                    <td>{{ $license->description }}</td>
                                                    <td>
                                                        @if($license->is_active)
                                                            <span class="badge badge-success" style="background-color: #10b981; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600;">Active</span>
                                                        @else
                                                            <span class="badge badge-danger" style="background-color: #ef4444; color: white; padding: 6px 12px; border-radius: 6px; font-weight: 600;">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="4" class="text-center">No licenses found.</td>
                                                </tr>
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
