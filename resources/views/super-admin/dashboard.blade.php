@extends('super-admin.layout')

@section('title', 'Dashboard')

@push('styles')
<style>
    /* Modern Button Component Styles - Whitish Grey Theme */
    .modern-action-button {
        position: relative;
        overflow: hidden;
        border: 2px solid rgba(229, 231, 235, 0.6);
        cursor: pointer;
        transition: all 0.5s ease-out;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        text-decoration: none;
        display: block;
        width: 100%;
        padding: 1rem;
        border-radius: 1rem;
        background: linear-gradient(to bottom right, rgba(249, 250, 251, 0.95), rgba(243, 244, 246, 0.95), rgba(249, 250, 251, 0.95));
    }

    .modern-action-button:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: scale(1.02) translateY(-4px);
        border-color: rgba(209, 213, 219, 0.8);
    }

    .modern-action-button:active {
        transform: scale(0.95);
    }

    /* Moving gradient layer */
    .modern-action-button::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.5), transparent);
        transform: translateX(-100%);
        transition: transform 1s ease-out;
        z-index: 1;
    }

    .modern-action-button:hover::before {
        transform: translateX(100%);
    }

    /* Overlay glow */
    .modern-action-button::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 1rem;
        background: linear-gradient(to right, rgba(255, 255, 255, 0.3), rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.3));
        opacity: 0;
        transition: opacity 0.5s;
        z-index: 1;
    }

    .modern-action-button:hover::after {
        opacity: 1;
    }

    /* Content wrapper */
    .modern-button-content {
        position: relative;
        z-index: 10;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    /* Icon container - default grey */
    .modern-button-icon {
        padding: 0.75rem;
        border-radius: 0.5rem;
        background: linear-gradient(to bottom right, rgba(229, 231, 235, 0.8), rgba(243, 244, 246, 0.6));
        backdrop-filter: blur(4px);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-action-button:hover .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(209, 213, 219, 0.9), rgba(229, 231, 235, 0.7));
    }

    /* Colorful icon containers - Primary (Indigo) */
    .button-icon-primary .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(99, 102, 241, 0.5), rgba(129, 140, 248, 0.3));
    }

    .button-icon-primary:hover .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(129, 140, 248, 0.6), rgba(99, 102, 241, 0.4));
    }

    /* Colorful icon containers - Info (Blue) */
    .button-icon-info .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(59, 130, 246, 0.5), rgba(96, 165, 250, 0.3));
    }

    .button-icon-info:hover .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(96, 165, 250, 0.6), rgba(59, 130, 246, 0.4));
    }

    /* Colorful icon containers - Success (Green) */
    .button-icon-success .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(34, 197, 94, 0.5), rgba(74, 222, 128, 0.3));
    }

    .button-icon-success:hover .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(74, 222, 128, 0.6), rgba(34, 197, 94, 0.4));
    }

    /* Colorful icon containers - Warning (Yellow) */
    .button-icon-warning .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(234, 179, 8, 0.5), rgba(250, 204, 21, 0.3));
    }

    .button-icon-warning:hover .modern-button-icon {
        background: linear-gradient(to bottom right, rgba(250, 204, 21, 0.6), rgba(234, 179, 8, 0.4));
    }

    /* Icon SVG and Icon Fonts - default grey */
    .modern-button-icon svg,
    .modern-button-icon i {
        width: 1.75rem;
        height: 1.75rem;
        color: #374151;
        transition: all 0.3s;
        font-size: 1.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-action-button:hover .modern-button-icon svg,
    .modern-action-button:hover .modern-button-icon i {
        color: #1f2937;
        transform: scale(1.1);
    }

    /* Icon SVG and Icon Fonts - white for colorful icon containers */
    .button-icon-primary .modern-button-icon svg,
    .button-icon-primary .modern-button-icon i,
    .button-icon-info .modern-button-icon svg,
    .button-icon-info .modern-button-icon i,
    .button-icon-success .modern-button-icon svg,
    .button-icon-success .modern-button-icon i,
    .button-icon-warning .modern-button-icon svg,
    .button-icon-warning .modern-button-icon i {
        color: white;
    }

    .button-icon-primary:hover .modern-button-icon svg,
    .button-icon-primary:hover .modern-button-icon i,
    .button-icon-info:hover .modern-button-icon svg,
    .button-icon-info:hover .modern-button-icon i,
    .button-icon-success:hover .modern-button-icon svg,
    .button-icon-success:hover .modern-button-icon i,
    .button-icon-warning:hover .modern-button-icon svg,
    .button-icon-warning:hover .modern-button-icon i {
        color: rgba(255, 255, 255, 0.9);
        transform: scale(1.1);
    }

    /* Text container */
    .modern-button-text {
        flex: 1;
        text-align: left;
    }

    .modern-button-title {
        color: #1f2937;
        font-weight: 700;
        font-size: 1.125rem;
        margin: 0;
        transition: color 0.3s;
    }

    .modern-action-button:hover .modern-button-title {
        color: #111827;
    }

    .modern-button-subtitle {
        color: #6b7280;
        font-size: 0.875rem;
        margin: 0;
        transition: color 0.3s;
    }

    .modern-action-button:hover .modern-button-subtitle {
        color: #4b5563;
    }

    /* Arrow */
    .modern-button-arrow {
        opacity: 0.4;
        transition: all 0.3s;
    }

    .modern-action-button:hover .modern-button-arrow {
        opacity: 1;
        transform: translateX(4px);
    }

    .modern-button-arrow svg {
        width: 1.25rem;
        height: 1.25rem;
        color: #374151;
    }

    /* Size variants */
    .modern-button-sm {
        padding: 0.75rem;
        border-radius: 0.75rem;
    }

    .modern-button-md {
        padding: 1rem;
        border-radius: 1rem;
    }

    .modern-button-lg {
        padding: 1.5rem;
        border-radius: 1.5rem;
    }

</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-1"><i class="icofont-dashboard-web"></i> Dashboard</h2>
            <p class="text-muted">Complete system overview and management</p>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row">
        {{-- Subscriptions Card --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="opacity: 0.9; margin-bottom: 10px;">Active Subscriptions</h6>
                            <h2 style="font-weight: 700; margin: 0;">{{ $stats['active_subscriptions'] }}</h2>
                            <small style="opacity: 0.8;">Total: {{ $stats['total_subscriptions'] }}</small>
                        </div>
                        <div>
                            <i class="icofont-tasks-alt" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue Card --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="opacity: 0.9; margin-bottom: 10px;">Monthly Revenue</h6>
                            <h2 style="font-weight: 700; margin: 0;">GHS {{ number_format($stats['monthly_revenue'], 2) }}</h2>
                            <small style="opacity: 0.8;">Total: GHS {{ number_format($stats['total_revenue'], 2) }}</small>
                        </div>
                        <div>
                            <i class="icofont-money" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Expiring Soon Card --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="opacity: 0.9; margin-bottom: 10px;">Expiring Soon</h6>
                            <h2 style="font-weight: 700; margin: 0;">{{ $stats['expiring_soon'] }}</h2>
                            <small style="opacity: 0.8;">Next 30 days</small>
                        </div>
                        <div>
                            <i class="icofont-warning-alt" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Payments Card --}}
        <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
            <div class="card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 style="opacity: 0.9; margin-bottom: 10px;">Successful Payments</h6>
                            <h2 style="font-weight: 700; margin: 0;">{{ $stats['successful_payments'] }}</h2>
                            <small style="opacity: 0.8;">Pending: {{ $stats['pending_payments'] }}</small>
                        </div>
                        <div>
                            <i class="icofont-credit-card" style="font-size: 50px; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="icofont-lightning-ray"></i> Quick Actions
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.subscriptions.create') }}" class="modern-action-button modern-button-md button-icon-primary">
                                <div class="modern-button-content">
                                    <div class="modern-button-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14"></path>
                                            <path d="M12 5v14"></path>
                                        </svg>
                                    </div>
                                    <div class="modern-button-text">
                                        <p class="modern-button-title">New Subscription</p>
                                        <p class="modern-button-subtitle">Create new subscription</p>
                                    </div>
                                    <div class="modern-button-arrow">
                                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.subscriptions.index') }}" class="modern-action-button modern-button-md button-icon-info">
                                <div class="modern-button-content">
                                    <div class="modern-button-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="8" y1="6" x2="21" y2="6"></line>
                                            <line x1="8" y1="12" x2="21" y2="12"></line>
                                            <line x1="8" y1="18" x2="21" y2="18"></line>
                                            <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                            <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                            <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                        </svg>
                                    </div>
                                    <div class="modern-button-text">
                                        <p class="modern-button-title">All Subscriptions</p>
                                        <p class="modern-button-subtitle">View all subscriptions</p>
                                    </div>
                                    <div class="modern-button-arrow">
                                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.payments.index') }}" class="modern-action-button modern-button-md button-icon-success">
                                <div class="modern-button-content">
                                    <div class="modern-button-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                                            <line x1="1" y1="10" x2="23" y2="10"></line>
                                        </svg>
                                    </div>
                                    <div class="modern-button-text">
                                        <p class="modern-button-title">Payments</p>
                                        <p class="modern-button-subtitle">Manage payments</p>
                                    </div>
                                    <div class="modern-button-arrow">
                                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('super-admin.settings.index') }}" class="modern-action-button modern-button-md button-icon-warning">
                                <div class="modern-button-content">
                                    <div class="modern-button-icon">
                                        <i class="icofont-settings-alt"></i>
                                    </div>
                                    <div class="modern-button-text">
                                        <p class="modern-button-title">Settings</p>
                                        <p class="modern-button-subtitle">System settings</p>
                                    </div>
                                    <div class="modern-button-arrow">
                                        <svg viewBox="0 0 24 24" stroke="currentColor" fill="none">
                                            <path d="M9 5l7 7-7 7" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"></path>
                                        </svg>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Alerts Section --}}
    @if($expiringSubscriptions->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning">
                <h5><i class="icofont-warning"></i> Expiring Subscriptions Alert</h5>
                <p>{{ $expiringSubscriptions->count() }} subscription(s) expiring in the next 14 days:</p>
                <ul class="mb-0">
                    @foreach($expiringSubscriptions->take(5) as $sub)
                    <li>
                        <strong>{{ $sub->institution_name }}</strong> - 
                        Expires: {{ $sub->subscription_end_date->format('M d, Y') }} 
                        ({{ $sub->days_until_expiry }} days)
                        <a href="{{ route('super-admin.subscriptions.show', $sub->id) }}" class="btn btn-sm btn-warning ml-2">View</a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif

    {{-- Main Content Grid --}}
    <div class="row">
        {{-- Recent Subscriptions --}}
        <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="icofont-list"></i> Recent Subscriptions
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentSubscriptions as $subscription)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #eee;">
                        <div>
                            <h6 class="mb-1">{{ $subscription->institution_name }}</h6>
                            <small class="text-muted">
                                <span class="badge badge-{{ $subscription->status_badge_color }}">{{ ucfirst($subscription->status) }}</span>
                                {{ $subscription->subscription_plan }}
                            </small>
                        </div>
                        <div class="text-right">
                            <strong>{{ $subscription->formatted_renewal_amount }}</strong><br>
                            <small class="text-muted">{{ $subscription->subscription_end_date->format('M d, Y') }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">No subscriptions yet</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="col-xl-6 col-lg-6 col-md-12 mb-4">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <i class="icofont-credit-card"></i> Recent Payments
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @forelse($recentPayments as $payment)
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid #eee;">
                        <div>
                            <h6 class="mb-1">{{ $payment->subscription->institution_name ?? 'N/A' }}</h6>
                            <small class="text-muted">
                                <span class="badge badge-{{ $payment->status_badge_color }}">{{ ucfirst($payment->status) }}</span>
                                {{ $payment->created_at->format('M d, Y H:i') }}
                            </small>
                        </div>
                        <div class="text-right">
                            <strong>{{ $payment->formatted_amount }}</strong><br>
                            <small class="text-muted">{{ $payment->payment_method_display }}</small>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted text-center">No payments yet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Upcoming Maintenance --}}
    @if($upcomingMaintenance->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <i class="icofont-tools"></i> Upcoming Maintenance
                </div>
                <div class="card-body">
                    @foreach($upcomingMaintenance as $maintenance)
                    <div class="alert alert-info mb-2">
                        <strong>{{ $maintenance->title }}</strong><br>
                        <small>{{ $maintenance->scheduled_start->format('M d, Y H:i') }} - {{ $maintenance->scheduled_end->format('H:i') }}</small>
                        <span class="badge badge-{{ $maintenance->impact_badge_color }} ml-2">{{ ucfirst($maintenance->impact_level) }} Impact</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
