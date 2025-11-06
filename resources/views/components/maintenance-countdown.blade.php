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
<div class="maintenance-countdown-banner maintenance-impact-{{ $upcomingMaintenance->impact_level }}" 
     data-start-time="{{ $upcomingMaintenance->scheduled_start->timestamp * 1000 }}">
    <div class="maintenance-banner-content">
        <div class="maintenance-banner-icon">
            <i class="icofont-tools"></i>
        </div>
        <div class="maintenance-banner-text">
            <div class="maintenance-banner-title">
                <strong>Scheduled Maintenance:</strong> {{ $upcomingMaintenance->title }}
            </div>
            <div class="maintenance-banner-description">
                {{ $upcomingMaintenance->banner_message ?? $upcomingMaintenance->description }}
            </div>
            <div class="maintenance-banner-schedule">
                <i class="icofont-calendar"></i>
                {{ $upcomingMaintenance->scheduled_start->format('M d, Y h:i A') }} - 
                {{ $upcomingMaintenance->scheduled_end->format('h:i A') }}
            </div>
        </div>
        <div class="maintenance-countdown-timer">
            <div class="countdown-label">Starts in:</div>
            <div class="countdown-display" id="maintenance-countdown">
                <span class="countdown-item">
                    <span class="countdown-value" id="countdown-days">00</span>
                    <span class="countdown-unit">Days</span>
                </span>
                <span class="countdown-separator">:</span>
                <span class="countdown-item">
                    <span class="countdown-value" id="countdown-hours">00</span>
                    <span class="countdown-unit">Hours</span>
                </span>
                <span class="countdown-separator">:</span>
                <span class="countdown-item">
                    <span class="countdown-value" id="countdown-minutes">00</span>
                    <span class="countdown-unit">Minutes</span>
                </span>
                <span class="countdown-separator">:</span>
                <span class="countdown-item">
                    <span class="countdown-value" id="countdown-seconds">00</span>
                    <span class="countdown-unit">Seconds</span>
                </span>
            </div>
        </div>
        <button class="maintenance-banner-close">
            <i class="icofont-close"></i>
        </button>
    </div>
</div>

<style>
    .maintenance-countdown-banner {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-bottom: 3px solid #f59e0b;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        animation: slideDown 0.5s ease-out;
    }

    .maintenance-impact-low {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        border-bottom-color: #3b82f6;
    }

    .maintenance-impact-low .maintenance-banner-icon,
    .maintenance-impact-low .maintenance-banner-title {
        color: #1e40af;
    }

    .maintenance-impact-low .maintenance-banner-description,
    .maintenance-impact-low .maintenance-banner-schedule {
        color: #1e3a8a;
    }

    .maintenance-impact-low .countdown-label,
    .maintenance-impact-low .countdown-value,
    .maintenance-impact-low .countdown-separator {
        color: #1e40af;
    }

    .maintenance-impact-medium {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-bottom-color: #f59e0b;
    }

    .maintenance-impact-high {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        border-bottom-color: #f97316;
    }

    .maintenance-impact-high .maintenance-banner-icon,
    .maintenance-impact-high .maintenance-banner-title {
        color: #9a3412;
    }

    .maintenance-impact-high .maintenance-banner-description,
    .maintenance-impact-high .maintenance-banner-schedule {
        color: #7c2d12;
    }

    .maintenance-impact-high .countdown-label,
    .maintenance-impact-high .countdown-value,
    .maintenance-impact-high .countdown-separator {
        color: #9a3412;
    }

    .maintenance-impact-critical {
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
        border-bottom-color: #ef4444;
    }

    .maintenance-impact-critical .maintenance-banner-icon,
    .maintenance-impact-critical .maintenance-banner-title {
        color: #991b1b;
    }

    .maintenance-impact-critical .maintenance-banner-description,
    .maintenance-impact-critical .maintenance-banner-schedule {
        color: #7f1d1d;
    }

    .maintenance-impact-critical .countdown-label,
    .maintenance-impact-critical .countdown-value,
    .maintenance-impact-critical .countdown-separator {
        color: #991b1b;
    }

    /* Add padding to body when banner is visible */
    body.maintenance-banner-active {
        padding-top: 140px;
    }

    @media (max-width: 768px) {
        body.maintenance-banner-active {
            padding-top: 200px;
        }
    }

    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .maintenance-banner-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 1rem 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        position: relative;
    }

    .maintenance-banner-icon {
        font-size: 2rem;
        color: #92400e;
        flex-shrink: 0;
    }

    .maintenance-banner-text {
        flex: 1;
        min-width: 0;
    }

    .maintenance-banner-title {
        font-size: 1rem;
        font-weight: 700;
        color: #78350f;
        margin-bottom: 0.25rem;
    }

    .maintenance-banner-description {
        font-size: 0.875rem;
        color: #92400e;
        margin-bottom: 0.5rem;
    }

    .maintenance-banner-schedule {
        font-size: 0.75rem;
        color: #a16207;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .maintenance-countdown-timer {
        flex-shrink: 0;
        text-align: center;
    }

    .countdown-label {
        font-size: 0.75rem;
        color: #78350f;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .countdown-display {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .countdown-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: white;
        border-radius: 0.5rem;
        padding: 0.5rem 0.75rem;
        min-width: 60px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .countdown-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #78350f;
        line-height: 1;
    }

    .countdown-unit {
        font-size: 0.625rem;
        color: #a16207;
        margin-top: 0.25rem;
        text-transform: uppercase;
        font-weight: 600;
    }

    .countdown-separator {
        font-size: 1.25rem;
        font-weight: 700;
        color: #78350f;
    }

    .maintenance-banner-close {
        position: absolute;
        top: 0.5rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.5);
        border: none;
        border-radius: 50%;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        color: #78350f;
    }

    .maintenance-banner-close:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.1);
    }

    @media (max-width: 768px) {
        .maintenance-banner-content {
            flex-direction: column;
            align-items: flex-start;
            padding: 1rem;
        }

        .maintenance-countdown-timer {
            width: 100%;
        }

        .countdown-display {
            justify-content: center;
        }

        .countdown-item {
            min-width: 50px;
            padding: 0.375rem 0.5rem;
        }

        .countdown-value {
            font-size: 1.25rem;
        }

        .countdown-unit {
            font-size: 0.5rem;
        }
    }
</style>

<script>
    (function() {
        const banner = document.querySelector('.maintenance-countdown-banner');
        if (!banner) return;

        // Add class to body for padding
        document.body.classList.add('maintenance-banner-active');

        const startTime = parseInt(banner.dataset.startTime);
        
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = startTime - now;

            if (distance < 0) {
                // Maintenance has started
                banner.style.display = 'none';
                document.body.classList.remove('maintenance-banner-active');
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const daysEl = document.getElementById('countdown-days');
            const hoursEl = document.getElementById('countdown-hours');
            const minutesEl = document.getElementById('countdown-minutes');
            const secondsEl = document.getElementById('countdown-seconds');

            if (daysEl) daysEl.textContent = String(days).padStart(2, '0');
            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        }

        // Handle close button
        const closeBtn = banner.querySelector('.maintenance-banner-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                banner.style.display = 'none';
                document.body.classList.remove('maintenance-banner-active');
            });
        }

        // Update immediately
        updateCountdown();
        
        // Update every second
        setInterval(updateCountdown, 1000);
    })();
</script>

