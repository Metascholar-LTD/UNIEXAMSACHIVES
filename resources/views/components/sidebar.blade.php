<div class="col-xl-3 col-lg-3 col-md-12">
    <div class="dashboard__inner sticky-top">
        <div class="sidebar-section-header welcome-header">
            <div class="section-header-content">
                <div class="section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="section-text">
                    <h6 class="section-title">Welcome, {{auth()->user()->first_name}} {{auth()->user()->last_name}}</h6>
                    <span class="section-subtitle">Dashboard Overview</span>
                </div>
                <div class="section-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="dashboard__nav">
            <ul>
                <li>
                    <a class="{{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{route('dashboard')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-home">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        Dashboard</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}" href="{{route('dashboard.profile')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-user">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        My Profile</a>
                </li>
                {{-- Memos Portal - Single Link (No Dropdown) --}}
                <li>
                    <a class="{{ request()->routeIs('dashboard.uimms.*') ? 'active' : '' }}" href="{{route('dashboard.uimms.portal')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-message-circle">
                            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
                        </svg>
                        Memos Portal
                    </a><span class="dashboard__label">{{ $newMessagesCount ?? 0 }}</span>
                </li>

                <li>
                    <a class="{{ request()->routeIs('dashboard.document') ? 'active' : '' }}" href="{{route('dashboard.document')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bookmark">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        All Documents</a>
                </li>

            </ul>
        </div>
        
        {{-- Exams --}}
        <div class="sidebar-section-header">
            <div class="section-header-content">
                <div class="section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                        <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                    </svg>
                </div>
                <div class="section-text">
                    <h6 class="section-title">EXAMS CLASS PORTFOLIO</h6>
                    <span class="section-subtitle">3 categories</span>
                </div>
                <div class="section-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="dashboard__nav">
            <ul>
                @auth
                @if(auth()->user()->is_admin)
                <li>
                    <a class="{{ request()->routeIs('dashboard.pending.exams') ? 'active' : '' }}" href="{{route('dashboard.pending.exams')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bookmark">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Pending Exams</a><span class="dashboard__label">{{$pendingCount}}</span>
                </li>
                <li>
                    <a class="{{ request()->routeIs('dashboard.approve.exams') ? 'active' : '' }}" href="{{route('dashboard.approve.exams')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bookmark">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Approved Exams </a><span class="dashboard__label">{{$approvedCount}}</span>
                </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.upload.document') ? 'active' : '' }}" href="{{route('dashboard.upload.document')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            All Exams Archive</a><span class="dashboard__label">{{$allExansCount}}</span>
                    </li>
                @endif
                @endauth
                @auth
                    @unless(auth()->user()->is_admin)
                    <li>
                        <a class="{{ request()->routeIs('dashboard.all.pending.exams') ? 'active' : '' }}" href="{{route('dashboard.all.pending.exams')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Pending Exams
                        </a><span class="dashboard__label">{{$pendingCount}}</span>

                    </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.all.approve.exams') ? 'active' : '' }}" href="{{route('dashboard.all.approve.exams')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Approved Exams
                        </a><span class="dashboard__label">{{$approvedCount}}</span>

                    </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.all.upload.document') ? 'active' : '' }}" href="{{route('dashboard.all.upload.document')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-bookmark">
                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                </svg>
                                All Exams Archive
                            </a><span class="dashboard__label">{{$allExansCount}}</span>

                        </li>
                    @endunless
                @endauth

            </ul>
        </div>

        {{-- File --}}
        <div class="sidebar-section-header">
            <div class="section-header-content">
                <div class="section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                        <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                    </svg>
                </div>
                <div class="section-text">
                    <h6 class="section-title">FILES CLASS PORTFOLIO</h6>
                    <span class="section-subtitle">3 categories</span>
                </div>
                <div class="section-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </div>
            </div>
        </div>
        <div class="dashboard__nav">
            <ul>
                @auth
                @if(auth()->user()->is_admin)
                <li>
                    <a class="{{ request()->routeIs('dashboard.pending.files') ? 'active' : '' }}" href="{{route('dashboard.pending.files')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bookmark">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Pending Files</a><span class="dashboard__label">{{$pendingFilesCount}}</span>
                </li>
                <li>
                    <a class="{{ request()->routeIs('dashboard.approve.files') ? 'active' : '' }}" href="{{route('dashboard.approve.files')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-bookmark">
                            <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                        </svg>
                        Files Approved</a><span class="dashboard__label">{{$approvedFilesCount}}</span>
                </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.upload.file') ? 'active' : '' }}" href="{{route('dashboard.upload.file')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            All Files Archive</a><span class="dashboard__label">{{$allFilesCount}}</span>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.folders.*') ? 'active' : '' }}" href="{{route('dashboard.folders.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-folder">
                                <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                            </svg>
                            My Folders</a>
                    </li>
                @endif
                @endauth
                @auth
                    @unless(auth()->user()->is_admin)
                    <li>
                        <a class="{{ request()->routeIs('dashboard.all.pending.files') ? 'active' : '' }}" href="{{route('dashboard.all.pending.files')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Pending Files
                        </a><span class="dashboard__label">{{$pendingFilesCount}}</span>

                    </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.all.approve.files') ? 'active' : '' }}" href="{{route('dashboard.all.approve.files')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-bookmark">
                                <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                            </svg>
                            Approved Files
                        </a><span class="dashboard__label">{{$approvedFilesCount}}</span>

                    </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.all.upload.file') ? 'active' : '' }}" href="{{route('dashboard.all.upload.file')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-bookmark">
                                    <path d="M19 21l-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2z"></path>
                                </svg>
                                All Files Archive
                            </a><span class="dashboard__label">{{$allFilesCount}}</span>

                        </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.folders.*') ? 'active' : '' }}" href="{{route('dashboard.folders.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-folder">
                                    <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                                </svg>
                                My Folders</a>
                        </li>
                    @endunless
                @endauth

            </ul>
        </div>

        {{-- Advanced Communication System (Users Only) --}}
        @auth
            @unless(auth()->user()->is_admin)
                <div class="sidebar-section-header">
                    <div class="section-header-content">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                                <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                            </svg>
                        </div>
                        <div class="section-text">
                            <h6 class="section-title">ADVANCED COMMUNICATION SYSTEM</h6>
                            <span class="section-subtitle">3 features</span>
                        </div>
                        <div class="section-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6,9 12,15 18,9"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="dashboard__nav">
                    <ul>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication.index') ? 'active' : '' }}" href="{{route('admin.communication.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-mail">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                Memos</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication.create') ? 'active' : '' }}" href="{{route('admin.communication.create')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Compose Memo</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication.statistics') ? 'active' : '' }}" href="{{route('admin.communication.statistics')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-bar-chart-2">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                                Statistics</a>
                        </li>
                    </ul>
                </div>
            @endunless
        @endauth

        {{-- Advanced Communication System (Admin Only) --}}
        @auth
            @if(auth()->user()->is_admin)
                <div class="sidebar-section-header">
                    <div class="section-header-content">
                        <div class="section-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                                <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                            </svg>
                        </div>
                        <div class="section-text">
                            <h6 class="section-title">ADVANCED COMMUNICATION SYSTEM</h6>
                            <span class="section-subtitle">3 features</span>
                        </div>
                        <div class="section-arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                                <polyline points="6,9 12,15 18,9"></polyline>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="dashboard__nav">
                    <ul>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication-admin.index') ? 'active' : '' }}" href="{{route('admin.communication-admin.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-mail">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                Memos</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication-admin.create') ? 'active' : '' }}" href="{{route('admin.communication-admin.create')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                                Compose Memo</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication-admin.statistics') ? 'active' : '' }}" href="{{route('admin.communication-admin.statistics')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-bar-chart-2">
                                    <line x1="18" y1="20" x2="18" y2="10"></line>
                                    <line x1="12" y1="20" x2="12" y2="4"></line>
                                    <line x1="6" y1="20" x2="6" y2="14"></line>
                                </svg>
                                Statistics</a>
                        </li>
                    </ul>
                </div>
            @endif
        @endauth

        {{-- Users --}}
        <div class="sidebar-section-header">
            <div class="section-header-content">
                <div class="section-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-folder">
                        <path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                    </svg>
                </div>
                <div class="section-text">
                    <h6 class="section-title">MANAGEMENT</h6>
                    <!--<span class="section-subtitle">4 features</span>-->
                </div>
                <div class="section-arrow">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down">
                        <polyline points="6,9 12,15 18,9"></polyline>
                    </svg>
                </div>
            </div>
        </div>

        <div class="dashboard__nav">
            <ul>
                @auth
                    @unless(auth()->user()->is_admin)
                        <li>
                            <a class="{{ request()->routeIs('dashboard.users') ? 'active' : '' }}" href="{{route('dashboard.users')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Manage Users</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.details.store') ? 'active' : '' }}" href="#" id="triggerLogoModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Set Logo / Title</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('departments.index') ? 'active' : '' }}" href="{{route('departments.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Department/Faculty</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('positions.index') ? 'active' : '' }}" href="{{route('positions.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Positions</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.academic.store') ? 'active' : '' }}" href="#" id="triggerAcademicModal">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Academic Year</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.payment-history.*') ? 'active' : '' }}" href="{{route('dashboard.payment-history.index')}}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-credit-card">
                                    <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                    <line x1="1" y1="10" x2="23" y2="10"></line>
                                </svg>
                                Payment History</a>
                        </li>
                    @endunless
                @endauth
                <li>
                    <a class="{{ request()->routeIs('dashboard.settings') ? 'active' : '' }}" href="{{route('dashboard.settings')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-settings">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z">
                            </path>
                        </svg>
                        Settings</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <a href="{{route('logout')}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-volume-1">
                            <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"></polygon>
                            <path d="M15.54 8.46a5 5 0 0 1 0 7.07"></path>
                        </svg>
                        Logout</a>
                    </form>
                </li>



            </ul>
        </div>


    </div>
</div>

<!-- Logo Modal -->
<div class="modal fade" id="myLogoModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Logo and System Name</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- content --}}
                <form action="{{route('dashboard.details.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="col-xl-12">
                        <div class="dashboard__form__wraper">
                            <div class="dashboard__form__input">
                                <label >System Title</label>
                                <input type="text" placeholder="Enter Title" name="title">
                            </div>
                            <div class="dashboard__form__input">
                                <label >Logo</label>
                                <input type="file" placeholder="Choose a file" name="logo_image">
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Department Modal -->
<div class="modal fade" id="myDepartmentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Department/Faculty</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- content --}}
                <form action="{{route('departments.store')}}" method="POST">
                    @csrf
                    <div class="col-xl-12">
                        <div class="dashboard__form__wraper">
                            <div class="dashboard__form__input">
                                <label >Name</label>
                                <input type="text" placeholder="Enter Department or Faculty Name" name="name" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Save changes</button>

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Academic Year Modal -->
<div class="modal fade" id="myAcademicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Academic Year</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- content --}}
                <form action="{{route('dashboard.academic.store')}}" method="POST">
                    @csrf
                    <div class="col-xl-12">
                        <div class="dashboard__form__wraper">
                            <div class="dashboard__form__input">
                                <label >Academic Year</label>
                                <input type="text" placeholder="Enter Academic Year" name="year" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Save changes</button>

                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all sidebar section headers
    const sectionHeaders = document.querySelectorAll('.sidebar-section-header');
    
    sectionHeaders.forEach(header => {
        header.addEventListener('click', function() {
            // Find the next navigation section
            const nextNav = this.nextElementSibling;
            
            if (nextNav && nextNav.classList.contains('dashboard__nav')) {
                // Toggle visibility
                if (nextNav.style.display === 'none') {
                    nextNav.style.display = 'block';
                    this.classList.remove('collapsed');
                } else {
                    nextNav.style.display = 'none';
                    this.classList.add('collapsed');
                }
            }
        });
        
        // Add initial state - all sections expanded by default
        const nextNav = header.nextElementSibling;
        if (nextNav && nextNav.classList.contains('dashboard__nav')) {
            nextNav.style.display = 'block';
        }
    });
    
    // Add smooth animations
    const navSections = document.querySelectorAll('.dashboard__nav');
    navSections.forEach(nav => {
        nav.style.transition = 'all 0.3s ease-in-out';
    });
});

// Dropdown functionality removed - using direct link now
</script>

<style>
/* Dropdown styles removed - using direct link now */
</style>
