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
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762872840/dashboard_r0by47.png" alt="Dashboard" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        Dashboard</a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('dashboard.profile') ? 'active' : '' }}" href="{{route('dashboard.profile')}}">
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762873945/profile_1_srj1hi.png" alt="My Profile" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        My Profile</a>
                </li>
                {{-- Memos Portal - Single Link (No Dropdown) --}}
                <li>
                    <a class="{{ request()->routeIs('dashboard.uimms.*') && !request()->routeIs('dashboard.uimms.keep-in-view') ? 'active' : '' }}" href="{{route('dashboard.uimms.portal')}}">
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762943555/0f798328-ccf6-4f51-91b5-13873791d869.png" alt="Memos Portal" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        Memos Portal
                    </a><span class="dashboard__label">{{ $newMessagesCount ?? 0 }}</span>
                </li>
                {{-- Keep in View - Bookmarked Memos --}}
                <li>
                    <a class="{{ request()->routeIs('dashboard.uimms.keep-in-view') ? 'active' : '' }}" href="{{route('dashboard.uimms.keep-in-view')}}">
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762872342/image_pgg76v.png" alt="Keep in View" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        Keep in View
                    </a>
                </li>

                <li>
                    <a class="{{ request()->routeIs('dashboard.document') ? 'active' : '' }}" href="{{route('dashboard.document')}}">
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762873294/folder_smk8rg.png" alt="All Documents" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762892670/exam_esftn0.png" alt="Approved Exams" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        Approved Exams </a><span class="dashboard__label">{{$approvedCount}}</span>
                </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.upload.document') ? 'active' : '' }}" href="{{route('dashboard.upload.document')}}">
                            <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762892811/exam_1_jho0sq.png" alt="All Exams Archive" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                            <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762892670/exam_esftn0.png" alt="Approved Exams" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                            Approved Exams
                        </a><span class="dashboard__label">{{$approvedCount}}</span>

                    </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.all.upload.document') ? 'active' : '' }}" href="{{route('dashboard.all.upload.document')}}">
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762892811/exam_1_jho0sq.png" alt="All Exams Archive" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762939971/approved_jjmla9.png" alt="Files Approved" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        Files Approved</a><span class="dashboard__label">{{$approvedFilesCount}}</span>
                </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.upload.file') ? 'active' : '' }}" href="{{route('dashboard.upload.file')}}">
                            <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762939473/file_k1pnab.png" alt="All Files Archive" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                            All Files Archive</a><span class="dashboard__label">{{$allFilesCount}}</span>
                    </li>
                    <li>
                        <a class="{{ request()->routeIs('dashboard.folders.*') ? 'active' : '' }}" href="{{route('dashboard.folders.index')}}">
                            <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762939707/folder_vta5tl.png" alt="My Folders" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                            <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762939971/approved_jjmla9.png" alt="Approved Files" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                            Approved Files
                        </a><span class="dashboard__label">{{$approvedFilesCount}}</span>

                    </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.all.upload.file') ? 'active' : '' }}" href="{{route('dashboard.all.upload.file')}}">
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762939473/file_k1pnab.png" alt="All Files Archive" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                                All Files Archive
                            </a><span class="dashboard__label">{{$allFilesCount}}</span>

                        </li>
                        <li>
                            <a class="{{ request()->routeIs('dashboard.folders.*') ? 'active' : '' }}" href="{{route('dashboard.folders.index')}}">
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762939707/folder_vta5tl.png" alt="My Folders" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762940231/message_uzbtkd.png" alt="Memos" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                                Memos</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication.create') ? 'active' : '' }}" href="{{route('admin.communication.create')}}">
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762941334/bc12957e-52a0-4a05-8ee8-02bb753d6b58.png" alt="Compose Memo" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762940231/message_uzbtkd.png" alt="Memos" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                                Memos</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('admin.communication-admin.create') ? 'active' : '' }}" href="{{route('admin.communication-admin.create')}}">
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762941334/bc12957e-52a0-4a05-8ee8-02bb753d6b58.png" alt="Compose Memo" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
                                <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762942427/776ed950-3ea3-4bdb-97e6-8ade766c6ebd.png" alt="Manage Users" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                                Manage Users</a>
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
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762941932/2d648212-6d23-4431-beb3-a679d2a6dc43.png" alt="Settings" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
                        Settings</a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    <a href="{{route('logout')}}">
                        <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762942345/d8fc56f0-cf0d-4ba9-b441-8d19dc1623d3.png" alt="Logout" style="width: 18px; height: 18px; object-fit: contain; margin-right: 10px;">
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
