<!-- 3D Wall Calendar Modal -->
<div id="calendarModal" class="calendar-modal" style="display: none;">
    <div class="calendar-modal-overlay" onclick="closeCalendarModal()"></div>
    <div class="calendar-modal-content">
        <div class="calendar-modal-header">
            <!-- Month Navigation in Header -->
            <div class="calendar-nav-header" id="calendarNavHeader">
                <button class="calendar-nav-btn-header" onclick="changeMonth(-1)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                    <span>Prev Month</span>
                </button>
                <div class="calendar-month-display-header" id="calendarMonthDisplay">January 2025</div>
                <button class="calendar-nav-btn-header" onclick="changeMonth(1)">
                    <span>Next Month</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
            <button class="calendar-modal-close" onclick="closeCalendarModal()" aria-label="Close calendar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>

        <div class="calendar-modal-body">

            <!-- 3D Wall Calendar Container -->
            <div class="calendar-wall-container" id="calendarWallContainer">
                <div class="calendar-wall" id="calendarWall">
                    <!-- Days will be dynamically generated here -->
                </div>
            </div>

            <!-- Hamburger Sidebar (shown when calendar is collapsed) -->
            <div class="calendar-hamburger-sidebar" id="calendarHamburgerSidebar" style="display: none;">
                <button class="calendar-hamburger-btn" id="calendarHamburgerBtn" onclick="expandCalendar()" aria-label="Show calendar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Vertical Separator -->
            <div class="calendar-sidebar-separator" id="calendarSidebarSeparator" style="display: none;"></div>

            <!-- Add Event Form -->
            <div class="calendar-add-form" id="calendarAddForm" style="display: none;">
                <h3 class="form-title">Add New Event</h3>
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Event Title</label>
                        <input type="text" id="eventTitle" class="form-input" placeholder="e.g., Meeting, Appointment" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Date & Time</label>
                        <input type="datetime-local" id="eventDate" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Type</label>
                        <select id="eventType" class="form-select">
                            <option value="appointment">Appointment</option>
                            <option value="meeting">Meeting</option>
                            <option value="event">Event</option>
                        </select>
                    </div>
                    <div class="form-group form-group-full">
                        <label class="form-label">Description (optional)</label>
                        <textarea id="eventDescription" class="form-textarea" placeholder="Add event description..." rows="2"></textarea>
                    </div>
                </div>
                <div class="form-actions">
                    <button class="calendar-add-btn" onclick="addEvent()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Event
                    </button>
                    <button class="calendar-cancel-btn" onclick="resetEventForm()">
                        Cancel
                    </button>
                </div>
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
    max-width: 1100px;
    width: 100%;
    max-height: 99vh;
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
    justify-content: center;
    padding: 16px 24px;
    border-bottom: 1px solid #e5e7eb;
    background: #f8f9fa;
    color: #111827;
    position: relative;
}

.calendar-nav-header {
    display: flex;
    align-items: center;
    gap: 20px;
    justify-content: center;
}

.calendar-nav-btn-header {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    cursor: pointer;
    transition: all 0.2s;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-nav-btn-header:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    transform: translateY(-1px);
}

.calendar-month-display-header {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
    min-width: 180px;
    text-align: center;
}

.calendar-hamburger-sidebar {
    width: 80px;
    min-width: 80px;
    background: #f8f9fa;
    display: flex;
    align-items: flex-start;
    justify-content: center;
    padding-top: 20px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
    transform: translateX(-100px);
    flex-shrink: 0;
    align-self: stretch;
    min-height: 100%;
}

.calendar-hamburger-sidebar.show {
    opacity: 1;
    transform: translateX(0);
}

.calendar-hamburger-btn {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    color: #6b7280;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
}

.calendar-hamburger-btn:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
    color: #111827;
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.12);
}

.calendar-sidebar-separator {
    width: 1px;
    min-width: 1px;
    background: #e5e7eb;
    opacity: 0;
    transition: opacity 0.3s ease;
    flex-shrink: 0;
    align-self: stretch;
    min-height: 100%;
}

.calendar-sidebar-separator.show {
    opacity: 1;
}

