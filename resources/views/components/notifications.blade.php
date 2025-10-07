<!-- Notification Bell -->
<div class="notification-bell" id="notificationBell">
    <div class="bell-icon" onclick="toggleNotifications()">
        <i class="icofont-bell"></i>
        <span class="notification-count" id="notificationCount" style="display: none;">0</span>
    </div>
    
    <!-- Notification Dropdown -->
    <div class="notification-dropdown" id="notificationDropdown" style="display: none;">
        <div class="notification-header">
            <h6>Notifications</h6>
            <button onclick="markAllAsRead()" class="btn btn-sm btn-outline-primary">Mark All Read</button>
        </div>
        <div class="notification-list" id="notificationList">
            <!-- Notifications will be loaded here -->
        </div>
    </div>
</div>

<!-- Audio element for notification sound -->
<audio id="notificationSound" preload="auto">
    <!-- Fallback for browsers that don't support Web Audio API -->
</audio>

<style>
.notification-bell {
    position: relative;
    display: inline-block;
}

.bell-icon {
    position: relative;
    cursor: pointer;
    padding: 8px;
    border-radius: 50%;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.bell-icon:hover {
    background: #e9ecef;
    transform: scale(1.1);
}

.bell-icon i {
    font-size: 20px;
    color: #6c757d;
}

.notification-count {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #dc3545;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    font-size: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.notification-dropdown {
    position: absolute;
    top: 100%;
    right: 0;
    width: 350px;
    max-height: 400px;
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    z-index: 1000;
    overflow: hidden;
}

.notification-header {
    padding: 15px;
    border-bottom: 1px solid #dee2e6;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #f8f9fa;
}

.notification-header h6 {
    margin: 0;
    font-weight: 600;
}

.notification-list {
    max-height: 300px;
    overflow-y: auto;
}

.notification-item {
    padding: 12px 15px;
    border-bottom: 1px solid #f8f9fa;
    cursor: pointer;
    transition: background 0.2s ease;
}

.notification-item:hover {
    background: #f8f9fa;
}

.notification-item.unread {
    background: #e3f2fd;
    border-left: 4px solid #2196f3;
}

.notification-item.unread:hover {
    background: #bbdefb;
}

.notification-content {
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: white;
    flex-shrink: 0;
}

.notification-icon.reply {
    background: #28a745;
}

.notification-icon.memo {
    background: #007bff;
}

.notification-text {
    flex: 1;
}

.notification-title {
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 2px;
    color: #333;
}

.notification-message {
    font-size: 13px;
    color: #666;
    margin-bottom: 4px;
}

.notification-time {
    font-size: 12px;
    color: #999;
}

.notification-actions {
    display: flex;
    gap: 5px;
    margin-top: 8px;
}

.notification-actions .btn {
    font-size: 11px;
    padding: 4px 8px;
}

/* Animation for new notifications */
@keyframes slideInRight {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.notification-item.new {
    animation: slideInRight 0.3s ease;
}

/* Responsive */
@media (max-width: 768px) {
    .notification-dropdown {
        width: 300px;
        right: -50px;
    }
}
</style>

<script>
let notificationCount = 0;
let notifications = [];

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();
    
    // Check for new notifications every 30 seconds
    setInterval(checkForNewNotifications, 30000);
});

function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    if (dropdown.style.display === 'none') {
        dropdown.style.display = 'block';
        loadNotifications();
    } else {
        dropdown.style.display = 'none';
    }
}

