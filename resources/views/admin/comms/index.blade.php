@extends('layout.app')

@section('content')
<section class="dashboard__area pt-120 pb-120">
  <div class="container">
    <div class="row">
      @include('components.sidebar')
      <div class="col-xl-9 col-lg-9 col-md-12">
        <div class="dashboard__content__wraper">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="dashboard__section__title">
              <h4>Advanced Communication - Campaigns</h4>
            </div>
            <a class="default__button" href="{{ route('comms.create') }}">Compose</a>
          </div>

          <div class="table-responsive">
            <table class="table table-striped example">
              <thead>
                <tr>
                  <th>Subject</th>
                  <th>Status</th>
                  <th>Recipients</th>
                  <th>Created</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @foreach($communications as $c)
                <tr>
                  <td>{{ $c->subject }}</td>
                  <td><span class="badge bg-secondary">{{ $c->status }}</span></td>
                  <td>{{ $c->recipients()->count() }}</td>
                  <td>{{ $c->created_at->format('Y-m-d H:i') }}</td>
                  <td><a href="{{ route('comms.show', $c) }}" class="btn btn-sm btn-outline-primary">View</a></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <div class="mt-3">
            {{ $communications->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