.calendar-modal-close {
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    color: #6b7280;
    position: absolute;
    right: 24px;
}

.calendar-modal-close:hover {
    background: #e5e7eb;
    border-color: #d1d5db;
    color: #111827;
    transform: scale(1.1);
}

.calendar-modal-body {
    padding: 12px 20px 20px 20px;
    overflow-y: auto;
    overflow-x: hidden;
    flex: 1;
    display: flex;
    flex-direction: column;
    min-height: 0;
    position: relative;
}

.calendar-modal-body.with-sidebar {
    flex-direction: row;
    padding: 20px;
    gap: 0;
}


.calendar-wall-container {
    width: 100%;
    overflow: visible;
    margin: 5px auto 10px;
    perspective: none;
    min-height: 520px;
    max-height: 650px;
    padding: 8px 20px 30px 20px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    position: relative;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 1;
    transform: scale(1) translateY(0);
}

.calendar-wall-container.collapsed {
    width: 0;
    height: 0;
    min-height: 0;
    max-height: 0;
    padding: 0;
    margin: 0;
    opacity: 0;
    transform: scale(0.1) translateY(-200px) translateX(-45vw);
    overflow: hidden;
    pointer-events: none;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.calendar-wall.collapsed {
    transform: scale(0.1);
    opacity: 0;
}

.calendar-nav-header {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 1;
    transform: translateX(0);
}

.calendar-nav-header.hidden {
    opacity: 0;
    transform: translateX(-20px);
    pointer-events: none;
}

.calendar-wall-container::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.calendar-wall-container::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.calendar-wall-container::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.calendar-wall-container::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.calendar-wall {
    display: grid;
    grid-template-columns: repeat(7, 100px);
    gap: 8px;
    transform-style: flat;
    transform: none !important;
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 5px 8px 20px 8px;
    width: fit-content;
    margin: 0;
    opacity: 1;
}

.calendar-wall.collapsed {
    transform: scale(0.1) !important;
    opacity: 0;
}

.calendar-day-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 8px;
    min-height: 75px;
    position: relative;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.2s;
    transform-style: flat;
    transform: none !important;
}

.calendar-day-card:hover {
    box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
    transform: none !important;
}

.calendar-day-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}

