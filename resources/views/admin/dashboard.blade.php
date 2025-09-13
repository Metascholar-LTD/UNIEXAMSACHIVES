@extends('layout.app')

@push('styles')
<!-- Font Awesome Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Recent Exams List View Styles */
    .recent-exams-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .recent-exam-card {
        display: flex;
        align-items: center;
        border-radius: 12px;
        padding: 1.25rem;
        min-height: 100px;
        background: white;
        border: 1px solid #f1f3f4;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .recent-exam-card::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 12px 0 0 12px;
    }

    .recent-exam-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .exam-card-header {
        height: 60px;
        width: 60px;
        border-radius: 12px;
        margin-right: 1rem;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .exam-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .exam-icon i {
        font-size: 1.5rem;
        color: white;
    }

    .exam-card-body {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
    }

    .exam-main-info {
        flex: 1;
        min-width: 0;
        max-width: 300px;
    }

    .exam-title {
        margin: 0 0 0.5rem 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #343a40;
        line-height: 1.3;
    }

    .exam-title a {
        color: inherit;
        text-decoration: none;
        white-space: normal;
        overflow: visible;
        text-overflow: unset;
        display: block;
        max-width: 100%;
        word-wrap: break-word;
    }

    .exam-title a:hover {
        color: #007bff;
    }

    .exam-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .exam-meta .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        white-space: nowrap;
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .meta-item i {
        color: #007bff;
        font-size: 0.9rem;
        width: 16px;
        text-align: center;
    }

    .exam-instructor-section {
        min-width: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .instructor-info {
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .instructor-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }

    .instructor-avatar i {
        font-size: 1rem;
    }

    .instructor-name {
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }

    .exam-actions {
        display: flex;
        gap: 0.5rem;
        min-width: 120px;
        justify-content: center;
        flex-shrink: 0;
        margin-right: 0.1rem;
    }

    .action-btn {
        padding: 8px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        background: white;
        color: #6c757d;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 36px;
        height: 36px;
    }

    .action-btn:hover {
        text-decoration: none;
    }

    .action-btn.primary {
        border-color: #007bff;
        background: #007bff;
        color: white;
    }

    .action-btn.primary:hover {
        background: #0056b3;
        border-color: #0056b3;
        color: white;
    }

    .action-btn.secondary:hover {
        border-color: #6c757d;
        background: #6c757d;
        color: white;
    }

    .exam-status {
        min-width: 110px;
        display: flex;
        justify-content: center;
        flex-shrink: 0;
        margin-left: 0.1rem;
    }

    .status-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .status-badge.approved {
        background: rgba(40, 167, 69, 0.1);
        color: #28a745;
        border: 1px solid rgba(40, 167, 69, 0.2);
    }

    .status-badge.pending {
        background: rgba(255, 193, 7, 0.1);
        color: #ffc107;
        border: 1px solid rgba(255, 193, 7, 0.2);
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .exam-card-body {
            flex-wrap: wrap;
            gap: 1rem;
        }
        
        .exam-main-info {
            max-width: 100%;
            min-width: 0;
        }
        
        .exam-instructor-section,
        .exam-actions,
        .exam-status {
            min-width: auto;
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 768px) {
        .recent-exam-card {
            flex-direction: column;
            text-align: center;
            padding: 1rem;
        }

        .exam-card-header {
            margin: 0 auto 1rem;
        }

        .exam-card-body {
            flex-direction: column;
            align-items: center;
            padding: 0;
            width: 100%;
        }

        .exam-main-info {
            text-align: center;
            margin-bottom: 1rem;
            width: 100%;
        }

        .exam-title {
            max-width: 100%;
            white-space: normal;
            text-align: center;
        }

        .exam-meta {
            justify-content: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .exam-instructor-section {
            justify-content: center;
            margin: 1rem 0;
            min-width: auto;
        }

        .exam-actions {
            margin-top: 1rem;
            width: 100%;
            justify-content: center;
        }

        .action-btn {
            flex: 1;
            max-width: 150px;
        }
    }

    /* Welcome Popup Styles - Reuse memo popup styles */
    .memo-success-popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(8px);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10000;
        opacity: 0;
        animation: popupFadeIn 0.8s ease-out forwards;
    }

    .popup-container {
        position: relative;
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border-radius: 24px;
        padding: 0;
        box-shadow: 
            0 25px 50px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.05),
            inset 0 1px 0 rgba(255, 255, 255, 0.1);
        max-width: 600px;
        width: 90%;
        text-align: left;
        transform: scale(0.5) translateY(100px);
        animation: popupBounceIn 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        border: 3px solid #10b981;
        overflow: hidden;
        display: flex;
        min-height: 300px;
    }

    .popup-content {
        position: relative;
        z-index: 2;
        display: flex;
        width: 100%;
        min-height: 300px;
    }

    /* Left Side Styles */
    .popup-left {
        flex: 1;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 40px 30px;
        position: relative;
        overflow: hidden;
    }

    .popup-left::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.05)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.05)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .university-image-container {
        position: relative;
        z-index: 2;
        margin-bottom: 20px;
    }

    .university-image {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
    }

    .university-image:hover {
        transform: scale(1.05);
    }

    .welcome-text {
        color: white;
        font-size: 24px;
        font-weight: 700;
        text-align: center;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        position: relative;
        z-index: 2;
    }

    .user-name {
        display: block;
        font-size: 18px;
        font-weight: 500;
        margin-top: 8px;
        opacity: 0.9;
    }

    /* Right Side Styles */
    .popup-right {
        flex: 1;
        padding: 40px 30px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background: white;
    }

    .login-messages {
        margin-bottom: 30px;
    }

    .message-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px 0;
        border-bottom: 1px solid #f1f5f9;
    }

    .message-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .message-text {
        flex: 1;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
        margin-right: 15px;
    }

    .loading-spinner {
        width: 24px;
        height: 24px;
        position: relative;
    }

    .spinner {
        width: 20px;
        height: 20px;
        border: 2px solid #e2e8f0;
        border-top: 2px solid #10b981;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    .checkmark {
        width: 24px;
        height: 24px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 14px;
        animation: checkmarkPop 0.3s ease-out;
    }

    .popup-message {
        font-size: 16px;
        color: #64748b;
        margin: 0 0 24px 0;
        font-weight: 500;
        line-height: 1.5;
    }

    .popup-details {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 24px;
    }

    .security-details {
        background: rgba(239, 68, 68, 0.1);
        border: 1px solid rgba(239, 68, 68, 0.2);
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 32px;
    }

    .security-details .detail-item {
        color: #dc2626;
    }

    .security-details .detail-item i {
        color: #ef4444;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 14px;
        color: #059669;
        font-weight: 600;
    }

    .detail-item i {
        font-size: 16px;
        color: #10b981;
    }

    .popup-close-btn {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 12px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    }

    .popup-close-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(239, 68, 68, 0.4);
    }

    .popup-confetti {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        border-radius: 24px;
    }

    .popup-confetti::before,
    .popup-confetti::after {
        content: '';
        position: absolute;
        width: 10px;
        height: 10px;
        background: #10b981;
        animation: confettiFall 3s infinite ease-in;
    }

    .popup-confetti::before {
        left: 20%;
        animation-delay: 0s;
        background: #3b82f6;
    }

    .popup-confetti::after {
        left: 80%;
        animation-delay: 1s;
        background: #f59e0b;
    }

    /* Keyframe Animations */
    @keyframes popupFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes popupBounceIn {
        0% {
            transform: scale(0.5) translateY(100px);
            opacity: 0;
        }
        50% {
            transform: scale(1.1) translateY(-20px);
        }
        100% {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    @keyframes popupIconBlink {
        0%, 100% {
            transform: scale(1);
            filter: drop-shadow(0 0 20px rgba(16, 185, 129, 0.6));
        }
        25% {
            transform: scale(1.1);
            filter: drop-shadow(0 0 30px rgba(16, 185, 129, 0.8));
        }
        50% {
            transform: scale(1.2);
            filter: drop-shadow(0 0 40px rgba(16, 185, 129, 1));
        }
        75% {
            transform: scale(1.1);
            filter: drop-shadow(0 0 30px rgba(16, 185, 129, 0.8));
        }
    }

    @keyframes titleBlink {
        0%, 100% {
            color: #1e293b;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        50% {
            color: #10b981;
            text-shadow: 0 0 20px rgba(16, 185, 129, 0.6);
        }
    }

    @keyframes pulseRing {
        0% {
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 1;
        }
        100% {
            transform: translate(-50%, -50%) scale(2);
            opacity: 0;
        }
    }

    @keyframes confettiFall {
        0% {
            transform: translateY(-100px) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(400px) rotate(720deg);
            opacity: 0;
        }
    }

    @keyframes popupFadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.8);
        }
    }

    /* Animations */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    @keyframes checkmarkPop {
        0% { 
            transform: scale(0);
            opacity: 0;
        }
        50% { 
            transform: scale(1.2);
        }
        100% { 
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Responsive Design for Popup */
    /* Mobile: 0px - 767px */
    @media (max-width: 767px) {
        .popup-container {
            max-width: 95%;
            min-height: 250px;
        }
        
        .popup-content {
            flex-direction: column;
            min-height: 250px;
        }
        
        .popup-left {
            padding: 20px;
            flex: 0 0 auto;
        }
        
        .university-image {
            width: 80px;
            height: 80px;
        }
        
        .welcome-text {
            font-size: 18px;
        }
        
        .user-name {
            font-size: 14px;
        }
        
        .popup-right {
            padding: 20px;
        }
        
        .message-text {
            font-size: 14px;
        }
    }

    /* Tablet: 768px - 1199px */
    @media (min-width: 768px) and (max-width: 1199px) {
        .popup-container {
            max-width: 500px;
        }
        
        .university-image {
            width: 100px;
            height: 100px;
        }
        
        .welcome-text {
            font-size: 20px;
        }
        
        .user-name {
            font-size: 16px;
        }
    }

    /* Desktop: 1200px - 1599px */
    @media (min-width: 1200px) and (max-width: 1599px) {
        .popup-container {
            max-width: 600px;
        }
    }

    /* Large: 1600px+ */
    @media (min-width: 1600px) {
        .popup-container {
            max-width: 700px;
        }
        
        .university-image {
            width: 140px;
            height: 140px;
        }
        
        .welcome-text {
            font-size: 26px;
        }
        
        .user-name {
            font-size: 20px;
        }
        
        .message-text {
            font-size: 18px;
        }
    }
</style>
@endpush

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<!-- Welcome Popup for Login -->
@if(session('success') && session('success') === 'Login successful')
<div id="welcomePopup" class="memo-success-popup">
    <div class="popup-container">
        <div class="popup-content">
            <!-- Left Side: University Image and Welcome -->
            <div class="popup-left">
                <div class="university-image-container">
                    <img src="{{ asset('img/cug_logo_new.jpeg') }}" alt="Catholic University" class="university-image" onerror="this.src='{{ asset('img/logo/logo_1.png') }}'">
                </div>
                <h3 class="welcome-text">Welcome back<br><span class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span></h3>
            </div>
            
            <!-- Right Side: Login Messages -->
            <div class="popup-right">
                <div class="login-messages">
                    <div class="message-item">
                        <div class="message-text">Login successful</div>
                        <div class="loading-spinner" id="loginSpinner">
                            <div class="spinner"></div>
                        </div>
                        <div class="checkmark" id="loginCheck" style="display: none;">
                            <i class="icofont-check"></i>
                        </div>
                    </div>
                    
                    <div class="message-item">
                        <div class="message-text">Security verified</div>
                        <div class="loading-spinner" id="securitySpinner">
                            <div class="spinner"></div>
                        </div>
                        <div class="checkmark" id="securityCheck" style="display: none;">
                            <i class="icofont-check"></i>
                        </div>
                    </div>
                </div>
                
                <button type="button" class="popup-close-btn" onclick="closeWelcomePopup()">
                    <i class="icofont-close"></i> Continue
                </button>
            </div>
        </div>
        <div class="popup-confetti"></div>
    </div>
</div>
@endif

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
                    <div class="dashboard__content__wraper">
                        <div class="dashboard__section__title">
                            <h4>Dashboard</h4>
                        </div>
                        @auth
                            @if(auth()->user()->is_admin)
                            <div class="row">
                                {{-- exams --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_total_papers}}</span>

                                                </div>
                                                <p>Total Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_approve_papers}}</span>

                                                </div>
                                                <p>Approved Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_pending_papers}}</span>

                                                </div>
                                                <p>Pending Exams</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Files --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_total_files}}</span>

                                                </div>
                                                <p>Total Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_approve_files}}</span>

                                                </div>
                                                <p>Approved Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$admin_pending_files}}</span>

                                                </div>
                                                <p>Pending Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endif
                            @unless(auth()->user()->is_admin)
                            <div class="row">
                                {{-- Exams --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_papers}}</span>

                                                </div>
                                                <p>Total Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_approved_papers}}</span>

                                                </div>
                                                <p>Approved Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_pending_papers}}</span>

                                                </div>
                                                <p>Pending Exam Papers</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Files --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__1.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_files}}</span>

                                                </div>
                                                <p>Total Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_approved_files}}</span>

                                                </div>
                                                <p>Approved Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_pending_files}}</span>

                                                </div>
                                                <p>Pending Files</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Users --}}
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__2.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$total_users}}</span>

                                                </div>
                                                <p>Total Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__3.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$dailyVisits}}</span>

                                                </div>
                                                <p>Daily Active Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-xl-4 col-lg-6 col-md-12 col-12">
                                    <div class="dashboard__single__counter">
                                        <div class="counterarea__text__wraper">
                                            <div class="counter__img">
                                                <img loading="lazy"  src="../img/counter/counter__4.png" alt="counter">
                                            </div>
                                            <div class="counter__content__wraper">
                                                <div class="counter__number">
                                                    <span class="counter">{{$totalVisits}}</span>

                                                </div>
                                                <p>Total Active Users</p>

                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                            @endunless

                        @endauth

                    </div>

                    @auth
                        @unless(auth()->user()->is_admin)

                                                        <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-12">
                                    <div class="dashboard__content__wraper admin__content__wrapper">

                                        <div class="dashboard__section__title clean-section-title">
                                            <div class="title-content">
                                                <h4><i class="icofont-document"></i> Recent Uploaded Exams</h4>
                                            </div>
                                            <a href="{{route('dashboard.all.upload.document')}}" class="clean-see-more-btn">
                                                View All
                                            </a>
                                        </div>

                                        @if (count($recentlyUploadedExams) > 0)
                                            <div class="recent-exams-list">
                                                @foreach ($recentlyUploadedExams as $item )
                                                <div class="recent-exam-card" data-exam-id="{{ $item->id }}">
                                                    <div class="exam-card-header">
                                                        <div class="exam-header-info">
                                                            <div class="exam-icon">
                                                                @php
                                                                    $extension = pathinfo($item->exam_document, PATHINFO_EXTENSION);
                                                                @endphp
                                                                @if ($extension == 'pdf')
                                                                    <i class="icofont-file-pdf"></i>
                                                                @else
                                                                    <i class="icofont-file-word"></i>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="exam-card-body">
                                                        <div class="exam-main-info">
                                                            <h4 class="exam-title">
                                                                <a href="#" title="{{ $item->course_title }} - {{ $item->course_code }}">{{ $item->course_title }} - {{ $item->course_code }}</a>
                                                            </h4>
                                                            <div class="exam-meta">
                                                                <div class="meta-item">
                                                                    <i class="fas fa-file-alt"></i>
                                                                    <span>{{ $item->exam_format }}</span>
                                                                </div>
                                                                <div class="meta-item">
                                                                    <i class="fas fa-clock"></i>
                                                                    <span>{{ $item->duration }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="exam-instructor-section">
                                                            <div class="instructor-info">
                                                                <div class="instructor-avatar">
                                                                    <i class="fas fa-user-graduate"></i>
                                                                </div>
                                                                <div class="instructor-name">{{ $item->instructor_name }}</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="exam-actions">
                                                            <a href="{{ asset($item->exam_document) }}" download class="action-btn primary" title="Download Exam Paper">
                                                                <i class="fas fa-download"></i>
                                                            </a>
                                                            @if($item->answer_key)
                                                                <a href="{{ asset($item->answer_key) }}" download class="action-btn secondary" title="Download Answer Key">
                                                                    <i class="fas fa-key"></i>
                                                                </a>
                                                            @endif
                                                        </div>
                                                        
                                                        <div class="exam-status">
                                                            @if($item->is_approve)
                                                                <span class="status-badge approved">
                                                                    <i class="fas fa-check-circle"></i>
                                                                    Approved
                                                                </span>
                                                            @else
                                                                <span class="status-badge pending">
                                                                    <i class="fas fa-clock"></i>
                                                                    Pending
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="clean-empty-state">
                                                <i class="icofont-document"></i>
                                                <p>No exams uploaded yet</p>
                                                <a href="{{route('dashboard.create')}}" class="clean-upload-btn">
                                                    Upload First Exam
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endunless
                    @endauth
                </div>
            </div>


        </div>
    </div>

</div>

<script>
// Simple success message function for downloads
function showDownloadSuccess(message) {
    // Create a simple success notification
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        z-index: 9999;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    
    // Add animation CSS
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideIn {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
    
    // Add slideOut animation
    const slideOutStyle = document.createElement('style');
    slideOutStyle.textContent = `
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
    `;
    document.head.appendChild(slideOutStyle);
}

// Add click event listeners to download buttons
document.addEventListener('DOMContentLoaded', function() {
    const downloadButtons = document.querySelectorAll('.download-btn, .key-btn');
    
    downloadButtons.forEach(button => {
        button.addEventListener('click', function() {
            const isAnswerKey = this.classList.contains('key-btn');
            const message = isAnswerKey ? 'Answer key download started!' : 'Exam download started!';
            showDownloadSuccess(message);
        });
    });

    // Welcome Popup with Sound
    const welcomePopup = document.getElementById('welcomePopup');
    if (welcomePopup) {
        // Create and play success sound (same as memo popup)
        playWelcomeSuccessSound();
        
        // Auto hide popup after 10 seconds unless user interaction
        let autoHideTimer = setTimeout(() => {
            closeWelcomePopup();
        }, 10000);
        
        // Clear auto-hide timer if user hovers over popup
        welcomePopup.addEventListener('mouseenter', () => {
            clearTimeout(autoHideTimer);
        });
        
        // Restart auto-hide timer when user stops hovering
        welcomePopup.addEventListener('mouseleave', () => {
            autoHideTimer = setTimeout(() => {
                closeWelcomePopup();
            }, 5000);
        });
        
        // Close popup when clicking outside
        welcomePopup.addEventListener('click', (e) => {
            if (e.target === welcomePopup) {
                closeWelcomePopup();
            }
        });
        
        // Close popup with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && welcomePopup) {
                closeWelcomePopup();
            }
        });
    }
});

