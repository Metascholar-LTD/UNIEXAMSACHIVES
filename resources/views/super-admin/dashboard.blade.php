@extends('layout.app')

@section('content')
@include('frontend.header')
@include('frontend.theme_shadow')

<div class="dashboardarea sp_bottom_100">
    <div class="container-fluid full__width__padding">
        <div class="row">
            @include('components.create_section')
        </div>
    </div>
    
    <div class="dashboard">
        <div class="container-fluid full__width__padding">
            <div class="row">
                {{-- Sidebar --}}
                @include('components.sidebar')
                
                <div class="col-xl-9 col-lg-9 col-md-12">
                    <div class="dashboard__content__wraper">
                        {{-- Header --}}
                        <div class="dashboard__section__title">
                            <h4><i class="icofont-dashboard-web"></i> Super Admin Dashboard</h4>
                            <p class="text-muted">Complete system overview and management</p>
                        </div>

                        {{-- Statistics Cards --}}
                        <div class="row">
                            {{-- Subscriptions Card --}}
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
                                <div class="dashboard__single__counter" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; padding: 20px;">
                                    <div class="counterarea__text__wraper" style="color: white;">
                                        <div class="counter__img">
                                            <i class="icofont-tasks-alt" style="font-size: 40px; opacity: 0.9;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['active_subscriptions'] }}</span>
                                            </div>
                                            <p>Active Subscriptions</p>
                                            <small style="opacity: 0.8;">Total: {{ $stats['total_subscriptions'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Revenue Card --}}
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
                                <div class="dashboard__single__counter" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; padding: 20px;">
                                    <div class="counterarea__text__wraper" style="color: white;">
                                        <div class="counter__img">
                                            <i class="icofont-money" style="font-size: 40px; opacity: 0.9;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span>GHS {{ number_format($stats['monthly_revenue'], 2) }}</span>
                                            </div>
                                            <p>Monthly Revenue</p>
                                            <small style="opacity: 0.8;">Total: GHS {{ number_format($stats['total_revenue'], 2) }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Expiring Soon Card --}}
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
                                <div class="dashboard__single__counter" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 10px; padding: 20px;">
                                    <div class="counterarea__text__wraper" style="color: white;">
                                        <div class="counter__img">
                                            <i class="icofont-warning-alt" style="font-size: 40px; opacity: 0.9;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['expiring_soon'] }}</span>
                                            </div>
                                            <p>Expiring Soon</p>
                                            <small style="opacity: 0.8;">Next 30 days</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Payments Card --}}
                            <div class="col-xl-3 col-lg-6 col-md-6 col-12 mb-4">
                                <div class="dashboard__single__counter" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px; padding: 20px;">
                                    <div class="counterarea__text__wraper" style="color: white;">
                                        <div class="counter__img">
                                            <i class="icofont-credit-card" style="font-size: 40px; opacity: 0.9;"></i>
                                        </div>
                                        <div class="counter__content__wraper">
                                            <div class="counter__number">
                                                <span class="counter">{{ $stats['successful_payments'] }}</span>
                                            </div>
                                            <p>Successful Payments</p>
                                            <small style="opacity: 0.8;">Pending: {{ $stats['pending_payments'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Quick Actions --}}
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h5 class="mb-3"><i class="icofont-lightning-ray"></i> Quick Actions</h5>
                                        <div class="row">
                                            <div class="col-md-3 mb-2">
                                                <a href="{{ route('super-admin.subscriptions.create') }}" class="btn btn-primary btn-block">
                                                    <i class="icofont-plus-circle"></i> New Subscription
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <a href="{{ route('super-admin.subscriptions.index') }}" class="btn btn-info btn-block">
                                                    <i class="icofont-list"></i> All Subscriptions
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <a href="{{ route('super-admin.payments.index') }}" class="btn btn-success btn-block">
                                                    <i class="icofont-money"></i> Payments
                                                </a>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <a href="{{ route('super-admin.settings.index') }}" class="btn btn-warning btn-block">
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
                                <div class="alert alert-warning shadow-sm">
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
                                <div class="card shadow-sm">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0"><i class="icofont-list"></i> Recent Subscriptions</h5>
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
                                <div class="card shadow-sm">
                                    <div class="card-header bg-success text-white">
                                        <h5 class="mb-0"><i class="icofont-credit-card"></i> Recent Payments</h5>
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
                                <div class="card shadow-sm">
                                    <div class="card-header bg-info text-white">
                                        <h5 class="mb-0"><i class="icofont-tools"></i> Upcoming Maintenance</h5>
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
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border: none;
    border-radius: 10px;
}
.card-header {
    border-radius: 10px 10px 0 0 !important;
}
.btn-block {
    width: 100%;
    padding: 10px;
    font-weight: 500;
}
.counter__number {
    font-size: 28px;
    font-weight: bold;
    margin: 10px 0;
}
</style>

@endsection

