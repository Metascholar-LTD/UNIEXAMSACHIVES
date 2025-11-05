@extends('super-admin.layout')

@section('title', 'Dashboard')

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
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('super-admin.subscriptions.create') }}" class="btn btn-primary w-100">
                                <i class="icofont-plus-circle"></i> New Subscription
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('super-admin.subscriptions.index') }}" class="btn btn-info w-100">
                                <i class="icofont-list"></i> All Subscriptions
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('super-admin.payments.index') }}" class="btn btn-success w-100">
                                <i class="icofont-money"></i> Payments
                            </a>
                        </div>
                        <div class="col-md-3 mb-2">
                            <a href="{{ route('super-admin.settings.index') }}" class="btn btn-warning w-100">
                                <i class="icofont-settings-alt"></i> Settings
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
