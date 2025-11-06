<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Maintenance - Metascholar Consult</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated background particles */
        .background-particles {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            animation: float 15s infinite ease-in-out;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100vh) translateX(100px);
                opacity: 0;
            }
        }

        /* Main container */
        .maintenance-container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        /* Bouncing image */
        .maintenance-image {
            width: 300px;
            height: 300px;
            margin: 0 auto 40px;
            animation: bounce 3s ease-in-out infinite;
            filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.3));
            position: relative;
        }

        .maintenance-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 20px;
            background: white;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        @keyframes bounce {
            0%, 100% {
                transform: translateY(0) scale(1);
            }
            50% {
                transform: translateY(-30px) scale(1.05);
            }
        }

        /* Pill-style maintenance message */
        .maintenance-pill {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: white;
            padding: 16px 32px;
            border-radius: 50px;
            border: 2px solid #01b2ac;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            margin-bottom: 30px;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            }
            50% {
                box-shadow: 0 15px 50px rgba(1, 178, 172, 0.3);
            }
        }

        .maintenance-pill i {
            color: #01b2ac;
            font-size: 24px;
            animation: rotate 4s linear infinite;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }
            100% {
                transform: rotate(360deg);
            }
        }

        .maintenance-pill span {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            letter-spacing: 0.5px;
        }

        /* Additional info */
        .maintenance-info {
            background: white;
            border-radius: 20px;
            padding: 30px;
            margin-top: 30px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .maintenance-info h2 {
            color: #333;
            font-size: 28px;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .maintenance-info p {
            color: #666;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .maintenance-info .time {
            color: #ffd700;
            font-weight: 600;
            font-size: 18px;
            margin-top: 15px;
        }

        /* Loading dots */
        .loading-dots {
            display: inline-flex;
            gap: 8px;
            margin-top: 20px;
        }

        .loading-dots span {
            width: 12px;
            height: 12px;
            background: #01b2ac;
            border-radius: 50%;
            animation: dot-bounce 1.4s ease-in-out infinite;
        }

        .loading-dots span:nth-child(1) {
            animation-delay: 0s;
        }

        .loading-dots span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .loading-dots span:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes dot-bounce {
            0%, 80%, 100% {
                transform: scale(0.8);
                opacity: 0.5;
            }
            40% {
                transform: scale(1.2);
                opacity: 1;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .maintenance-image {
                width: 250px;
                height: 250px;
            }

            .maintenance-pill {
                padding: 12px 24px;
            }

            .maintenance-pill span {
                font-size: 16px;
            }

            .maintenance-info {
                padding: 20px;
            }

            .maintenance-info h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <!-- Background particles -->
    <div class="background-particles">
        @for($i = 0; $i < 20; $i++)
            <div class="particle" style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) }}s; animation-duration: {{ rand(10, 20) }}s;"></div>
        @endfor
    </div>

    <!-- Main content -->
    <div class="maintenance-container">
        <!-- Bouncing maintenance image -->
        <div class="maintenance-image">
            <img src="https://res.cloudinary.com/dsypclqxk/image/upload/v1762374398/20943392_yazt5t.jpg" alt="System Maintenance">
        </div>

        <!-- Pill-style maintenance message -->
        <div class="maintenance-pill">
            <i class="icofont-gear"></i>
            <span>System is Under Maintenance</span>
        </div>

        <!-- Additional information -->
        <div class="maintenance-info">
            <h2>We're Making Things Better!</h2>
            <p>Our team is currently performing scheduled maintenance to improve your experience.</p>
            
            @if(isset($maintenance) && $maintenance)
                @if($maintenance->description)
                    <p style="margin-top: 15px; font-style: italic;">{{ $maintenance->description }}</p>
                @endif
                
                @if($maintenance->scheduled_end)
                    <p class="time" style="margin-top: 20px; margin-bottom: 10px;">
                        <i class="icofont-clock-time"></i> 
                        Expected completion: {{ $maintenance->scheduled_end->format('M d, Y h:i A') }}
                    </p>
                    
                    <!-- Countdown Timer -->
                    <div class="countdown-container" id="maintenance-countdown-container" 
                         data-end-time="{{ $maintenance->scheduled_end->timestamp * 1000 }}">
                        <div class="countdown-label">Maintenance ends in:</div>
                        <div class="countdown-display">
                            <div class="countdown-item">
                                <span class="countdown-value" id="countdown-hours">00</span>
                                <span class="countdown-unit">Hours</span>
                            </div>
                            <span class="countdown-separator">:</span>
                            <div class="countdown-item">
                                <span class="countdown-value" id="countdown-minutes">00</span>
                                <span class="countdown-unit">Minutes</span>
                            </div>
                            <span class="countdown-separator">:</span>
                            <div class="countdown-item">
                                <span class="countdown-value" id="countdown-seconds">00</span>
                                <span class="countdown-unit">Seconds</span>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <p style="margin-top: 15px;">We'll be back shortly. Thank you for your patience!</p>
            @endif

            <!-- Manual Refresh Button -->
            <button class="refresh-button" id="check-maintenance-btn" onclick="checkMaintenanceStatus()">
                <i class="icofont-refresh"></i> Check Status
            </button>

            <!-- Loading animation -->
            <div class="loading-dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Icofont for icons -->
    <link rel="stylesheet" href="{{ asset('css/icofont.min.css') }}">

    <style>
        /* Countdown Timer Styles */
        .countdown-container {
            margin: 25px 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
        }

        .countdown-label {
            color: white;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .countdown-display {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 15px;
        }

        .countdown-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            padding: 15px 20px;
            min-width: 80px;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .countdown-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            line-height: 1;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .countdown-unit {
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.9);
            margin-top: 8px;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .countdown-separator {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Refresh Button */
        .refresh-button {
            margin-top: 20px;
            padding: 12px 30px;
            background: linear-gradient(135deg, #01b2ac 0%, #008b87 100%);
            color: white;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(1, 178, 172, 0.3);
        }

        .refresh-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(1, 178, 172, 0.4);
        }

        .refresh-button:active {
            transform: translateY(0);
        }

        .refresh-button i {
            font-size: 18px;
            animation: spin 2s linear infinite;
        }

        .refresh-button.checking i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        @media (max-width: 768px) {
            .countdown-display {
                gap: 10px;
            }

            .countdown-item {
                min-width: 60px;
                padding: 12px 15px;
            }

            .countdown-value {
                font-size: 2rem;
            }

            .countdown-separator {
                font-size: 1.5rem;
            }
        }
    </style>

    <script>
        let checkInterval;
        let countdownInterval;

        function updateCountdown() {
            const container = document.getElementById('maintenance-countdown-container');
            if (!container) return;

            const endTime = parseInt(container.dataset.endTime);
            const now = new Date().getTime();
            const distance = endTime - now;

            if (distance < 0) {
                // Maintenance should be over, check status
                checkMaintenanceStatus();
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            const hoursEl = document.getElementById('countdown-hours');
            const minutesEl = document.getElementById('countdown-minutes');
            const secondsEl = document.getElementById('countdown-seconds');

            if (hoursEl) hoursEl.textContent = String(hours).padStart(2, '0');
            if (minutesEl) minutesEl.textContent = String(minutes).padStart(2, '0');
            if (secondsEl) secondsEl.textContent = String(seconds).padStart(2, '0');
        }

        function checkMaintenanceStatus() {
            const btn = document.getElementById('check-maintenance-btn');
            if (btn) {
                btn.classList.add('checking');
                btn.disabled = true;
            }

            fetch('/api/check-maintenance-status', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.maintenance_active) {
                    // Maintenance is over, redirect to home
                    window.location.href = '/';
                } else {
                    // Still in maintenance, show message
                    if (btn) {
                        btn.classList.remove('checking');
                        btn.disabled = false;
                    }
                    // Optionally show a message that maintenance is still active
                }
            })
            .catch(error => {
                console.error('Error checking maintenance status:', error);
                if (btn) {
                    btn.classList.remove('checking');
                    btn.disabled = false;
                }
            });
        }

        // Start countdown if maintenance end time exists
        const container = document.getElementById('maintenance-countdown-container');
        if (container) {
            // Update immediately
            updateCountdown();
            
            // Update every second
            countdownInterval = setInterval(updateCountdown, 1000);

            // Check maintenance status every 30 seconds
            checkInterval = setInterval(checkMaintenanceStatus, 30000);
        }

        // Clean up on page unload
        window.addEventListener('beforeunload', function() {
            if (checkInterval) clearInterval(checkInterval);
            if (countdownInterval) clearInterval(countdownInterval);
        });
    </script>
</body>
</html>