.calendar-day-number {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-day-name {
    font-size: 9px;
    color: #6b7280;
    text-transform: uppercase;
    font-weight: 600;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-day-events {
    position: relative;
    min-height: 40px;
    margin-top: 4px;
}

.calendar-event-dot {
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 8px;
    font-weight: 700;
    cursor: pointer;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
    transform: none;
    transition: box-shadow 0.2s, scale 0.2s;
    z-index: 10;
}

.calendar-event-dot:hover {
    transform: scale(1.1);
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
    font-size: 9px;
    color: #6b7280;
    margin-top: 2px;
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
    padding: 24px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    margin-top: 0;
    margin-left: 0;
    margin-right: 0;
    opacity: 0;
    transform: translateY(20px) scale(0.95);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    display: none;
    flex: 1;
    width: 100%;
    max-width: none;
}

.calendar-add-form.show {
    display: block;
    opacity: 1;
    transform: translateY(0) scale(1);
    animation: formSlideIn 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes formSlideIn {
    from {
        opacity: 0;
        transform: translateY(30px) scale(0.9);
    }
    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.form-title {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 20px 0;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.form-grid {
    display: grid;
    grid-template-columns: 2fr 1.5fr 1fr;
    gap: 16px;
    margin-bottom: 20px;
}

.form-group-full {
    grid-column: 1 / -1;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
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

.form-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
}

.calendar-cancel-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: white;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
}

.calendar-cancel-btn:hover {
    background: #f3f4f6;
    border-color: #d1d5db;
}

.calendar-day-card {
    cursor: pointer;
}

.calendar-day-card.clickable {
    cursor: pointer;
}

.calendar-day-card.clickable:hover {
    background: #f0f9ff;
    border-color: #5f2ded;
}

.calendar-day-card.past-date {
    cursor: not-allowed;
    opacity: 0.6;
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
        grid-template-columns: repeat(7, 90px);
        gap: 6px;
    }
    
    .calendar-day-card {
        min-height: 70px;
        padding: 6px;
    }
    
    .calendar-add-form .form-grid {
        grid-template-columns: 1fr;
    }
    
    .calendar-nav-header {
        gap: 12px;
    }
    
    .calendar-nav-btn-header {
        padding: 6px 12px;
        font-size: 12px;
    }
    
    .calendar-month-display-header {
        font-size: 16px;
        min-width: 140px;
    }
}

@media (max-width: 768px) {
    .calendar-modal-content {
        max-width: 100%;
        max-height: 95vh;
    }
    
    .calendar-modal-header {
        flex-direction: column;
        gap: 12px;
        align-items: center;
    }
    
    .calendar-nav-header {
        justify-content: center;
    }
    
    .calendar-modal-close {
        position: absolute;
        right: 16px;
        top: 16px;
    }
    
    .calendar-nav-btn-header span {
        display: none;
    }
    
    .calendar-month-display-header {
        font-size: 16px;
        min-width: auto;
    }
    
    .calendar-wall {
        grid-template-columns: repeat(7, 80px);
        gap: 6px;
    }
    
    .calendar-day-card {
        min-height: 65px;
        padding: 5px;
    }
    
    .calendar-event-dot {
        width: 18px;
        height: 18px;
        font-size: 7px;
    }
    
    .calendar-day-number {
        font-size: 12px;
    }
    
    .calendar-day-name {
        font-size: 8px;
    }
    
    .calendar-add-form .form-grid {
        grid-template-columns: 1fr;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .calendar-add-btn,
    .calendar-cancel-btn {
        width: 100%;
        justify-content: center;
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
    
    // Ensure calendar is expanded and form is hidden
    const form = document.getElementById('calendarAddForm');
    const container = document.getElementById('calendarWallContainer');
    const wall = document.getElementById('calendarWall');
    const navHeader = document.getElementById('calendarNavHeader');
    const sidebar = document.getElementById('calendarHamburgerSidebar');
    const separator = document.getElementById('calendarSidebarSeparator');
    const modalBody = document.querySelector('.calendar-modal-body');
    
    if (form) {
        form.style.display = 'none';
        form.classList.remove('show');
    }
    
    if (container) {
        container.classList.remove('collapsed');
    }
    
    if (wall) {
        wall.classList.remove('collapsed');
    }
    
    if (navHeader) {
        navHeader.classList.remove('hidden');
    }
    
    if (sidebar) {
        sidebar.style.display = 'none';
        sidebar.classList.remove('show');
    }
    
    if (separator) {
        separator.style.display = 'none';
        separator.classList.remove('show');
    }
    
    if (modalBody) {
        modalBody.classList.remove('with-sidebar');
    }
    
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
    today.setHours(0, 0, 0, 0);
    const cardDate = new Date(date);
    cardDate.setHours(0, 0, 0, 0);
    
    // Check if date is in the past
    const isPastDate = cardDate < today;
    
    if (cardDate.toDateString() === today.toDateString() && !isOtherMonth) {
        card.classList.add('today');
    }
    
    // Make clickable if not past date and not other month
    if (!isPastDate && !isOtherMonth) {
        card.classList.add('clickable');
        card.onclick = (e) => {
            // Don't trigger if clicking on event dots
            if (!e.target.closest('.calendar-event-dot')) {
                handleDateClick(date);
            }
        };
    } else if (isPastDate) {
        card.classList.add('past-date');
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

// Handle date click - collapse calendar and show form
function handleDateClick(date) {
    // Format date for datetime-local input (YYYY-MM-DDTHH:mm)
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, '0');
    const day = String(date.getDate()).padStart(2, '0');
    const dateStr = `${year}-${month}-${day}T09:00`; // Default to 9 AM
    
    // Reset form fields
    document.getElementById('eventTitle').value = '';
    document.getElementById('eventDate').value = dateStr;
    document.getElementById('eventDescription').value = '';
    document.getElementById('eventType').value = 'appointment';
    
    // Collapse calendar
    collapseCalendar();
    
    // Show the form after animation
    setTimeout(() => {
        const form = document.getElementById('calendarAddForm');
        form.style.display = 'block';
        setTimeout(() => {
            form.classList.add('show');
            // Focus on title input
            document.getElementById('eventTitle').focus();
        }, 50);
    }, 300);
}

// Collapse calendar into hamburger
function collapseCalendar() {
    const container = document.getElementById('calendarWallContainer');
    const wall = document.getElementById('calendarWall');
    const navHeader = document.getElementById('calendarNavHeader');
    const sidebar = document.getElementById('calendarHamburgerSidebar');
    const separator = document.getElementById('calendarSidebarSeparator');
    const modalBody = document.querySelector('.calendar-modal-body');
    
    if (container && navHeader) {
        // Add collapsed class
        container.classList.add('collapsed');
        if (wall) {
            wall.classList.add('collapsed');
        }
        navHeader.classList.add('hidden');
        
        // Show sidebar and separator with animation
        setTimeout(() => {
            if (sidebar) {
                sidebar.style.display = 'flex';
                setTimeout(() => {
                    sidebar.classList.add('show');
                }, 50);
            }
            
            if (separator) {
                separator.style.display = 'block';
                setTimeout(() => {
                    separator.classList.add('show');
                }, 100);
            }
            
            // Update modal body layout
            if (modalBody) {
                modalBody.classList.add('with-sidebar');
            }
        }, 250);
    }
}

// Expand calendar from hamburger
function expandCalendar() {
    const container = document.getElementById('calendarWallContainer');
    const wall = document.getElementById('calendarWall');
    const navHeader = document.getElementById('calendarNavHeader');
    const sidebar = document.getElementById('calendarHamburgerSidebar');
    const separator = document.getElementById('calendarSidebarSeparator');
    const form = document.getElementById('calendarAddForm');
    const modalBody = document.querySelector('.calendar-modal-body');
    
    if (container && navHeader) {
        // Hide form first
        if (form) {
            form.classList.remove('show');
            setTimeout(() => {
                form.style.display = 'none';
            }, 300);
        }
        
        // Hide sidebar and separator with animation
        if (sidebar) {
            sidebar.classList.remove('show');
            setTimeout(() => {
                sidebar.style.display = 'none';
            }, 300);
        }
        
        if (separator) {
            separator.classList.remove('show');
            setTimeout(() => {
                separator.style.display = 'none';
            }, 250);
        }
        
        // Update modal body layout
        if (modalBody) {
            modalBody.classList.remove('with-sidebar');
        }
        
        // Remove collapsed class
        container.classList.remove('collapsed');
        if (wall) {
            wall.classList.remove('collapsed');
        }
        navHeader.classList.remove('hidden');
    }
}

// Reset event form and expand calendar
function resetEventForm() {
    document.getElementById('eventTitle').value = '';
    document.getElementById('eventDate').value = '';
    document.getElementById('eventDescription').value = '';
    document.getElementById('eventType').value = 'appointment';
    
    // Expand calendar back
    expandCalendar();
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
    
    const panelWidth = 100;
    const gap = 8;
    const availableWidth = panelWidth - 16;
    
    return events.map((event, index) => {
        const left = 4 + (index * 24) % (availableWidth - 30);
        const top = 4 + Math.floor((index * 24) / (availableWidth - 30)) * 22;
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

// Apply 3D effect - DISABLED
function apply3DEffect() {
    const wall = document.getElementById('calendarWall');
    if (!wall) return;
    
    // Disable 3D transforms - keep calendar flat
    Array.from(wall.children).forEach((card) => {
        card.style.transform = 'none';
        card.style.zIndex = '1';
    });
    
    // Keep wall flat
    wall.style.transform = 'none';
}

// Update wall transform - DISABLED
function updateWallTransform() {
    const wall = document.getElementById('calendarWall');
    if (wall) {
        wall.style.transform = 'none';
    }
}

// Initialize 3D interaction handlers - DISABLED
let interactionHandlersInitialized = false;
function init3DInteractions() {
    // Disabled - no 3D interactions
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
            resetEventForm();
            
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