// Welcome Popup Functions
function closeWelcomePopup() {
    const popup = document.getElementById('welcomePopup');
    if (popup) {
        popup.style.animation = 'popupFadeOut 0.5s ease-in forwards';
        setTimeout(() => {
            popup.remove();
        }, 500);
    }
}

// Initialize loading animations for login popup
function initializeLoginAnimations() {
    const loginSpinner = document.getElementById('loginSpinner');
    const loginCheck = document.getElementById('loginCheck');
    const securitySpinner = document.getElementById('securitySpinner');
    const securityCheck = document.getElementById('securityCheck');
    
    if (loginSpinner && loginCheck && securitySpinner && securityCheck) {
        // First message completes after 2 seconds
        setTimeout(() => {
            loginSpinner.style.display = 'none';
            loginCheck.style.display = 'flex';
        }, 2000);
        
        // Second message completes after 4 seconds (2 seconds after first)
        setTimeout(() => {
            securitySpinner.style.display = 'none';
            securityCheck.style.display = 'flex';
        }, 4000);
    }
}

// Initialize animations when popup loads
document.addEventListener('DOMContentLoaded', function() {
    // Check if welcome popup exists and initialize animations
    const welcomePopup = document.getElementById('welcomePopup');
    if (welcomePopup) {
        initializeLoginAnimations();
    }
});

