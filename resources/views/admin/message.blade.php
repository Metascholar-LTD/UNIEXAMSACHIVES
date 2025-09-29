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
                    <div class="dashboard__message__content__main">
                        <div class="dashboard__message__content__main__title dashboard__message__content__main__title__2">
                            <h3>Memos</h3>

                        </div>
                        <div class="dashboard__meessage__wraper">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="dashboard__meessage">
                                        <div class="dashboard__meessage__chat memos-toolbar">
                                            <h3 class="memos-title">All Memos</h3>
                                            <form method="POST" action="{{ route('dashboard.memos.markAllRead') }}" class="memos-markall">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-primary">
                                                    <i class="icofont-check-circled"></i> Mark all as read
                                                </button>
                                            </form>
                                        </div>
                                        {{-- <div class="dashboard__meessage__search">
                                            <button><i class="icofont-search-1"></i></button>
                                            <input type="text" placeholder="Search">
                                        </div> --}}

                                        <div class="dashboard__meessage__contact">
                                            <ul>
                                                @if (count($messages) > 0)
                                                    @foreach ($messages as $message)
                                                        <li>
                                                            <div class="dashboard__meessage__contact__wrap">
                                                                <div class="dashboard__meessage__chat__img">
                                                                <img loading="lazy"  src="../img/teacher/teacher__1.png" alt="">
                                                            </div>
                                                                <div class="dashboard__meessage__meta">
                                                                    <h5>System Memo</h5>
                                                                    <p class="preview">{{$message->campaign->subject}}</p>
                                                                    <span class="chat__time">{{$message->created_at->format('d M Y')}}</span>
                                                                    <a href="{{route('dashboard.memo.read', $message->id)}}">Read More</a>
                                                                    @if(!$message->is_read)
                                                                        <span class="badge bg-success" style="margin-left:8px;">New</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                @else
                                                <li>No Message Yet!</li>
                                                @endif
                                            </ul>
                                        </div>

                                        <style>
                                        .memos-toolbar { display:flex; align-items:center; justify-content:space-between; gap:12px; position: sticky; top: 0; z-index: 5; background: #ffffff; padding: 8px 10px; border-bottom: 1px solid #eef2f7; }
                                        .memos-title { margin: 0; }
                                        .memos-markall { margin: 0; }
                                        </style>

                                        <script>
                                        // Refresh the memos list when coming back from a detail view
                                        (function(){
                                          let shouldReloadOnFocus = true;
                                          window.addEventListener('focus', function(){
                                            if (shouldReloadOnFocus) {
                                              shouldReloadOnFocus = false;
                                              // Delay a tick to avoid double reloads
                                              setTimeout(function(){ location.reload(); }, 50);
                                            }
                                          });
                                          document.addEventListener('visibilitychange', function(){
                                            if (!document.hidden) {
                                              setTimeout(function(){ location.reload(); }, 50);
                                            }
                                          });
                                        })();
                                        </script>


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
@endsection
