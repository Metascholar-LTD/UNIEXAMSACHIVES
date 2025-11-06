@php
    // Don't show for super admins
    if (auth()->check() && auth()->user()->isSuperAdmin()) {
        $upcomingMaintenance = null;
    } else {
        // Get upcoming maintenance that should display banner
        $upcomingMaintenance = \App\Models\SystemMaintenanceLog::where('display_banner', true)
            ->whereIn('status', ['planned', 'notified'])
            ->where('scheduled_start', '>', now())
            ->where(function($query) {
                $query->whereNull('banner_display_from')
                      ->orWhere('banner_display_from', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('banner_display_until')
                      ->orWhere('banner_display_until', '>=', now());
            })
            ->orderBy('scheduled_start', 'asc')
            ->first();
    }
@endphp

@if($upcomingMaintenance)
<!-- Maintenance Countdown Modal -->
<div id="maintenance-countdown-modal" class="maintenance-modal" data-start-time="{{ $upcomingMaintenance->scheduled_start->timestamp * 1000 }}">
    <div class="maintenance-modal-overlay"></div>
    <div class="maintenance-modal-content maintenance-impact-{{ $upcomingMaintenance->impact_level }}">
        <button class="maintenance-modal-close">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <div class="maintenance-modal-header">
            <div class="maintenance-modal-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"></path>
                </svg>
            </div>
            <h2 class="maintenance-modal-title">Scheduled Maintenance</h2>
            <p class="maintenance-modal-subtitle">System maintenance is scheduled</p>
        </div>

        <div class="maintenance-modal-body">
            <div class="maintenance-info-card">
                <div class="maintenance-info-item">
                    <span class="maintenance-info-label">Maintenance Title</span>
                    <span class="maintenance-info-value">{{ $upcomingMaintenance->title }}</span>
                </div>
                
                @if($upcomingMaintenance->banner_message ?? $upcomingMaintenance->description)
                <div class="maintenance-info-item">
                    <span class="maintenance-info-label">Description</span>
                    <span class="maintenance-info-value">{{ $upcomingMaintenance->banner_message ?? $upcomingMaintenance->description }}</span>
                </div>
                @endif

                <div class="maintenance-info-row">
                    <div class="maintenance-info-item">
                        <span class="maintenance-info-label">Start</span>
                        <span class="maintenance-info-value">{{ $upcomingMaintenance->scheduled_start->format('M d, Y') }}<br>{{ $upcomingMaintenance->scheduled_start->format('h:i A') }}</span>
                    </div>
                    <div class="maintenance-info-item">
                        <span class="maintenance-info-label">End</span>
                        <span class="maintenance-info-value">{{ $upcomingMaintenance->scheduled_end->format('M d, Y') }}<br>{{ $upcomingMaintenance->scheduled_end->format('h:i A') }}</span>
                    </div>
                </div>

                <div class="maintenance-info-item" style="margin-top: 0.5rem;">
                    <span class="maintenance-info-label">Impact</span>
                    <span class="maintenance-info-badge maintenance-impact-badge-{{ $upcomingMaintenance->impact_level }}">
                        {{ ucfirst($upcomingMaintenance->impact_level) }}
                    </span>
                </div>
            </div>

            <div class="maintenance-countdown-section">
                <h3 class="countdown-title">Time Until Maintenance</h3>
                <div class="countdown-container">
                    <!-- Days - Tens -->
                    <div class="countdown-group">
                        <div class="countdown-label">Days</div>
                        <div class="countdown-wrapper">
                            <div class="nums nums-ten" id="days-tens">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                            <div class="nums nums-one" id="days-ones">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                        </div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <!-- Hours - Tens -->
                    <div class="countdown-group">
                        <div class="countdown-label">Hours</div>
                        <div class="countdown-wrapper">
                            <div class="nums nums-ten" id="hours-tens">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                            <div class="nums nums-one" id="hours-ones">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                        </div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <!-- Minutes - Tens -->
                    <div class="countdown-group">
                        <div class="countdown-label">Minutes</div>
                        <div class="countdown-wrapper">
                            <div class="nums nums-ten" id="minutes-tens">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                            <div class="nums nums-one" id="minutes-ones">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                        </div>
                    </div>

                    <div class="countdown-separator">:</div>

                    <!-- Seconds - Tens -->
                    <div class="countdown-group">
                        <div class="countdown-label">Seconds</div>
                        <div class="countdown-wrapper">
                            <div class="nums nums-ten" id="seconds-tens">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                            <div class="nums nums-one" id="seconds-ones">
                                <div class="num" data-num="0" data-num-next="1"></div>
                                <div class="num" data-num="1" data-num-next="2"></div>
                                <div class="num" data-num="2" data-num-next="3"></div>
                                <div class="num" data-num="3" data-num-next="4"></div>
                                <div class="num" data-num="4" data-num-next="5"></div>
                                <div class="num" data-num="5" data-num-next="6"></div>
                                <div class="num" data-num="6" data-num-next="7"></div>
                                <div class="num" data-num="7" data-num-next="8"></div>
                                <div class="num" data-num="8" data-num-next="9"></div>
                                <div class="num" data-num="9" data-num-next="0"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="maintenance-modal-footer">
            <button class="maintenance-modal-button" onclick="closeMaintenanceModal()">
                Got it, I understand
            </button>
        </div>
    </div>
</div>

<style>
    /* Modal Styles */
    .maintenance-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 99999;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 20px;
    }

    .maintenance-modal.show {
        opacity: 1;
        visibility: visible;
    }

    .maintenance-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
    }

    .maintenance-modal-content {
        position: relative;
        background: white;
        border-radius: 20px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        max-width: 600px;
        width: 100%;
        max-height: 85vh;
        overflow-y: auto;
        transform: scale(0.9) translateY(20px);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(226, 232, 240, 0.8);
    }

    .maintenance-modal.show .maintenance-modal-content {
        transform: scale(1) translateY(0);
    }

    .maintenance-modal-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(0, 0, 0, 0.05);
        border: none;
        border-radius: 50%;
        width: 2.5rem;
        height: 2.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: #6b7280;
        z-index: 10;
    }

    .maintenance-modal-close:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
    }

    .maintenance-modal-header {
        text-align: center;
        padding: 1.75rem 1.5rem 1.25rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .maintenance-modal-icon {
        width: 3rem;
        height: 3rem;
        margin: 0 auto 0.75rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));
        color: #dc2626;
    }

    .maintenance-impact-low .maintenance-modal-icon {
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.05));
        color: #2563eb;
    }

    .maintenance-impact-medium .maintenance-modal-icon {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1), rgba(217, 119, 6, 0.05));
        color: #d97706;
    }

    .maintenance-impact-high .maintenance-modal-icon {
        background: linear-gradient(135deg, rgba(249, 115, 22, 0.1), rgba(234, 88, 12, 0.05));
        color: #ea580c;
    }

    .maintenance-impact-critical .maintenance-modal-icon {
        background: linear-gradient(135deg, rgba(239, 68, 68, 0.1), rgba(220, 38, 38, 0.05));
        color: #dc2626;
    }

    .maintenance-modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin: 0 0 0.375rem;
    }

    .maintenance-modal-subtitle {
        font-size: 0.875rem;
        color: #6b7280;
        margin: 0;
    }

    .maintenance-modal-body {
        padding: 1.5rem;
    }

    /* Info Card */
    .maintenance-info-card {
        background: #f9fafb;
        border-radius: 0.75rem;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .maintenance-info-item {
        display: flex;
        flex-direction: column;
        gap: 0.375rem;
        margin-bottom: 0.875rem;
    }

    .maintenance-info-item:last-child {
        margin-bottom: 0;
    }

    .maintenance-info-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.875rem;
        margin-bottom: 0.875rem;
    }

    .maintenance-info-label {
        font-size: 0.6875rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .maintenance-info-value {
        font-size: 0.875rem;
        color: #1f2937;
        font-weight: 500;
        line-height: 1.5;
    }

    .maintenance-info-badge {
        display: inline-block;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    .maintenance-impact-badge-low {
        background: #dbeafe;
        color: #1e40af;
    }

    .maintenance-impact-badge-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .maintenance-impact-badge-high {
        background: #fed7aa;
        color: #9a3412;
    }

    .maintenance-impact-badge-critical {
        background: #fee2e2;
        color: #991b1b;
    }

    /* Countdown Section */
    .maintenance-countdown-section {
        text-align: center;
    }

    .countdown-title {
        font-size: 1rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.25rem;
    }

    .countdown-container {
        height: 120px;
        position: relative;
        text-align: center;
        display: flex;
        gap: 12px;
        justify-content: center;
        align-items: center;
    }

    .countdown-group {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.375rem;
    }

    .countdown-label {
        font-size: 0.625rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .countdown-wrapper {
        display: flex;
        gap: 4px;
    }

    .countdown-separator {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        align-self: flex-end;
        padding-bottom: 35px;
    }

    /* Flip Countdown Timer Styles - From Uiverse.io by Carlos-vargs */
    .nums {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        border-top: 1px solid #393939;
        display: inline-block;
        height: 120px;
        perspective: 1000px;
        position: relative;
        width: 85px;
    }

    .nums:before {
        border-bottom: 2px solid black;
        content: "";
        height: 1px;
        left: 0;
        position: absolute;
        transform: translate3d(0, -1px, 0);
        top: 50%;
        width: 100%;
        z-index: 1000;
    }

    .nums:after {
        backface-visibility: hidden;
        background: #2a2a2a;
        border-bottom: 1px solid #444444;
        border-top: 1px solid black;
        border-radius: 0 0 5px 5px;
        bottom: 0;
        box-shadow: inset 0 10px 30px #202020;
        color: #eeeeee;
        content: "0";
        display: block;
        font-size: 85px;
        height: calc(50% - 1px);
        left: 0;
        line-height: 0;
        overflow: hidden;
        position: absolute;
        text-align: center;
        text-shadow: 0 1px 2px #333;
        width: 100%;
        z-index: 0;
    }

    .num {
        animation-fill-mode: forwards;
        animation-iteration-count: infinite;
        animation-timing-function: ease-in;
        border-radius: 5px;
        font-size: 85px;
        height: 100%;
        left: 0;
        position: absolute;
        transform: rotateX(0);
        transition: 0.6s;
        transform-style: preserve-3d;
        top: 0;
        width: 100%;
    }

    .num:before,
    .num:after {
        backface-visibility: hidden;
        color: #eeeeee;
        display: block;
        height: 50%;
        left: 0;
        overflow: hidden;
        position: absolute;
        text-align: center;
        text-shadow: 0 1px 2px #333;
        width: 100%;
    }

    .num:before {
        background: #181818;
        border-radius: 5px 5px 0 0;
        box-shadow: inset 0 15px 50px #111111;
        content: attr(data-num);
        line-height: 1.38;
        top: 0;
        z-index: 1;
    }

    .num:after {
        background: #2a2a2a;
        border-bottom: 1px solid #444444;
        border-radius: 0 0 5px 5px;
        box-shadow: inset 0 15px 50px #202020;
        content: attr(data-num-next);
        height: calc(50% - 1px);
        line-height: 0;
        top: 0;
        transform: rotateX(180deg);
    }

    /* Default state - all numbers hidden */
    .nums-one .num,
    .nums-ten .num {
        z-index: 1;
        transform: rotateX(-180deg);
    }

    /* Active number - visible */
    .num.active {
        z-index: 100;
        transform: rotateX(0deg);
    }

    /* Flip animation when number changes */
    .num.flipping {
        animation: flip-number 0.6s ease-in forwards;
        z-index: 100;
    }

    @keyframes flip-number {
        0% {
            transform: rotateX(0deg);
        }
        50% {
            transform: rotateX(-90deg);
        }
        100% {
            transform: rotateX(0deg);
        }
    }

    /* Modal Footer */
    .maintenance-modal-footer {
        padding: 1.25rem 1.5rem 1.5rem;
        border-top: 1px solid #e5e7eb;
        text-align: center;
    }

    .maintenance-modal-button {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(129, 140, 248, 0.05));
        color: #4338ca;
        border: 1px solid rgba(99, 102, 241, 0.2);
        padding: 0.625rem 1.5rem;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .maintenance-modal-button:hover {
        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(129, 140, 248, 0.1));
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .maintenance-modal-content {
            max-width: 95%;
            border-radius: 16px;
        }

        .maintenance-modal-header {
            padding: 1.5rem 1.25rem 1rem;
        }

        .maintenance-modal-body {
            padding: 1.25rem;
        }

        .maintenance-info-row {
            grid-template-columns: 1fr;
        }

        .countdown-container {
            gap: 8px;
            height: 100px;
        }

        .nums {
            width: 70px;
            height: 100px;
        }

        .num {
            font-size: 70px;
        }

        .nums:after {
            font-size: 70px;
        }

        .countdown-separator {
            font-size: 1rem;
            padding-bottom: 30px;
        }
    }
</style>

<script>
    (function() {
        const modal = document.getElementById('maintenance-countdown-modal');
        if (!modal) return;

        const startTime = parseInt(modal.dataset.startTime);
        let countdownInterval;

        // Show modal on page load
        setTimeout(() => {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }, 500);

        // Close modal function
        window.closeMaintenanceModal = function() {
            modal.classList.remove('show');
            setTimeout(() => {
                modal.style.display = 'none';
                document.body.style.overflow = '';
            }, 300);
            // Store in localStorage to not show again this session
            localStorage.setItem('maintenance-modal-dismissed-' + {{ $upcomingMaintenance->id }}, 'true');
        };

        // Close button
        const closeBtn = modal.querySelector('.maintenance-modal-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', closeMaintenanceModal);
        }

        // Close on overlay click
        const overlay = modal.querySelector('.maintenance-modal-overlay');
        if (overlay) {
            overlay.addEventListener('click', closeMaintenanceModal);
        }

        // Check if already dismissed
        if (localStorage.getItem('maintenance-modal-dismissed-' + {{ $upcomingMaintenance->id }}) === 'true') {
            modal.style.display = 'none';
            return;
        }

        // Store current values to detect changes
        let currentValues = {
            daysTens: -1,
            daysOnes: -1,
            hoursTens: -1,
            hoursOnes: -1,
            minutesTens: -1,
            minutesOnes: -1,
            secondsTens: -1,
            secondsOnes: -1
        };

        // Function to update flip countdown
        function updateFlipCountdown() {
            const now = new Date().getTime();
            const distance = startTime - now;

            if (distance < 0) {
                // Maintenance has started
                closeMaintenanceModal();
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update each digit and trigger flip if changed
            const daysTens = Math.floor(days / 10);
            const daysOnes = days % 10;
            const hoursTens = Math.floor(hours / 10);
            const hoursOnes = hours % 10;
            const minutesTens = Math.floor(minutes / 10);
            const minutesOnes = minutes % 10;
            const secondsTens = Math.floor(seconds / 10);
            const secondsOnes = seconds % 10;

            if (currentValues.daysTens !== daysTens) {
                updateFlipDigit('days-tens', daysTens);
                currentValues.daysTens = daysTens;
            }
            if (currentValues.daysOnes !== daysOnes) {
                updateFlipDigit('days-ones', daysOnes);
                currentValues.daysOnes = daysOnes;
            }
            if (currentValues.hoursTens !== hoursTens) {
                updateFlipDigit('hours-tens', hoursTens);
                currentValues.hoursTens = hoursTens;
            }
            if (currentValues.hoursOnes !== hoursOnes) {
                updateFlipDigit('hours-ones', hoursOnes);
                currentValues.hoursOnes = hoursOnes;
            }
            if (currentValues.minutesTens !== minutesTens) {
                updateFlipDigit('minutes-tens', minutesTens);
                currentValues.minutesTens = minutesTens;
            }
            if (currentValues.minutesOnes !== minutesOnes) {
                updateFlipDigit('minutes-ones', minutesOnes);
                currentValues.minutesOnes = minutesOnes;
            }
            if (currentValues.secondsTens !== secondsTens) {
                updateFlipDigit('seconds-tens', secondsTens);
                currentValues.secondsTens = secondsTens;
            }
            if (currentValues.secondsOnes !== secondsOnes) {
                updateFlipDigit('seconds-ones', secondsOnes);
                currentValues.secondsOnes = secondsOnes;
            }
        }

        // Function to update flip digit by triggering animation
        function updateFlipDigit(containerId, targetValue) {
            const container = document.getElementById(containerId);
            if (!container) return;

            const nums = container.querySelectorAll('.num');
            let currentActive = null;
            
            // Find current active number
            nums.forEach((num) => {
                if (num.classList.contains('active')) {
                    currentActive = num;
                }
            });

            nums.forEach((num) => {
                const numValue = parseInt(num.getAttribute('data-num'));
                
                // Remove all active classes
                num.classList.remove('active', 'flipping');
                
                // Show the target number
                if (numValue === targetValue) {
                    // If changing from another number, trigger flip animation
                    if (currentActive && currentActive !== num && currentActive.classList.contains('active')) {
                        num.classList.add('flipping');
                        setTimeout(() => {
                            num.classList.remove('flipping');
                            num.classList.add('active');
                        }, 600);
                    } else {
                        // Initial display or no change - show immediately
                        num.classList.add('active');
                    }
                } else {
                    // Hide non-active numbers
                    num.style.zIndex = '1';
                    num.style.transform = 'rotateX(-180deg)';
                }
            });
        }

        // Initialize countdown immediately - set initial values
        updateFlipCountdown();
        
        // Start interval for updates
        countdownInterval = setInterval(updateFlipCountdown, 1000);

        // Cleanup on page unload
        window.addEventListener('beforeunload', function() {
            if (countdownInterval) clearInterval(countdownInterval);
        });
    })();
</script>
@endif
