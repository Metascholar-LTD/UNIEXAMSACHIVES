<header>
    <div class="headerarea headerarea__2 header__sticky header__area">
        <div class="uda-clock-bar" data-live-clock="navbar">
            <div class="clock-left">
                <span class="clock-item">
                    <i class="icofont-location-pin"></i>
                    Fiapre - Sunyani, Bono Region, Ghana
                </span>
                <span class="clock-item">
                    <i class="icofont-clock-time"></i>
                    <span class="live-date">Fetching date...</span>
                </span>
                <span class="clock-item clock-item-time">
                    <i class="icofont-ui-calendar"></i>
                    <span class="live-time">--:-- --</span>
                </span>
            </div>
            <div class="clock-right">
                <span class="clock-item">
                    <i class="icofont-iphone"></i>
                    Hotline: (+233) 352 094 658
                </span>
                <span class="clock-item">
                    <i class="icofont-brand-whatsapp"></i>
                    WhatsApp: (+233) 249 260 857
                </span>
                <span class="clock-item">
                    <i class="icofont-email"></i>
                    cugadmin@cug.edu.gh
                </span>
                <div class="clock-social">
                    <a href="https://www.facebook.com/p/Catholic-University-of-Ghanafiapre-100063596018619/" target="_blank" rel="noreferrer" aria-label="Facebook"><i class="icofont-facebook"></i></a>
                </div>
            </div>
        </div>
        <div class="container desktop__menu__wrapper uda-header-container">
            <div class="uda-navbar">
                    <!-- Left: Logo -->
                    <div class="uda-nav-left">
                        @if (Auth::check())
                            @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                                <a href="{{route('dashboard')}}"><img loading="lazy" src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" class="uda-logo" alt="logo"></a>
                            @else
                                <a href="{{route('dashboard')}}"><img loading="lazy" src="{{asset('img/cug_logo_new.jpeg')}}" class="uda-logo" alt="logo"></a>
                            @endif
                        @else
                            @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                                <a href="{{route('frontend.welcome')}}"><img loading="lazy" src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" class="uda-logo" alt="logo"></a>
                            @else
                                <a href="{{route('frontend.welcome')}}"><img loading="lazy" src="{{asset('img/cug_logo_new.jpeg')}}" class="uda-logo" alt="logo"></a>
                            @endif
                        @endif
                    </div>

                    <!-- Center: Title Pill -->
                    <div class="uda-nav-center">
                        @php
                            $udaTitle = (count($systemDetail) > 0 && $systemDetail[0]->title) ? $systemDetail[0]->title : 'University Digital Archive System';
                        @endphp
                        <div class="uda-title-pill">{{ $udaTitle }}</div>
                    </div>

                    <!-- Right: Auth Buttons & Notifications -->
                    <div class="uda-nav-right">
                        @if (Auth::check())
                            <div class="uda-notify">
                                <button class="uda-bell" onclick="toggleMemoDropdown(event)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                    @php
                                        $totalNotifications = ($newMessagesCount ?? 0) + ($newReplyNotifications ?? 0);
                                    @endphp
                                    @if($totalNotifications > 0)
                                    <span class="uda-badge">{{$totalNotifications}}</span>
                                    @endif
                                </button>
                                <div id="uda-memo-dropdown" class="uda-dropdown">
                                    <div class="uda-dropdown-header">
                                        <div class="uda-header-title">
                                            <span class="uda-notification-icon">🔔</span>
                                            <span>Notifications</span>
                                        </div>
                                        <form method="POST" action="{{ route('dashboard.notifications.markAllUnified') }}" class="uda-mark-all-form">
                                            @csrf
                                            <button type="submit" class="uda-mark-all-btn">
                                                <span class="uda-mark-all-icon">✓</span>
                                                Mark all as read
                                            </button>
                                        </form>
                                    </div>
                                    <div class="uda-dropdown-list" id="uda-memo-list">
                                        @php
                                            $recentMemos = \App\Models\EmailCampaignRecipient::with('campaign')
                                                ->where('user_id', Auth::id())
                                                ->orderBy('created_at','desc')
                                                ->limit(5)
                                                ->get();
                                        @endphp
                                        @forelse($recentMemos as $rm)
                                            <a class="uda-dropdown-item" href="{{ route('dashboard.memo.read', $rm->id) }}">
                                                <span class="uda-item-title">{{ Str::limit($rm->campaign->subject, 40) }}</span>
                                                <span class="uda-item-time">{{ $rm->created_at->diffForHumans() }}</span>
                                                @if(!$rm->is_read)
                                                    <span class="uda-dot"></span>
                                                @endif
                                            </a>
                                        @empty
                                            <div class="uda-empty">No memos yet</div>
                                        @endforelse
                                    </div>
                                    <div class="uda-dropdown-footer">
                                        <a href="{{ route('dashboard.message') }}" class="uda-link">View all</a>
                                    </div>
                                </div>
                            </div>
                            <a href="{{route('logout')}}" class="uda-btn uda-btn-primary">Logout</a>
                        @else
                            <a href="{{route('frontend.login')}}" class="uda-btn uda-btn-primary">Register / Login</a>
                        @endif
                    </div>
                </div>
            </div>
            </div>
        </div>
        </div>


        <div class="container-fluid mob_menu_wrapper">
            <div class="row align-items-center">
                <div class="col-6">
                    <div class="mobile-logo">
                    @if (Auth::check())
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                        <a href="{{route('dashboard')}}"><img loading="lazy"  src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" style="width:200px; heigth:200px;" alt="logo"></a>
                        @else
                            <a href="{{route('dashboard')}}"><img loading="lazy"  src="{{asset('img/cug_logo_new.jpeg')}}" style="width:200px; heigth:200px;" alt="logo"></a>

                        @endif

                    @else
                        @if (count($systemDetail) > 0 && $systemDetail[0]->logo_image !== null)
                            <a href="{{route('frontend.welcome')}}"><img loading="lazy"  src="{{asset('logo/'.$systemDetail[0]->logo_image)}}" style="width:200px; heigth:200px;" alt="logo"></a>
                        @else
                            <a href="{{route('frontend.welcome')}}"><img loading="lazy"  src="{{asset('img/cug_logo_new.jpeg')}}" style="width:200px; heigth:200px;" alt="logo"></a>

                        @endif
                    @endif
                    </div>
                </div>
                <div class="col-6">
                    <div class="header-right-wrap">

                        <div class="headerarea__right">

                            {{-- <div class="header__cart">
                                <a href="#"> <i class="icofont-cart-alt"></i></a>
                                <div class="header__right__dropdown__wrapper">
                                    <div class="header__right__dropdown__inner">
                                        <div class="single__header__right__dropdown">

                                            <div class="header__right__dropdown__img">
                                                <a href="#">
                                                    <img loading="lazy"  src="img/grid/cart1.jpg" alt="photo">
                                                </a>
                                            </div>
                                            <div class="header__right__dropdown__content">

                                                <a href="shop-product.html">Web Directory</a>
                                                <p>1 x <span class="price">$ 80.00</span></p>

                                            </div>
                                            <div class="header__right__dropdown__close">
                                                <a href="#"><i class="icofont-close-line"></i></a>
                                            </div>
                                        </div>

                                        <div class="single__header__right__dropdown">

                                            <div class="header__right__dropdown__img">
                                                <a href="#">
                                                    <img loading="lazy"  src="img/grid/cart2.jpg" alt="photo">
                                                </a>
                                            </div>
                                            <div class="header__right__dropdown__content">

                                                <a href="shop-product.html">Design Minois</a>
                                                <p>1 x <span class="price">$ 60.00</span></p>

                                            </div>
                                            <div class="header__right__dropdown__close">
                                                <a href="#"><i class="icofont-close-line"></i></a>
                                            </div>
                                        </div>

                                        <div class="single__header__right__dropdown">

                                            <div class="header__right__dropdown__img">
                                                <a href="#">
                                                    <img loading="lazy"  src="img/grid/cart3.jpg" alt="photo">
                                                </a>
                                            </div>
                                            <div class="header__right__dropdown__content">

                                                <a href="shop-product.html">Crash Course</a>
                                                <p>1 x <span class="price">$ 70.00</span></p>

                                            </div>
                                            <div class="header__right__dropdown__close">
                                                <a href="#"><i class="icofont-close-line"></i></a>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="dropdown__price">Total: <span>$1,100.00</span>
                                    </p>
                                    <div class="header__right__dropdown__button">
                                        <a href="#" class="white__color">VIEW
                                    CART</a>
                                        <a href="#" class="blue__color">CHECKOUT</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>

                        <div class="mobile-off-canvas">
                            {{-- <a class="mobile-aside-button" href="#"><i class="icofont-navigation-menu"></i></a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>


<style>
.uda-notify { position: relative; margin-right: 12px; }
.uda-bell { position: relative; border: none; background: transparent; cursor: pointer; padding: 6px; border-radius: 8px; }
.uda-bell:hover { background: rgba(0,0,0,0.06); }
.uda-badge { position: absolute; top: -2px; right: -2px; background: #ef4444; color: #fff; font-size: 11px; line-height: 1; padding: 3px 6px; border-radius: 999px; font-weight: 700; }
.uda-dropdown { position: absolute; right: 0; top: 36px; min-width: 280px; background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.12); display: none; z-index: 1000; overflow: hidden; }
.uda-dropdown-header, .uda-dropdown-footer { display: flex; align-items: center; justify-content: space-between; padding: 10px 12px; background: #f9fafb; border-bottom: 1px solid #eef2f7; }
.uda-dropdown-footer { border-top: 1px solid #eef2f7; border-bottom: none; }
.uda-dropdown-list { max-height: 320px; overflow-y: auto; }
.uda-dropdown-item { display: flex; align-items: center; gap: 8px; padding: 10px 12px; text-decoration: none; color: #111827; border-bottom: 1px solid #f3f4f6; position: relative; }
.uda-dropdown-item:hover { background: #f9fafb; }
.uda-item-title { font-weight: 600; font-size: 13px; flex: 1; }
.uda-item-time { font-size: 12px; color: #6b7280; }
.uda-dot { width: 8px; height: 8px; background: #10b981; border-radius: 50%; }
.uda-link { background: none; border: none; padding: 0; color: #2563eb; font-weight: 600; cursor: pointer; text-decoration: none; }
.uda-empty { padding: 14px; font-size: 13px; color: #6b7280; text-align: center; }
.uda-section-header { padding: 8px 12px; font-size: 12px; font-weight: 600; color: #6b7280; background: #f3f4f6; border-bottom: 1px solid #e5e7eb; }
.uda-clock-bar {
    width: 100%;
    background: linear-gradient(90deg, #fbfcf9 0%, #fffaf4 50%, #fff8ef 100%);
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 6px 32px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    box-shadow: inset 0 -1px 0 rgba(148, 163, 184, 0.15);
    font-size: 13px;
    font-weight: 600;
    color: #111827;
    z-index: 20;
}

.uda-clock-bar .clock-left,
.uda-clock-bar .clock-right {
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap;
}

.uda-clock-bar .clock-item {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #1f2937;
}

.uda-clock-bar .clock-item i {
    font-size: 15px;
    color: #0f172a;
}

.uda-clock-bar .clock-item-time {
    color: #1d4ed8;
}

.uda-clock-bar .clock-social {
    display: inline-flex;
    gap: 8px;
}

.uda-clock-bar .clock-social a {
    width: 28px;
    height: 28px;
    border-radius: 999px;
    background: rgba(99, 102, 241, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #374151;
    text-decoration: none;
}

.uda-clock-bar .clock-social a:hover {
    background: rgba(99, 102, 241, 0.3);
}

@media (max-width: 992px) {
    .uda-clock-bar {
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
    }
    
    .uda-clock-bar .clock-right {
        width: 100%;
        justify-content: space-between;
    }
}
</style>

<script>
function toggleMemoDropdown(e) {
  e.stopPropagation();
  var dd = document.getElementById('uda-memo-dropdown');
  if (!dd) return;
  dd.style.display = (dd.style.display === 'block') ? 'none' : 'block';
}
document.addEventListener('click', function(){
  var dd = document.getElementById('uda-memo-dropdown');
  if (dd) dd.style.display = 'none';
});

// Notification sound and polling for unread count
let udaBellAudio;
function initBellAudio(){
  try{
    const ctx = new (window.AudioContext || window.webkitAudioContext)();
    udaBellAudio = function(){
      const osc = ctx.createOscillator();
      const gain = ctx.createGain();
      osc.connect(gain); gain.connect(ctx.destination);
      osc.type = 'triangle'; osc.frequency.value = 880;
      gain.gain.setValueAtTime(0, ctx.currentTime);
      gain.gain.linearRampToValueAtTime(0.2, ctx.currentTime + 0.01);
      gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.6);
      osc.start(); osc.stop(ctx.currentTime + 0.6);
      setTimeout(()=>{
        const o2 = ctx.createOscillator(); const g2 = ctx.createGain();
        o2.connect(g2); g2.connect(ctx.destination);
        o2.type='sine'; o2.frequency.value=1320;
        g2.gain.setValueAtTime(0, ctx.currentTime);
        g2.gain.linearRampToValueAtTime(0.15, ctx.currentTime + 0.01);
        g2.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + 0.4);
        o2.start(); o2.stop(ctx.currentTime + 0.4);
      }, 120);
    }
  }catch(e){ udaBellAudio = function(){}; }
}

let lastUnread = Number({{ $newMessagesCount ?? 0 }});
let lastReplyNotifications = Number({{ $newReplyNotifications ?? 0 }});

function updateNotificationBadge(unreadCount, replyCount = 0) {
  const badge = document.querySelector('.uda-badge');
  if (badge) {
    const totalCount = unreadCount + replyCount;
    if (totalCount > 0) {
      badge.textContent = totalCount;
      badge.style.display = 'inline-block';
    } else {
      badge.style.display = 'none';
    }
  }
}

function pollUnread(){
  // Poll for memos
  fetch('{{ route('dashboard.memos.unreadCount') }}', {
    credentials: 'same-origin',
    cache: 'no-cache',
    headers: {
      'Cache-Control': 'no-cache',
      'Pragma': 'no-cache'
    }
  })
    .then(r => r.json())
    .then(data => {
      const unread = Number(data.unread || 0);
      
      // Poll for reply notifications
      fetch('/dashboard/notifications/check', {
        credentials: 'same-origin',
        cache: 'no-cache',
        headers: {
          'Cache-Control': 'no-cache',
          'Pragma': 'no-cache'
        }
      })
      .then(r => r.json())
      .then(notificationData => {
        const replyCount = notificationData.reply_count || 0;
        updateNotificationBadge(unread, replyCount);
        
        if ((unread > lastUnread || replyCount > lastReplyNotifications) && typeof udaBellAudio === 'function') {
          udaBellAudio();
        }
        lastUnread = unread;
        lastReplyNotifications = replyCount;
        
        // Refresh the memo list in the dropdown
        refreshMemoList();
      })
      .catch(err => {
        console.log('Error polling reply notifications:', err);
        updateNotificationBadge(unread);
        lastUnread = unread;
        refreshMemoList();
      });
    })
    .catch(err => {
      console.log('Error polling unread count:', err);
    });
}

function refreshMemoList(){
  // Fetch memos
  fetch('{{ route('dashboard.memos.recent') }}', {
    credentials: 'same-origin',
    cache: 'no-cache',
    headers: {
      'Cache-Control': 'no-cache',
      'Pragma': 'no-cache'
    }
  })
    .then(r => r.json())
    .then(data => {
      // Fetch reply notifications
      fetch('/dashboard/notifications', {
        credentials: 'same-origin',
        cache: 'no-cache',
        headers: {
          'Cache-Control': 'no-cache',
          'Pragma': 'no-cache'
        }
      })
      .then(r => r.json())
      .then(notificationData => {
        const memoList = document.getElementById('uda-memo-list');
        if (memoList) {
          let html = '';
          
          // Add memos
          if (data.memos && data.memos.length > 0) {
            html += '<div class="uda-section-header">📧 Memos</div>';
            html += data.memos.map(memo => 
              `<a class="uda-dropdown-item" href="${memo.url}">
                <span class="uda-item-title">${memo.subject}</span>
                <span class="uda-item-time">${memo.created_at}</span>
                ${!memo.is_read ? '<span class="uda-dot"></span>' : ''}
              </a>`
            ).join('');
          }
          
          // Add reply notifications
          if (notificationData.notifications && notificationData.notifications.length > 0) {
            html += '<div class="uda-section-header">💬 Reply Notifications</div>';
            html += notificationData.notifications.map(notification => 
              `<a class="uda-dropdown-item" href="${notification.url}">
                <span class="uda-item-title">${notification.title}</span>
                <span class="uda-item-time">${notification.time_ago}</span>
                ${!notification.is_read ? '<span class="uda-dot"></span>' : ''}
              </a>`
            ).join('');
          }
          
          if (html === '') {
            html = '<div class="uda-empty">No notifications yet</div>';
          }
          
          memoList.innerHTML = html;
        }
      })
      .catch(err => {
        console.log('Error refreshing notifications:', err);
        // Fallback to just memos
        const memoList = document.getElementById('uda-memo-list');
        if (memoList && data.memos) {
          if (data.memos.length > 0) {
            memoList.innerHTML = data.memos.map(memo => 
              `<a class="uda-dropdown-item" href="${memo.url}">
                <span class="uda-item-title">${memo.subject}</span>
                <span class="uda-item-time">${memo.created_at}</span>
                ${!memo.is_read ? '<span class="uda-dot"></span>' : ''}
              </a>`
            ).join('');
          } else {
            memoList.innerHTML = '<div class="uda-empty">No memos yet</div>';
          }
        }
      });
    })
    .catch(err => {
      console.log('Error refreshing memo list:', err);
    });
}

const liveClockDateFormatter = new Intl.DateTimeFormat(undefined, {
  weekday: 'long',
  month: 'short',
  day: 'numeric',
  year: 'numeric'
});

const liveClockTimeFormatter = new Intl.DateTimeFormat(undefined, {
  hour: '2-digit',
  minute: '2-digit',
  second: '2-digit'
});

function updateLiveDateTimeWidgets() {
  const now = new Date();
  const dateText = liveClockDateFormatter.format(now);
  const timeText = liveClockTimeFormatter.format(now);
  
  document.querySelectorAll('[data-live-clock]').forEach(clock => {
    const dateEl = clock.querySelector('.live-date');
    const timeEl = clock.querySelector('.live-time');
    
    if (dateEl) {
      dateEl.textContent = dateText;
    }
    if (timeEl) {
      timeEl.textContent = timeText;
    }
  });
}

function startLiveDateTimeTicker() {
  updateLiveDateTimeWidgets();
  if (window.__liveClockInterval) {
    clearInterval(window.__liveClockInterval);
  }
  window.__liveClockInterval = setInterval(updateLiveDateTimeWidgets, 1000);
}

// Handle unified "Mark all as read" button
document.addEventListener('DOMContentLoaded', function(){
  const markAllForm = document.querySelector('.uda-mark-all-form');
  if (markAllForm) {
    markAllForm.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Show loading state
      const button = this.querySelector('.uda-mark-all-btn');
      const originalText = button.innerHTML;
      button.innerHTML = '<span class="uda-mark-all-icon">⏳</span>Marking all as read...';
      button.disabled = true;
      
      // Submit the form
      fetch(this.action, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: new URLSearchParams(new FormData(this))
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Reset button
          button.innerHTML = '<span class="uda-mark-all-icon">✓</span>All marked as read';
          button.style.background = 'linear-gradient(135deg, #10b981 0%, #059669 100%)';
          
          // Refresh the notification list
          refreshMemoList();
          
          // Update badge
          updateNotificationBadge(0, 0);
          
          // Reset button after 2 seconds
          setTimeout(() => {
            button.innerHTML = originalText;
            button.style.background = 'linear-gradient(135deg, #3b82f6 0%, #2563eb 100%)';
            button.disabled = false;
          }, 2000);
        }
      })
      .catch(error => {
        console.error('Error marking all as read:', error);
        button.innerHTML = originalText;
        button.disabled = false;
      });
    });
  }
});

document.addEventListener('DOMContentLoaded', function(){
  initBellAudio();
  startLiveDateTimeTicker();
  
  // Poll immediately on page load
  setTimeout(pollUnread, 100);
  
  // Poll frequently for better responsiveness
  setInterval(pollUnread, 2000);
  
  // Poll when page becomes visible
  document.addEventListener('visibilitychange', function(){
    if (!document.hidden) {
      setTimeout(pollUnread, 50);
    }
  });
  
  // Poll when returning from a memo view - more aggressive
  if (document.referrer && document.referrer.includes('/dashboard/memos/')) {
    setTimeout(pollUnread, 50);
    setTimeout(pollUnread, 500);
    setTimeout(pollUnread, 1000);
  }
  
  // Poll when window regains focus
  window.addEventListener('focus', function(){
    setTimeout(pollUnread, 50);
  });
  
  // Poll when coming back from navigation
  window.addEventListener('pageshow', function(event) {
    setTimeout(pollUnread, 50);
  });
  
  // Poll when user clicks anywhere (indicating activity)
  let lastClickTime = 0;
  document.addEventListener('click', function(){
    const now = Date.now();
    if (now - lastClickTime > 1000) { // Throttle to once per second
      lastClickTime = now;
      setTimeout(pollUnread, 100);
    }
  });
});
</script>

