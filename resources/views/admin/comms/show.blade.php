@extends('layout.app')

@section('content')
<section class="dashboard__area pt-120 pb-120">
  <div class="container">
    <div class="row">
      @include('components.sidebar')
      <div class="col-xl-9 col-lg-9 col-md-12">
        <div class="dashboard__content__wraper">
          <div class="dashboard__section__title mb-3">
            <h4>{{ $communication->subject }}</h4>
            <div>Status: <span class="badge bg-secondary">{{ $communication->status }}</span></div>
          </div>

          <div class="mb-4">
            <h6>Attachments</h6>
            @forelse($communication->attachments as $a)
              <div>{{ $a->filename }} ({{ number_format($a->size/1024, 1) }} KB)</div>
            @empty
              <div>No attachments</div>
            @endforelse
          </div>

          <div class="mb-4">
            <h6>Body</h6>
            <div class="border rounded p-3">{!! $communication->body_html ?? nl2br(e($communication->body_text)) !!}</div>
          </div>

          <div class="table-responsive">
            <table class="table table-striped example">
              <thead>
                <tr>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Sent at</th>
                  <th>Failed at</th>
                  <th>Error</th>
                </tr>
              </thead>
              <tbody>
                @foreach($communication->recipients as $r)
                  <tr>
                    <td>{{ $r->email }}</td>
                    <td>{{ $r->status }}</td>
                    <td>{{ $r->sent_at }}</td>
                    <td>{{ $r->failed_at }}</td>
                    <td>{{ $r->error_message }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection


