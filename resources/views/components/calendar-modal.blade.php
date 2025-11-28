<!-- 3D Wall Calendar Modal -->
<div id="calendarModal" class="calendar-modal" style="display: none;">
    <div class="calendar-modal-overlay" onclick="closeCalendarModal()"></div>
    <div class="calendar-modal-content">
        <div class="calendar-modal-header">
            <h2 class="calendar-modal-title">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 8px;">
                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                    <line x1="16" y1="2" x2="16" y2="6"></line>
                    <line x1="8" y1="2" x2="8" y2="6"></line>
                    <line x1="3" y1="10" x2="21" y2="10"></line>
                </svg>
                Calendar & Events
            </h2>
            <button class="calendar-modal-close" onclick="closeCalendarModal()" aria-label="Close calendar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="calendar-modal-body">
            <!-- Month Navigation -->
            <div class="calendar-nav">
                <button class="calendar-nav-btn" onclick="changeMonth(-1)">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    Prev Month
                </button>
                <div class="calendar-month-display" id="calendarMonthDisplay">January 2025</div>
                <button class="calendar-nav-btn" onclick="changeMonth(1)">
                    Next Month
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>

            <!-- 3D Wall Calendar Container -->
            <div class="calendar-wall-container" id="calendarWallContainer">
                <div class="calendar-wall" id="calendarWall">
                    <!-- Days will be dynamically generated here -->
                </div>
            </div>

            <!-- Add Event Form -->
            <div class="calendar-add-form">
                <div class="form-group">
                    <input type="text" id="eventTitle" class="form-input" placeholder="Event title (e.g., Meeting, Appointment)" required>
                </div>
                <div class="form-group">
                    <input type="datetime-local" id="eventDate" class="form-input" required>
                </div>
                <div class="form-group">
                    <textarea id="eventDescription" class="form-textarea" placeholder="Description (optional)" rows="2"></textarea>
                </div>
                <div class="form-group">
                    <select id="eventType" class="form-select">
                        <option value="appointment">Appointment</option>
                        <option value="meeting">Meeting</option>
                        <option value="event">Event</option>
                    </select>
                </div>
                <button class="calendar-add-btn" onclick="addEvent()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Event
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.calendar-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    padding: 20px;
}

.calendar-modal.show {
    opacity: 1;
    visibility: visible;
}

.calendar-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.75);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
}

.calendar-modal-content {
    position: relative;
    background: #ffffff;
    border-radius: 20px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    max-width: 1200px;
    width: 100%;
    max-height: 90vh;
    overflow: hidden;
    transform: scale(0.9) translateY(20px);
    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    border: 1px solid rgba(226, 232, 240, 0.8);
    display: flex;
    flex-direction: column;
}

.calendar-modal.show .calendar-modal-content {
    transform: scale(1) translateY(0);
}

.calendar-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid #e5e7eb;
    background: linear-gradient(135deg, #5f2ded 0%, #7c3aed 100%);
    color: white;
}

.calendar-modal-title {
    display: flex;
    align-items: center;
    font-size: 20px;
    font-weight: 700;
    margin: 0;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-modal-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: white;
}

.calendar-modal-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: scale(1.1);
}

.calendar-modal-body {
    padding: 24px;
    overflow-y: auto;
    flex: 1;
}

.calendar-nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 12px;
}

.calendar-nav-btn {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-nav-btn:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
}

.calendar-month-display {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-wall-container {
    width: 100%;
    overflow: auto;
    margin-bottom: 24px;
    perspective: 1200px;
    min-height: 400px;
    max-height: 500px;
    padding: 20px 0;
}

.calendar-wall {
    margin: 0 auto;
    display: grid;
    grid-template-columns: repeat(7, 160px);
    gap: 12px;
    transform-style: preserve-3d;
    transition: transform 120ms linear;
    padding: 12px;
}

.calendar-day-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px;
    min-height: 120px;
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: all 0.2s;
    transform-style: preserve-3d;
}

.calendar-day-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transform: translateZ(10px);
}

.calendar-day-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 8px;
}

.calendar-day-number {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-day-name {
    font-size: 11px;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: 600;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-day-events {
    position: relative;
    min-height: 60px;
    margin-top: 8px;
}

.calendar-event-dot {
    position: absolute;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 10px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transform: translateZ(20px);
    transition: all 0.2s;
    z-index: 10;
}

.calendar-event-dot:hover {
    transform: translateZ(30px) scale(1.1);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.calendar-event-dot.appointment {
    background: #3b82f6;
}

.calendar-event-dot.meeting {
    background: #10b981;
}

.calendar-event-dot.event {
    background: #f59e0b;
}

.calendar-event-count {
    font-size: 11px;
    color: #6b7280;
    margin-top: 4px;
    font-weight: 600;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-day-card.other-month {
    opacity: 0.4;
    background: #f9fafb;
}

.calendar-day-card.today {
    border-color: #5f2ded;
    border-width: 2px;
    background: linear-gradient(135deg, rgba(95, 45, 237, 0.05) 0%, rgba(124, 58, 237, 0.05) 100%);
}

.calendar-add-form {
    display: grid;
    grid-template-columns: 2fr 1.5fr 1fr auto;
    gap: 12px;
    align-items: end;
    padding: 20px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-input,
.form-textarea,
.form-select {
    padding: 10px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
    transition: all 0.2s;
    background: white;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
    outline: none;
    border-color: #5f2ded;
    box-shadow: 0 0 0 3px rgba(95, 45, 237, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 60px;
}

.calendar-add-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, #5f2ded 0%, #7c3aed 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
    white-space: nowrap;
}

.calendar-add-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(95, 45, 237, 0.3);
}

.calendar-add-btn:active {
    transform: translateY(0);
}

/* Event Popover */
.event-popover {
    position: absolute;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    z-index: 1000;
    min-width: 200px;
    max-width: 300px;
    display: none;
}

.event-popover.show {
    display: block;
    animation: popoverFadeIn 0.2s ease;
}

@keyframes popoverFadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.event-popover-title {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 4px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.event-popover-date {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 8px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.event-popover-description {
    font-size: 12px;
    color: #374151;
    margin-bottom: 8px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.event-popover-actions {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid #e5e7eb;
}

.event-popover-delete {
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 6px;
    padding: 6px 12px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.event-popover-delete:hover {
    background: #dc2626;
}

/* Responsive */
@media (max-width: 1024px) {
    .calendar-wall {
        grid-template-columns: repeat(7, 120px);
    }
    
    .calendar-day-card {
        min-height: 100px;
        padding: 8px;
    }
    
    .calendar-add-form {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .calendar-modal-content {
        max-width: 100%;
        max-height: 95vh;
    }
    
    .calendar-wall {
        grid-template-columns: repeat(7, 100px);
        gap: 8px;
    }
    
    .calendar-day-card {
        min-height: 80px;
        padding: 6px;
    }
    
    .calendar-event-dot {
        width: 20px;
        height: 20px;
        font-size: 8px;
    }
}
</style>

<script>
let currentDate = new Date();
let calendarEvents = [];
let isDragging = false;
let dragStart = { x: 0, y: 0 };
let tiltX = 18;
let tiltY = 0;
let activePopover = null;

// Open calendar modal
function openCalendarModal() {
    const modal = document.getElementById('calendarModal');
    modal.style.display = 'flex';
    setTimeout(() => {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
    }, 10);
    loadEvents();
    renderCalendar();
    setTimeout(() => {
        init3DInteractions();
    }, 100);
}

// Close calendar modal
function closeCalendarModal() {
    const modal = document.getElementById('calendarModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        document.body.style.overflow = '';
    }, 300);
    if (activePopover) {
        activePopover.style.display = 'none';
        activePopover = null;
    }
}

// Load events from API
async function loadEvents() {
    try {
        const response = await fetch('{{ route("dashboard.calendar.events") }}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        });
        const data = await response.json();
        calendarEvents = data;
        renderCalendar();
    } catch (error) {
        console.error('Error loading events:', error);
    }
}

// Change month
function changeMonth(direction) {
    currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + direction, 1);
    renderCalendar();
}

// Render calendar
function renderCalendar() {
    const wall = document.getElementById('calendarWall');
    const monthDisplay = document.getElementById('calendarMonthDisplay');
    
    // Update month display
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    monthDisplay.textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
    
    // Get first day of month and number of days
    const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);
    const lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
    const daysInMonth = lastDay.getDate();
    const startingDayOfWeek = firstDay.getDay();
    
    // Get previous month's days to fill the grid
    const prevMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, 0);
    const daysInPrevMonth = prevMonth.getDate();
    
    wall.innerHTML = '';
    
    // Add previous month's trailing days
    for (let i = startingDayOfWeek - 1; i >= 0; i--) {
        const day = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1, daysInPrevMonth - i);
        wall.appendChild(createDayCard(day, true));
    }
    
    // Add current month's days
    for (let day = 1; day <= daysInMonth; day++) {
        const date = new Date(currentDate.getFullYear(), currentDate.getMonth(), day);
        wall.appendChild(createDayCard(date, false));
    }
    
    // Add next month's leading days to complete the grid
    const totalCells = wall.children.length;
    const remainingCells = 42 - totalCells; // 6 rows * 7 days
    for (let day = 1; day <= remainingCells; day++) {
        const date = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, day);
        wall.appendChild(createDayCard(date, true));
    }
    
    // Apply 3D effect
    apply3DEffect();
}

// Create day card
function createDayCard(date, isOtherMonth) {
    const card = document.createElement('div');
    card.className = 'calendar-day-card';
    if (isOtherMonth) card.classList.add('other-month');
    
    const today = new Date();
    if (date.toDateString() === today.toDateString() && !isOtherMonth) {
        card.classList.add('today');
    }
    
    const dayEvents = getEventsForDay(date);
    const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    
    card.innerHTML = `
        <div class="calendar-day-header">
            <span class="calendar-day-number">${date.getDate()}</span>
            <span class="calendar-day-name">${dayNames[date.getDay()]}</span>
        </div>
        <div class="calendar-day-events" id="events-${date.toISOString()}">
            ${renderDayEvents(dayEvents, date)}
        </div>
        <div class="calendar-event-count">${dayEvents.length} event(s)</div>
    `;
    
    return card;
}

// Get events for a specific day
function getEventsForDay(date) {
    const dateStr = date.toISOString().split('T')[0];
    return calendarEvents.filter(event => {
        const eventDate = new Date(event.date);
        return eventDate.toISOString().split('T')[0] === dateStr;
    });
}

// Render events for a day
function renderDayEvents(events, date) {
    if (events.length === 0) return '';
    
    const panelWidth = 160;
    const gap = 12;
    const availableWidth = panelWidth - 24;
    
    return events.map((event, index) => {
        const left = 8 + (index * 34) % (availableWidth - 40);
        const top = 8 + Math.floor((index * 34) / (availableWidth - 40)) * 28;
        const colorMap = {
            'appointment': '#3b82f6',
            'meeting': '#10b981',
            'event': '#f59e0b'
        };
        const bgColor = event.color || colorMap[event.type] || '#3b82f6';
        
        return `
            <div class="calendar-event-dot ${event.type}" 
                 style="left: ${left}px; top: ${top}px; background: ${bgColor};"
                 onclick="showEventPopover(event, ${event.id}, '${event.title}', '${event.date}', '${(event.description || '').replace(/'/g, "\\'")}', '${event.type}')"
                 onmouseenter="showEventTooltip(event, '${event.title}')">
                •
            </div>
        `;
    }).join('');
}

// Show event popover
function showEventPopover(e, eventId, title, date, description, type) {
    e.stopPropagation();
    
    // Close existing popover
    if (activePopover) {
        activePopover.style.display = 'none';
    }
    
    const popover = document.createElement('div');
    popover.className = 'event-popover show';
    popover.style.position = 'fixed';
    popover.style.left = e.pageX + 10 + 'px';
    popover.style.top = e.pageY + 10 + 'px';
    
    const eventDate = new Date(date);
    const formattedDate = eventDate.toLocaleDateString('en-US', { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
    
    popover.innerHTML = `
        <div class="event-popover-title">${title}</div>
        <div class="event-popover-date">${formattedDate}</div>
        ${description ? `<div class="event-popover-description">${description}</div>` : ''}
        <div class="event-popover-actions">
            <button class="event-popover-delete" onclick="deleteEvent(${eventId})">Delete</button>
        </div>
    `;
    
    document.body.appendChild(popover);
    activePopover = popover;
    
    // Close on click outside
    setTimeout(() => {
        document.addEventListener('click', function closePopover(e) {
            if (!popover.contains(e.target) && !e.target.closest('.calendar-event-dot')) {
                popover.style.display = 'none';
                document.body.removeChild(popover);
                document.removeEventListener('click', closePopover);
                activePopover = null;
            }
        });
    }, 10);
}

// Show event tooltip on hover
function showEventTooltip(e, title) {
    // Simple tooltip could be added here if needed
}

// Apply 3D effect
function apply3DEffect() {
    const wall = document.getElementById('calendarWall');
    const rowCount = Math.ceil(wall.children.length / 7);
    const wallCenterRow = (rowCount - 1) / 2;
    
    Array.from(wall.children).forEach((card, idx) => {
        const row = Math.floor(idx / 7);
        const rowOffset = row - wallCenterRow;
        const z = Math.max(-80, 40 - Math.abs(rowOffset) * 20);
        card.style.transform = `translateZ(${z}px)`;
        card.style.zIndex = Math.round(100 - Math.abs(rowOffset));
    });
    
    updateWallTransform();
}

// Update wall transform
function updateWallTransform() {
    const wall = document.getElementById('calendarWall');
    wall.style.transform = `rotateX(${tiltX}deg) rotateY(${tiltY}deg)`;
}

// Initialize 3D interaction handlers
let interactionHandlersInitialized = false;
function init3DInteractions() {
    if (interactionHandlersInitialized) return;
    
    const wallContainer = document.getElementById('calendarWallContainer');
    if (!wallContainer) return;
    
    wallContainer.addEventListener('wheel', (e) => {
        e.preventDefault();
        tiltX = Math.max(0, Math.min(50, tiltX + e.deltaY * 0.02));
        tiltY = Math.max(-45, Math.min(45, tiltY + e.deltaX * 0.05));
        updateWallTransform();
    });
    
    wallContainer.addEventListener('pointerdown', (e) => {
        isDragging = true;
        dragStart = { x: e.clientX, y: e.clientY };
        wallContainer.setPointerCapture(e.pointerId);
    });
    
    wallContainer.addEventListener('pointermove', (e) => {
        if (!isDragging) return;
        const dx = e.clientX - dragStart.x;
        const dy = e.clientY - dragStart.y;
        tiltY = Math.max(-60, Math.min(60, tiltY + dx * 0.1));
        tiltX = Math.max(0, Math.min(60, tiltX - dy * 0.1));
        dragStart = { x: e.clientX, y: e.clientY };
        updateWallTransform();
    });
    
    wallContainer.addEventListener('pointerup', () => {
        isDragging = false;
    });
    
    wallContainer.addEventListener('pointercancel', () => {
        isDragging = false;
    });
    
    interactionHandlersInitialized = true;
}

// Add event
async function addEvent() {
    const title = document.getElementById('eventTitle').value.trim();
    const date = document.getElementById('eventDate').value;
    const description = document.getElementById('eventDescription').value.trim();
    const type = document.getElementById('eventType').value;
    
    if (!title || !date) {
        alert('Please fill in the event title and date.');
        return;
    }
    
    try {
        const response = await fetch('{{ route("dashboard.calendar.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                title,
                date,
                description,
                event_type: type,
            }),
        });
        
        const data = await response.json();
        
        if (data.success) {
            // Reset form
            document.getElementById('eventTitle').value = '';
            document.getElementById('eventDate').value = '';
            document.getElementById('eventDescription').value = '';
            document.getElementById('eventType').value = 'appointment';
            
            // Reload events
            await loadEvents();
        } else {
            alert('Error adding event. Please try again.');
        }
    } catch (error) {
        console.error('Error adding event:', error);
        alert('Error adding event. Please try again.');
    }
}

// Delete event
async function deleteEvent(eventId) {
    if (!confirm('Are you sure you want to delete this event?')) {
        return;
    }
    
    try {
        const response = await fetch(`{{ route("dashboard.calendar.destroy", ":id") }}`.replace(':id', eventId), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
        });
        
        const data = await response.json();
        
        if (data.success) {
            if (activePopover) {
                activePopover.style.display = 'none';
                document.body.removeChild(activePopover);
                activePopover = null;
            }
            await loadEvents();
        } else {
            alert('Error deleting event. Please try again.');
        }
    } catch (error) {
        console.error('Error deleting event:', error);
        alert('Error deleting event. Please try again.');
    }
}

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeCalendarModal();
    }
});
</script>

