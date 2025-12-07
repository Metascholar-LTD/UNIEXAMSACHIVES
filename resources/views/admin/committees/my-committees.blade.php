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
                            <h4>My Committees & Boards</h4>
                        </div>

                        @if (count($userCommittees) > 0)
                            <div class="row mt-4">
                                @foreach ($userCommittees as $committee)
                                <div class="col-xl-4 col-lg-6 col-md-6 col-12 mb-4">
                                    <div class="card h-100" style="border: 1px solid #e9ecef; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); transition: transform 0.2s;">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="card-title mb-0">{{ $committee->name }}</h5>
                                                <span class="badge bg-{{ $committee->status === 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($committee->status) }}
                                                </span>
                                            </div>
                                            
                                            @if($committee->description)
                                            <p class="card-text text-muted" style="font-size: 0.9rem; min-height: 60px;">
                                                {{ Str::limit($committee->description, 150) }}
                                            </p>
                                            @else
                                            <p class="card-text text-muted" style="font-size: 0.9rem; min-height: 60px;">
                                                <em>No description provided</em>
                                            </p>
                                            @endif
                                            
                                            <hr>
                                            
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-muted">
                                                    <i class="fas fa-users"></i> {{ $committee->users->count() }} member(s)
                                                </small>
                                                @if($committee->status === 'active')
                                                    <span class="badge bg-success">
                                                        <i class="fas fa-check-circle"></i> Active
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        <i class="fas fa-pause-circle"></i> Inactive
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <div class="row mt-4">
                                <div class="col-xl-12">
                                    <div class="alert alert-info text-center" style="padding: 3rem;">
                                        <i class="icofont-users" style="font-size: 3rem; color: #6c757d; margin-bottom: 1rem;"></i>
                                        <h5>No Committees or Boards</h5>
                                        <p class="mb-0">You are not currently assigned to any committees or boards.</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

