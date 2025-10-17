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
                            <h3>💬 Memos Portal</h3>
                        </div>
                        
                        {{-- Status Cards --}}
                        <div class="row mb-4">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="dashboard__card uimms-card pending" onclick="loadMemos('pending')" data-status="pending">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-chat"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>💬 Active Chats</h5>
                                            <h3 class="count" id="count-pending">{{ $pendingCount }}</h3>
                                            <p>Pending conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="dashboard__card uimms-card suspended" onclick="loadMemos('suspended')" data-status="suspended">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-pause"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>⏸️ Suspended</h5>
                                            <h3 class="count" id="count-suspended">{{ $suspendedCount }}</h3>
                                            <p>Paused conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="dashboard__card uimms-card completed" onclick="loadMemos('completed')" data-status="completed">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-check-circled"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>✅ Completed</h5>
                                            <h3 class="count" id="count-completed">{{ $completedCount }}</h3>
                                            <p>Finished conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12 mb-3">
                                <div class="dashboard__card uimms-card archived" onclick="loadMemos('archived')" data-status="archived">
                                    <div class="dashboard__card__content">
                                        <div class="dashboard__card__icon">
                                            <i class="icofont-archive"></i>
                                        </div>
                                        <div class="dashboard__card__text">
                                            <h5>📦 Archive</h5>
                                            <h3 class="count" id="count-archived">{{ $archivedCount }}</h3>
                                            <p>Old conversations</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="dashboard__meessage__wraper">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="dashboard__meessage">
                                        <div class="dashboard__meessage__chat memos-toolbar">
                                            <div class="memos-header-content">
                                                <div class="memos-header-left">
                                                    <div class="memos-icon-wrapper">
                                                        <i class="icofont-chat"></i>
                                                    </div>
                                                    <div class="memos-header-text">
                                                        <h3 class="memos-title" id="section-title">Active Chats</h3>
                                                        <span class="memos-subtitle" id="section-subtitle">Manage your conversations</span>
                                                    </div>
                                                </div>
                                                <div class="memos-header-right">
                                                    <button class="btn btn-sm btn-outline-primary memos-refresh-btn" onclick="refreshMemos()">
                                                        <i class="icofont-refresh"></i> Refresh
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="dashboard__meessage__contact" id="memos-container">
                                            <div class="text-center py-5">
                                                <i class="icofont-chat" style="font-size: 48px; color: #ddd;"></i>
                                                <p class="text-muted mt-3">Click on a card above to load memos</p>
                                            </div>
                                        </div>

                                        <style>
                                        /* Card Styles */
                                        .uimms-card {
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            border: 2px solid transparent;
                                            border-radius: 12px;
                                            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
                                            position: relative;
                                            overflow: hidden;
                                        }

                                        .uimms-card::before {
                                            content: '';
                                            position: absolute;
                                            top: 0;
                                            left: 0;
                                            right: 0;
                                            bottom: 0;
                                            background: inherit;
                                            opacity: 0;
                                            transition: opacity 0.3s ease;
                                        }

                                        .uimms-card:hover {
                                            transform: translateY(-5px);
                                            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
                                        }

                                        .uimms-card.active {
                                            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
                                            border-width: 3px;
                                        }

                                        .uimms-card.pending {
                                            border-color: #007bff;
                                            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                                        }

                                        .uimms-card.pending.active {
                                            border-width: 3px;
                                            border-color: #007bff;
                                            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
                                            position: relative;
                                        }

                                        .uimms-card.pending.active::after {
                                            content: '●';
                                            position: absolute;
                                            top: 10px;
                                            right: 10px;
                                            color: #007bff;
                                            font-size: 16px;
                                            font-weight: bold;
                                        }

                                        .uimms-card.suspended {
                                            border-color: #ffc107;
                                            background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
                                        }

                                        .uimms-card.suspended.active {
                                            border-width: 3px;
                                            border-color: #ffc107;
                                            background: linear-gradient(135deg, #fff8e1 0%, #ffecb3 100%);
                                            position: relative;
                                        }

                                        .uimms-card.suspended.active::after {
                                            content: '●';
                                            position: absolute;
                                            top: 10px;
                                            right: 10px;
                                            color: #ffc107;
                                            font-size: 16px;
                                            font-weight: bold;
                                        }

                                        .uimms-card.completed {
                                            border-color: #28a745;
                                            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
                                        }

                                        .uimms-card.completed.active {
                                            border-width: 3px;
                                            border-color: #28a745;
                                            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
                                            position: relative;
                                        }

                                        .uimms-card.completed.active::after {
                                            content: '●';
                                            position: absolute;
                                            top: 10px;
                                            right: 10px;
                                            color: #28a745;
                                            font-size: 16px;
                                            font-weight: bold;
                                        }

                                        .uimms-card.archived {
                                            border-color: #6c757d;
                                            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
                                        }

                                        .uimms-card.archived.active {
                                            border-width: 3px;
                                            border-color: #6c757d;
                                            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
                                            position: relative;
                                        }

                                        .uimms-card.archived.active::after {
                                            content: '●';
                                            position: absolute;
                                            top: 10px;
                                            right: 10px;
                                            color: #6c757d;
                                            font-size: 16px;
                                            font-weight: bold;
                                        }

                                        .dashboard__card__content {
                                            display: flex;
                                            align-items: center;
                                            padding: 20px;
                                            position: relative;
                                            z-index: 1;
                                        }

                                        .dashboard__card__icon {
                                            font-size: 48px;
                                            margin-right: 20px;
                                            opacity: 0.8;
                                        }

                                        .uimms-card.active .dashboard__card__icon {
                                            opacity: 1;
                                        }

                                        .dashboard__card__text h5 {
                                            margin: 0 0 10px 0;
                                            font-weight: 600;
                                            font-size: 1rem;
                                        }

                                        .dashboard__card__text h3 {
                                            margin: 0 0 5px 0;
                                            font-size: 2.5rem;
                                            font-weight: 700;
                                        }

                                        .dashboard__card__text p {
                                            margin: 0;
                                            font-size: 0.9rem;
                                            opacity: 0.8;
                                        }

                                        /* Responsive Adjustments */
                                        @media (max-width: 1199px) {
                                            .dashboard__card__icon {
                                                font-size: 40px;
                                                margin-right: 15px;
                                            }
                                            
                                            .dashboard__card__text h3 {
                                                font-size: 2rem;
                                            }
                                        }

                                        @media (max-width: 767px) {
                                            .dashboard__card__content {
                                                padding: 15px;
                                            }
                                            
                                            .dashboard__card__icon {
                                                font-size: 36px;
                                                margin-right: 12px;
                                            }
                                            
                                            .dashboard__card__text h3 {
                                                font-size: 1.8rem;
                                            }
                                            
                                            .dashboard__card__text h5 {
                                                font-size: 0.9rem;
                                            }
                                            
                                            .dashboard__card__text p {
                                                font-size: 0.8rem;
                                            }
                                        }

                                        @media (max-width: 575px) {
                                            .dashboard__card__content {
                                                flex-direction: column;
                                                text-align: center;
                                            }
                                            
                                            .dashboard__card__icon {
                                                margin-right: 0;
                                                margin-bottom: 10px;
                                            }
                                        }
                                        
                                        .memos-toolbar {
                                            position: sticky;
                                            top: 0;
                                            z-index: 5;
                                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                            border-radius: 12px 12px 0 0;
                                            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
                                            overflow: hidden;
                                        }
                                        
                                        .memos-header-content {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            padding: 20px 25px;
                                            gap: 20px;
                                        }
                                        
                                        .memos-header-left {
                                            display: flex;
                                            align-items: center;
                                            gap: 15px;
                                        }
                                        
                                        .memos-icon-wrapper {
                                            width: 50px;
                                            height: 50px;
                                            background: rgba(255, 255, 255, 0.2);
                                            border-radius: 12px;
                                            display: flex;
                                            align-items: center;
                                            justify-content: center;
                                            backdrop-filter: blur(10px);
                                            border: 1px solid rgba(255, 255, 255, 0.3);
                                        }
                                        
                                        .memos-icon-wrapper i {
                                            font-size: 24px;
                                            color: white;
                                        }
                                        
                                        .memos-header-text {
                                            display: flex;
                                            flex-direction: column;
                                            gap: 2px;
                                        }
                                        
                                        .memos-title {
                                            margin: 0;
                                            color: white;
                                            font-size: 1.4rem;
                                            font-weight: 600;
                                            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                        }
                                        
                                        .memos-subtitle {
                                            color: rgba(255, 255, 255, 0.8);
                                            font-size: 0.9rem;
                                            font-weight: 400;
                                        }
                                        
                                        .memos-header-right {
                                            display: flex;
                                            align-items: center;
                                        }
                                        
                                        .memos-refresh-btn {
                                            background: rgba(255, 255, 255, 0.15);
                                            border: 1px solid rgba(255, 255, 255, 0.3);
                                            color: white;
                                            backdrop-filter: blur(10px);
                                            transition: all 0.3s ease;
                                            border-radius: 8px;
                                            padding: 8px 16px;
                                            font-weight: 500;
                                        }
                                        
                                        .memos-refresh-btn:hover {
                                            background: rgba(255, 255, 255, 0.25);
                                            border-color: rgba(255, 255, 255, 0.5);
                                            color: white;
                                            transform: translateY(-1px);
                                            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                                        }
                                        
                                        .memos-refresh-btn i {
                                            margin-right: 6px;
                                        }
                                        
                                        /* Responsive Design for Header */
                                        @media (max-width: 768px) {
                                            .memos-header-content {
                                                padding: 15px 20px;
                                                gap: 15px;
                                            }
                                            
                                            .memos-header-left {
                                                gap: 12px;
                                            }
                                            
                                            .memos-icon-wrapper {
                                                width: 45px;
                                                height: 45px;
                                            }
                                            
                                            .memos-icon-wrapper i {
                                                font-size: 20px;
                                            }
                                            
                                            .memos-title {
                                                font-size: 1.2rem;
                                            }
                                            
                                            .memos-subtitle {
                                                font-size: 0.8rem;
                                            }
                                            
                                            .memos-refresh-btn {
                                                padding: 6px 12px;
                                                font-size: 0.85rem;
                                            }
                                        }
                                        
                                        @media (max-width: 480px) {
                                            .memos-header-content {
                                                flex-direction: column;
                                                align-items: flex-start;
                                                gap: 12px;
                                            }
                                            
                                            .memos-header-right {
                                                align-self: flex-end;
                                            }
                                            
                                            .memos-header-left {
                                                width: 100%;
                                            }
                                        }
                                        
                                        .memo-item {
                                            border-bottom: 1px solid #eef2f7;
                                            transition: all 0.3s ease;
                                            cursor: pointer;
                                        }
                                        
                                        .memo-item:hover {
                                            background: #f8f9ff;
                                        }
                                        
                                        .dashboard__meessage__contact__wrap {
                                            display: flex;
                                            gap: 15px;
                                            padding: 15px 20px;
                                            align-items: flex-start;
                                        }
                                        
                                        .dashboard__meessage__chat__img img {
                                            width: 48px;
                                            height: 48px;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 2px solid #e9ecef;
                                        }
                                        
                                        .dashboard__meessage__meta {
                                            flex: 1;
                                        }
                                        
                                        .dashboard__meessage__meta h5 {
                                            margin: 0 0 5px 0;
                                            font-size: 1rem;
                                            font-weight: 600;
                                            color: #333;
                                        }
                                        
                                        .memo-subject {
                                            font-weight: 500;
                                            color: #555;
                                            margin-bottom: 5px;
                                        }
                                        
                                        .memo-preview {
                                            color: #666;
                                            font-size: 0.9rem;
                                            margin-bottom: 8px;
                                            display: -webkit-box;
                                            -webkit-line-clamp: 2;
                                            -webkit-box-orient: vertical;
                                            overflow: hidden;
                                        }
                                        
                                        .memo-footer {
                                            display: flex;
                                            align-items: center;
                                            gap: 15px;
                                            flex-wrap: wrap;
                                        }
                                        
                                        .chat__time {
                                            font-size: 0.85rem;
                                            color: #999;
                                        }
                                        
                                        .memo-participants {
                                            display: flex;
                                            align-items: center;
                                            gap: 5px;
                                        }
                                        
                                        .participant-avatar-small {
                                            width: 24px;
                                            height: 24px;
                                            border-radius: 50%;
                                            object-fit: cover;
                                            border: 2px solid #fff;
                                            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                                        }
                                        
                                        .memo-status-badge {
                                            padding: 4px 10px;
                                            border-radius: 12px;
                                            font-size: 0.75rem;
                                            font-weight: 500;
                                        }
                                        
                                        .status-pending { background: #e3f2fd; color: #1976d2; }
                                        .status-suspended { background: #fff8e1; color: #f57c00; }
                                        .status-completed { background: #e8f5e8; color: #388e3c; }
                                        .status-archived { background: #f5f5f5; color: #616161; }
                                        
                                        .badge.bg-success {
                                            background: #28a745 !important;
                                            color: white;
                                            padding: 4px 8px;
                                            border-radius: 10px;
                                            font-size: 0.7rem;
                                        }
                                        </style>

                                        <script>
                                        let currentStatus = 'pending';

                                        // Load memos on page load
                                        window.addEventListener('load', function() {
                                            loadMemos('pending');
                                        });

                                        function loadMemos(status) {
                                            currentStatus = status;
                                            
                                            // Update active card
                                            document.querySelectorAll('.uimms-card').forEach(card => {
                                                card.classList.remove('active');
                                            });
                                            document.querySelector(`.uimms-card[data-status="${status}"]`).classList.add('active');
                                            
                                            // Update section title and subtitle
                                            const titles = {
                                                'pending': 'Active Chats',
                                                'suspended': 'Suspended Conversations',
                                                'completed': 'Completed Conversations',
                                                'archived': 'Archived Conversations'
                                            };
                                            
                                            const subtitles = {
                                                'pending': 'Manage your active conversations',
                                                'suspended': 'View paused conversations',
                                                'completed': 'Review finished conversations',
                                                'archived': 'Browse old conversations'
                                            };
                                            
                                            document.getElementById('section-title').textContent = titles[status];
                                            document.getElementById('section-subtitle').textContent = subtitles[status];
                                            
                                            // Show loading
                                            document.getElementById('memos-container').innerHTML = `
                                                <div class="text-center py-5">
                                                    <div class="spinner-border text-primary" role="status">
                                                        <span class="visually-hidden">Loading...</span>
                                                    </div>
                                                    <p class="text-muted mt-3">Loading memos...</p>
                                                </div>
                                            `;
                                            
                                            // Fetch memos
                                            fetch(`/dashboard/uimms/memos/${status}`)
                                                .then(response => response.json())
                                                .then(memos => {
                                                    displayMemos(memos);
                                                })
                                                .catch(error => {
                                                    console.error('Error loading memos:', error);
                                                    document.getElementById('memos-container').innerHTML = `
                                                        <div class="text-center py-5">
                                                            <i class="icofont-warning" style="font-size: 48px; color: #dc3545;"></i>
                                                            <p class="text-danger mt-3">Error loading memos. Please try again.</p>
                                                        </div>
                                                    `;
                                                });
                                        }

                                        function displayMemos(memos) {
                                            if (memos.length === 0) {
                                                document.getElementById('memos-container').innerHTML = `
                                                    <div class="text-center py-5">
                                                        <i class="icofont-chat" style="font-size: 48px; color: #ddd;"></i>
                                                        <p class="text-muted mt-3">No memos found in this section</p>
                                                    </div>
                                                `;
                                                return;
                                            }
                                            
                                            const memosHtml = `
                                                <ul>
                                                    ${memos.map(memo => {
                                                        const creator = memo.creator || {};
                                                        const creatorName = creator.first_name && creator.last_name 
                                                            ? `${creator.first_name} ${creator.last_name}` 
                                                            : 'System';
                                                        const creatorAvatar = creator.profile_picture_url || '/profile_pictures/default-profile.png';
                                                        const lastMessage = memo.last_message;
                                                        const lastMessageTime = lastMessage 
                                                            ? new Date(lastMessage.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
                                                            : new Date(memo.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
                                                        const participants = memo.active_participants || [];
                                                        const isUnread = false; // You can add unread logic here
                                                        
                                                        return `
                                                            <li class="memo-item" onclick="openMemoChat(${memo.id})">
                                                                <div class="dashboard__meessage__contact__wrap">
                                                                    <div class="dashboard__meessage__chat__img">
                                                                        <img src="${creatorAvatar}" alt="${creatorName}">
                                                                    </div>
                                                                    <div class="dashboard__meessage__meta">
                                                                        <h5>${creatorName}</h5>
                                                                        <div class="memo-subject">${memo.subject}</div>
                                                                        <div class="memo-preview">${memo.message ? memo.message.substring(0, 100) : 'No content'}...</div>
                                                                        <div class="memo-footer">
                                                                            <span class="chat__time">${lastMessageTime}</span>
                                                                            ${participants.length > 1 ? `
                                                                                <div class="memo-participants">
                                                                                    <i class="icofont-users" style="color: #999; font-size: 0.9rem;"></i>
                                                                                    ${participants.slice(0, 3).map(p => `
                                                                                        <img src="${p.user?.profile_picture_url || '/profile_pictures/default-profile.png'}" 
                                                                                             alt="${p.user?.first_name || 'User'}" 
                                                                                             class="participant-avatar-small"
                                                                                             title="${p.user?.first_name || ''} ${p.user?.last_name || ''}">
                                                                                    `).join('')}
                                                                                    ${participants.length > 3 ? `<span style="font-size: 0.85rem; color: #999;">+${participants.length - 3}</span>` : ''}
                                                                                </div>
                                                                            ` : ''}
                                                                            <span class="memo-status-badge status-${memo.memo_status}">${memo.memo_status}</span>
                                                                            ${isUnread ? '<span class="badge bg-success">New</span>' : ''}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        `;
                                                    }).join('')}
                                                </ul>
                                            `;
                                            
                                            document.getElementById('memos-container').innerHTML = memosHtml;
                                        }

                                        function openMemoChat(memoId) {
                                            window.location.href = `/dashboard/uimms/chat/${memoId}`;
                                        }

                                        function refreshMemos() {
                                            loadMemos(currentStatus);
                                        }

                                        // Auto-refresh every 30 seconds
                                        setInterval(() => {
                                            if (currentStatus) {
                                                loadMemos(currentStatus);
                                            }
                                        }, 30000);
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