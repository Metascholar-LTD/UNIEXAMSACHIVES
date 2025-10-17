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
                        
                        {{-- Status Tabs --}}
                        <div class="memo-tabs">
                            <button class="memo-tab active" onclick="loadMemos('pending')" data-status="pending">
                                💬 Active Chats <span class="tab-count" id="count-pending">({{ $pendingCount }})</span>
                            </button>
                            <button class="memo-tab" onclick="loadMemos('suspended')" data-status="suspended">
                                ⏸️ Suspended <span class="tab-count" id="count-suspended">({{ $suspendedCount }})</span>
                            </button>
                            <button class="memo-tab" onclick="loadMemos('completed')" data-status="completed">
                                ✅ Completed <span class="tab-count" id="count-completed">({{ $completedCount }})</span>
                            </button>
                            <button class="memo-tab" onclick="loadMemos('archived')" data-status="archived">
                                📦 Archived <span class="tab-count" id="count-archived">({{ $archivedCount }})</span>
                            </button>
                        </div>

                        <div class="dashboard__meessage__wraper">
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="dashboard__meessage">
                                        <div class="dashboard__meessage__chat memos-toolbar">
                                            <h3 class="memos-title" id="section-title">💬 Active Chats</h3>
                                            <button class="btn btn-sm btn-outline-primary" onclick="refreshMemos()">
                                                <i class="icofont-refresh"></i> Refresh
                                            </button>
                                        </div>

                                        <div class="dashboard__meessage__contact" id="memos-container">
                                            <div class="text-center py-5">
                                                <i class="icofont-chat" style="font-size: 48px; color: #ddd;"></i>
                                                <p class="text-muted mt-3">Click on a tab above to load memos</p>
                                            </div>
                                        </div>

                                        <style>
                                        .memo-tabs {
                                            display: flex;
                                            gap: 8px;
                                            margin-bottom: 20px;
                                            flex-wrap: wrap;
                                            padding: 0 20px;
                                        }
                                        
                                        .memo-tab {
                                            flex: 1;
                                            min-width: 150px;
                                            padding: 12px 20px;
                                            background: #f8f9fa;
                                            border: 2px solid #e9ecef;
                                            border-radius: 8px;
                                            cursor: pointer;
                                            transition: all 0.3s ease;
                                            font-weight: 500;
                                            color: #666;
                                        }
                                        
                                        .memo-tab:hover {
                                            background: #e9ecef;
                                            border-color: #007bff;
                                            color: #007bff;
                                        }
                                        
                                        .memo-tab.active {
                                            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                            border-color: #667eea;
                                            color: white;
                                            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
                                        }
                                        
                                        .tab-count {
                                            font-size: 0.9em;
                                            opacity: 0.8;
                                        }
                                        
                                        .memos-toolbar {
                                            display: flex;
                                            align-items: center;
                                            justify-content: space-between;
                                            gap: 12px;
                                            position: sticky;
                                            top: 0;
                                            z-index: 5;
                                            background: #ffffff;
                                            padding: 15px 20px;
                                            border-bottom: 2px solid #eef2f7;
                                        }
                                        
                                        .memos-title {
                                            margin: 0;
                                            color: #333;
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
                                            
                                            // Update active tab
                                            document.querySelectorAll('.memo-tab').forEach(tab => {
                                                tab.classList.remove('active');
                                            });
                                            document.querySelector(`[data-status="${status}"]`).classList.add('active');
                                            
                                            // Update section title
                                            const titles = {
                                                'pending': '💬 Active Chats',
                                                'suspended': '⏸️ Suspended Conversations',
                                                'completed': '✅ Completed Conversations',
                                                'archived': '📦 Archived Conversations'
                                            };
                                            document.getElementById('section-title').textContent = titles[status];
                                            
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