<div class="col-xl-12">
    <div class="dashboardarea__wraper">
        <div class="dashboardarea__img">
            <div class="dashboardarea__inner admin__dashboard__inner">
                <div class="dashboardarea__left">
                    <div class="dashboardarea__left__img">
                        @if (auth()->user()->profile_picture)
                            <img loading="lazy" src="{{ Storage::url(auth()->user()->profile_picture) }}" alt="">
                        @else
                            <img loading="lazy" src="../img/dashbord/dashbord__2.jpg" alt="">
                        @endif
                    </div>
                    <div class="dashboardarea__left__content">
                        <h5>Hello</h5>
                        <h4>{{auth()->user()->first_name}} {{auth()->user()->last_name}}</h4>
                    </div>
                </div>
                <div class="dashboardarea__star">
                    <form action="{{ route('exam.search') }}" method="GET">
                        <div class="p-1 bg-light rounded rounded-pill shadow-sm mb-4 mt-4">
                          <div class="input-group">
                                <input type="search" name="query" placeholder="Search for document" aria-describedby="button-addon1" class="form-control border-0 bg-light">
                                <div class="input-group-append">
                                    <button id="button-addon1" type="submit" class="btn btn-link text-primary"><i class="fa fa-search"></i></button>
                                </div>
                          </div>
                        </div>
                    </form>
                </div>
                <div class="dashboardarea__right">
                    <div class="dashboardarea__right__button">
                        <a class="default__button" href="{{route('dashboard.create')}}">Add Exam
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>
                        <a class="default__button" href="{{route('dashboard.file.create')}}">Add File
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-edit">
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                                <polyline points="12 5 19 12 12 19"></polyline>
                            </svg>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<style>
.form-control:focus {
  box-shadow: none;
}

.form-control-underlined {
  border-width: 0;
  border-bottom-width: 1px;
  border-radius: 0;
  padding-left: 0;
}
</style>
