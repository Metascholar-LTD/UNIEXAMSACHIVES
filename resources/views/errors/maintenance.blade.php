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
                box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
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
                    <p class="time">
                        <i class="icofont-clock-time"></i> 
                        Expected completion: {{ $maintenance->scheduled_end->format('M d, Y h:i A') }}
                    </p>
                @endif
            @else
                <p style="margin-top: 15px;">We'll be back shortly. Thank you for your patience!</p>
            @endif

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
</body>
</html>

