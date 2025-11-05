@php
    $subscription = \App\Models\SystemSubscription::active()->first();
    if (!$subscription) {
        $subscription = \App\Models\SystemSubscription::where('status', 'expired')
            ->where(function($q) {
                $q->whereRaw('DATE_ADD(subscription_end_date, INTERVAL grace_period_days DAY) >= CURDATE()');
            })
            ->first();
    }
    if (!$subscription) {
        $subscription = \App\Models\SystemSubscription::latest()->first();
    }
@endphp

@if($subscription)
<div class="card shadow-sm mb-4" style="border-left: 5px solid {{ $subscription->status === 'active' ? '#28a745' : ($subscription->status === 'expiring_soon' ? '#ffc107' : '#dc3545') }};">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <i class="icofont-ui-calendar"></i> Subscription Status
            </h5>
            <span class="badge badge-{{ $subscription->status_badge_color }} badge-pill">
                {{ ucfirst(str_replace('_', ' ', $subscription->status)) }}
            </span>
        </div>

        {{-- Status Message --}}
        @if($subscription->status === 'active')
            <div class="alert alert-success mb-3">
                <i class="icofont-check-circled"></i> 
                <strong>Active</strong> - Your subscription is active and all features are available.
            </div>
        @elseif($subscription->status === 'expiring_soon')
            <div class="alert alert-warning mb-3">
                <i class="icofont-warning"></i> 
                <strong>Expiring Soon!</strong> Your subscription expires in {{ $subscription->days_until_expiry }} {{ $subscription->days_until_expiry === 1 ? 'day' : 'days' }}.
            </div>
        @elseif($subscription->status === 'expired' && $subscription->is_in_grace_period)
            <div class="alert alert-danger mb-3">
                <i class="icofont-error"></i> 
                <strong>Expired - Grace Period</strong> Your subscription expired. {{ $subscription->grace_period_days }} days grace period active.
            </div>
        @elseif($subscription->status === 'suspended')
            <div class="alert alert-danger mb-3">
                <i class="icofont-ban"></i> 
                <strong>Suspended</strong> Your subscription has been suspended. Please renew immediately.
            </div>
        @endif

        {{-- Subscription Details --}}
        <div class="row">
            <div class="col-md-6">
                <p class="mb-2">
                    <strong>Plan:</strong> 
                    <span class="badge badge-info">{{ ucfirst($subscription->subscription_plan) }}</span>
                </p>
                <p class="mb-2">
                    <strong>Renewal Cycle:</strong> 
                    {{ ucfirst(str_replace('_', ' ', $subscription->renewal_cycle)) }}
                </p>
            </div>
            <div class="col-md-6">
                <p class="mb-2">
                    <strong>Expires:</strong> 
                    {{ $subscription->subscription_end_date->format('M d, Y') }}
                </p>
                <p class="mb-2">
                    <strong>Renewal Amount:</strong> 
                    {{ $subscription->formatted_renewal_amount }}
                </p>
            </div>
        </div>

        {{-- Progress Bar --}}
        @if($subscription->status !== 'suspended')
        @php
            $totalDays = $subscription->subscription_start_date->diffInDays($subscription->subscription_end_date);
            $daysElapsed = $subscription->subscription_start_date->diffInDays(now());
            $progress = $totalDays > 0 ? min(100, ($daysElapsed / $totalDays) * 100) : 0;
            $progressColor = $progress > 90 ? 'danger' : ($progress > 75 ? 'warning' : 'success');
        @endphp
        <div class="mt-3">
            <div class="d-flex justify-content-between mb-1">
                <small class="text-muted">Subscription Period</small>
                <small class="text-muted">{{ number_format($progress, 1) }}% elapsed</small>
            </div>
            <div class="progress" style="height: 10px;">
                <div class="progress-bar bg-{{ $progressColor }}" role="progressbar" 
                     style="width: {{ $progress }}%;" 
                     aria-valuenow="{{ $progress }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                </div>
            </div>
        </div>
        @endif

        {{-- Action Buttons --}}
        <div class="mt-3">
            @if($subscription->status === 'active' || $subscription->status === 'expiring_soon')
                @if(auth()->user()->isAdmin())
                <a href="{{ route('super-admin.subscriptions.show', $subscription->id) }}" class="btn btn-primary btn-sm">
                    <i class="icofont-eye"></i> View Details
                </a>
                <a href="{{ route('super-admin.subscriptions.renew', $subscription->id) }}" class="btn btn-success btn-sm">
                    <i class="icofont-refresh"></i> Renew Now
                </a>
                @endif
            @elseif($subscription->status === 'expired' || $subscription->status === 'suspended')
                @if(auth()->user()->isAdmin())
                <a href="{{ route('super-admin.subscriptions.renew', $subscription->id) }}" class="btn btn-danger btn-block">
                    <i class="icofont-refresh"></i> Renew Immediately - Avoid Service Interruption
                </a>
                @else
                <p class="text-danger mb-0">
                    <i class="icofont-info-circle"></i> Please contact your administrator to renew the subscription.
                </p>
                @endif
            @endif
        </div>

        {{-- Auto-Renewal Status --}}
        @if($subscription->auto_renewal)
        <div class="mt-3">
            <small class="text-success">
                <i class="icofont-check-circled"></i> Auto-renewal is enabled
            </small>
        </div>
        @endif
    </div>
</div>
@endif

<style>
.badge-pill {
    padding: 0.5em 0.8em;
    font-size: 0.9em;
}
</style>