function playWelcomeSuccessSound() {
    // Create success sound using Web Audio API (same as memo popup)
    try {
        const audioContext = new (window.AudioContext || window.webkitAudioContext)();
        
        // Success notification sound sequence
        const successTune = [
            { freq: 523.25, duration: 0.2 }, // C5
            { freq: 659.25, duration: 0.2 }, // E5
            { freq: 783.99, duration: 0.2 }, // G5
            { freq: 1046.50, duration: 0.4 } // C6
        ];
        
        let startTime = audioContext.currentTime;
        
        successTune.forEach((note, index) => {
            const oscillator = audioContext.createOscillator();
            const gainNode = audioContext.createGain();
            
            oscillator.connect(gainNode);
            gainNode.connect(audioContext.destination);
            
            oscillator.frequency.value = note.freq;
            oscillator.type = 'sine';
            
            // Envelope for smooth sound
            gainNode.gain.setValueAtTime(0, startTime);
            gainNode.gain.linearRampToValueAtTime(0.3, startTime + 0.05);
            gainNode.gain.exponentialRampToValueAtTime(0.01, startTime + note.duration);
            
            oscillator.start(startTime);
            oscillator.stop(startTime + note.duration);
            
            startTime += note.duration;
        });
        
        // Add celebratory bell sound
        setTimeout(() => {
            const bellOscillator = audioContext.createOscillator();
            const bellGain = audioContext.createGain();
            
            bellOscillator.connect(bellGain);
            bellGain.connect(audioContext.destination);
            
            bellOscillator.frequency.value = 2093; // C7
            bellOscillator.type = 'triangle';
            
            bellGain.gain.setValueAtTime(0, audioContext.currentTime);
            bellGain.gain.linearRampToValueAtTime(0.2, audioContext.currentTime + 0.02);
            bellGain.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.8);
            
            bellOscillator.start();
            bellOscillator.stop(audioContext.currentTime + 0.8);
        }, 800);
        
    } catch (error) {
        console.log('Audio not supported or blocked by browser');
        // Fallback: use notification sound if available
        if ('speechSynthesis' in window) {
            // Create a subtle beep using speech synthesis as fallback
            const utterance = new SpeechSynthesisUtterance('');
            utterance.volume = 0.1;
            utterance.rate = 10;
            utterance.pitch = 2;
            speechSynthesis.speak(utterance);
        }
    }
}
</script>

@endsection