function loadNotifications() {
    console.log('Loading notifications...');
    fetch('/dashboard/notifications')
        .then(response => {
            console.log('Notifications response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('Notifications data:', data);
            notifications = data.notifications || [];
            updateNotificationDisplay();
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
}

function updateNotificationDisplay() {
    const count = notifications.filter(n => !n.is_read).length;
    const countElement = document.getElementById('notificationCount');
    const listElement = document.getElementById('notificationList');
    
    // Update count
    if (count > 0) {
        countElement.textContent = count;
        countElement.style.display = 'flex';
    } else {
        countElement.style.display = 'none';
    }
    
    // Update list
    listElement.innerHTML = '';
    if (notifications.length === 0) {
        listElement.innerHTML = '<div class="notification-item"><div class="notification-text text-center text-muted">No notifications</div></div>';
        return;
    }
    
    notifications.forEach(notification => {
        const item = document.createElement('div');
        item.className = `notification-item ${!notification.is_read ? 'unread' : ''}`;
        item.onclick = () => handleNotificationClick(notification);
        
        const iconClass = notification.type === 'reply' ? 'reply' : 'memo';
        const iconSymbol = notification.type === 'reply' ? '💬' : '📧';
        
        item.innerHTML = `
            <div class="notification-content">
                <div class="notification-icon ${iconClass}">${iconSymbol}</div>
                <div class="notification-text">
                    <div class="notification-title">${notification.title}</div>
                    <div class="notification-message">${notification.message}</div>
                    <div class="notification-time">${notification.time_ago}</div>
                </div>
            </div>
        `;
        
        listElement.appendChild(item);
    });
}

function handleNotificationClick(notification) {
    // Mark as read
    markNotificationAsRead(notification.id);
    
    // Navigate to replies page
    if (notification.type === 'reply') {
        window.location.href = notification.url;
    }
}

function markNotificationAsRead(notificationId) {
    console.log('Marking notification as read:', notificationId);
    fetch(`/dashboard/notifications/${notificationId}/mark-read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            loadNotifications(); // Reload to update display
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    fetch('/dashboard/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            loadNotifications();
        }
    });
}

function checkForNewNotifications() {
    fetch('/dashboard/notifications/check')
        .then(response => response.json())
        .then(data => {
            if (data.has_new) {
                playNotificationSound();
                loadNotifications();
            }
        });
}

function playNotificationSound() {
    try {
        // Create Web Audio API context
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Create oscillator for notification sound
        const oscillator = audioContext.createOscillator();
        const gainNode = audioContext.createGain();
        
        // Connect nodes
        oscillator.connect(gainNode);
        gainNode.connect(audioContext.destination);
        
        // Set frequency and type
        oscillator.frequency.setValueAtTime(800, audioContext.currentTime);
        oscillator.type = 'sine';
        
        // Set volume envelope
        gainNode.gain.setValueAtTime(0, audioContext.currentTime);
        gainNode.gain.linearRampToValueAtTime(0.3, audioContext.currentTime + 0.1);
        gainNode.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.3);
        
        // Play the sound
        oscillator.start(audioContext.currentTime);
        oscillator.stop(audioContext.currentTime + 0.3);
        
        // Second beep for notification effect
        setTimeout(() => {
            const oscillator2 = audioContext.createOscillator();
            const gainNode2 = audioContext.createGain();
            
            oscillator2.connect(gainNode2);
            gainNode2.connect(audioContext.destination);
            
            oscillator2.frequency.setValueAtTime(1000, audioContext.currentTime);
            oscillator2.type = 'sine';
            
            gainNode2.gain.setValueAtTime(0, audioContext.currentTime);
            gainNode2.gain.linearRampToValueAtTime(0.2, audioContext.currentTime + 0.1);
            gainNode2.gain.linearRampToValueAtTime(0, audioContext.currentTime + 0.2);
            
            oscillator2.start(audioContext.currentTime);
            oscillator2.stop(audioContext.currentTime + 0.2);
        }, 150);
        
    } catch (error) {
        console.log('Could not play notification sound:', error);
        // Fallback to browser notification sound
        try {
            const audio = document.getElementById('notificationSound');
            if (audio) {
                audio.play().catch(e => console.log('Fallback audio failed:', e));
            }
        } catch (e) {
            console.log('No audio fallback available');
        }
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    const bell = document.getElementById('notificationBell');
    const dropdown = document.getElementById('notificationDropdown');
    
    if (!bell.contains(event.target)) {
        dropdown.style.display = 'none';
    }
});
</script>
