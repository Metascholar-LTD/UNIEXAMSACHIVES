@php
    // Don't show subscription widget for super admins
    if (auth()->check() && auth()->user()->isSuperAdmin()) {
        $subscription = null;
    } else {
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
    }
    
    // Determine status colors
    $statusColors = [
        'active' => ['bg' => '#10b981', 'light' => '#d1fae5', 'border' => '#34d399'],
        'expiring_soon' => ['bg' => '#f59e0b', 'light' => '#fef3c7', 'border' => '#fbbf24'],
        'expired' => ['bg' => '#ef4444', 'light' => '#fee2e2', 'border' => '#f87171'],
        'suspended' => ['bg' => '#dc2626', 'light' => '#fecaca', 'border' => '#ef4444']
    ];
    
    $currentStatus = $subscription ? $subscription->status : 'active';
    $colors = $statusColors[$currentStatus] ?? $statusColors['active'];
@endphp

@if($subscription)
<div class="modern-subscription-card mb-4">
    <div class="subscription-header">
        <div class="header-left">
            <div class="icon-wrapper" style="background: {{ $colors['light'] }}; border-color: {{ $colors['border'] }};">
                <i class="icofont-ui-calendar" style="color: {{ $colors['bg'] }};"></i>
            </div>
            <div class="header-text">
                <h3 class="subscription-title">Subscription Status</h3>
                <p class="subscription-subtitle">Monitor your account</p>
            </div>
        </div>
        <div class="status-badge" style="background: {{ $colors['light'] }}; border-color: {{ $colors['border'] }};">
            <span style="color: {{ $colors['bg'] }};">{{ ucfirst(str_replace('_', ' ', $subscription->status)) }}</span>
        </div>
    </div>

    {{-- Status Alert Box --}}
    <div class="status-alert-box" style="background: {{ $colors['light'] }}; border-left-color: {{ $colors['bg'] }};">
        <div class="alert-icon" style="color: {{ $colors['bg'] }};">
            @if($subscription->status === 'active')
                <i class="icofont-check-circled"></i>
            @elseif($subscription->status === 'expiring_soon')
                <i class="icofont-warning"></i>
            @elseif($subscription->status === 'expired' && $subscription->is_in_grace_period)
                <i class="icofont-error"></i>
            @elseif($subscription->status === 'suspended')
                <i class="icofont-ban"></i>
            @endif
        </div>
        <div class="alert-content">
            @if($subscription->status === 'active')
                <h4 style="color: {{ $colors['bg'] }};">All Systems Active</h4>
                <p>Your subscription is active and all features are available.</p>
            @elseif($subscription->status === 'expiring_soon')
                <h4 style="color: {{ $colors['bg'] }};">Action Required</h4>
                <p>Your subscription expires in <strong>{{ $subscription->days_until_expiry }} {{ $subscription->days_until_expiry === 1 ? 'day' : 'days' }}</strong>. Renew now to avoid interruption.</p>
            @elseif($subscription->status === 'expired' && $subscription->is_in_grace_period)
                <h4 style="color: {{ $colors['bg'] }};">Grace Period Active</h4>
                <p>Your subscription has expired. You have <strong>{{ $subscription->grace_period_days }} days</strong> grace period remaining.</p>
            @elseif($subscription->status === 'suspended')
                <h4 style="color: {{ $colors['bg'] }};">Account Suspended</h4>
                <p>Your subscription has been suspended. Please renew immediately to restore access.</p>
            @endif
        </div>
    </div>

    {{-- Subscription Details Grid --}}
    <div class="subscription-details-grid">
        <div class="detail-item">
            <div class="detail-icon">
                <i class="icofont-certificate"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Plan Type</span>
                <span class="detail-value">{{ ucfirst($subscription->subscription_plan) }}</span>
            </div>
        </div>
        
        <div class="detail-item">
            <div class="detail-icon">
                <i class="icofont-refresh"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Renewal Cycle</span>
                <span class="detail-value">{{ ucfirst(str_replace('_', ' ', $subscription->renewal_cycle)) }}</span>
            </div>
        </div>
        
        <div class="detail-item">
            <div class="detail-icon">
                <i class="icofont-calendar"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Expires On</span>
                <span class="detail-value">{{ $subscription->subscription_end_date->format('M d, Y') }}</span>
            </div>
        </div>
        
        <div class="detail-item">
            <div class="detail-icon">
                <i class="icofont-cur-dollar"></i>
            </div>
            <div class="detail-content">
                <span class="detail-label">Renewal Amount</span>
                <span class="detail-value">{{ $subscription->formatted_renewal_amount }}</span>
            </div>
        </div>
    </div>

    {{-- Progress Section --}}
    @if($subscription->status !== 'suspended')
    @php
        $totalDays = $subscription->subscription_start_date->diffInDays($subscription->subscription_end_date);
        $daysElapsed = $subscription->subscription_start_date->diffInDays(now());
        $progress = $totalDays > 0 ? min(100, ($daysElapsed / $totalDays) * 100) : 0;
        $progressColor = $progress > 90 ? '#ef4444' : ($progress > 75 ? '#f59e0b' : '#10b981');
    @endphp
    <div class="progress-section">
        <div class="progress-header">
            <span class="progress-label">Subscription Period</span>
            <span class="progress-percentage">{{ number_format($progress, 1) }}% elapsed</span>
        </div>
        <div class="modern-progress-bar">
            <div class="progress-fill" style="width: {{ $progress }}%; background: {{ $progressColor }};"></div>
        </div>
        <div class="progress-dates">
            <span class="date-text">{{ $subscription->subscription_start_date->format('M d, Y') }}</span>
            <span class="date-text">{{ $subscription->subscription_end_date->format('M d, Y') }}</span>
        </div>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="subscription-actions">
        @if($subscription->status === 'active' || $subscription->status === 'expiring_soon')
            @if(auth()->user()->isAdmin())
            <a href="{{ route('super-admin.subscriptions.show', $subscription->id) }}" class="modern-btn btn-secondary">
                <i class="icofont-eye"></i>
                <span>View Details</span>
            </a>
            <a href="{{ route('super-admin.subscriptions.renew', $subscription->id) }}" class="modern-btn btn-primary">
                <i class="icofont-refresh"></i>
                <span>Renew Now</span>
            </a>
            @endif
        @elseif($subscription->status === 'expired' || $subscription->status === 'suspended')
            @if(auth()->user()->isAdmin())
            <a href="{{ route('super-admin.subscriptions.renew', $subscription->id) }}" class="modern-btn btn-danger btn-block">
                <i class="icofont-refresh"></i>
                <span>Renew Immediately</span>
            </a>
            @else
            <div class="contact-admin-notice">
                <i class="icofont-info-circle"></i>
                <span>Please contact your administrator to renew the subscription.</span>
            </div>
            @endif
        @endif
    </div>

    {{-- Auto-Renewal Badge --}}
    @if($subscription->auto_renewal)
    <div class="auto-renewal-badge">
        <i class="icofont-check-circled"></i>
        <span>Auto-renewal enabled</span>
    </div>
    @endif
</div>
@endif

<style>
/* Modern Subscription Card Styles */
.modern-subscription-card {
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid #e9ecef;
}

.modern-subscription-card:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06), 0 4px 8px rgba(0, 0, 0, 0.04);
    transform: translateY(-2px);
}

/* Header Section */
.subscription-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 24px;
    border-bottom: 1px solid #f0f1f3;
    background: #fafbfc;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.icon-wrapper {
    width: 56px;
    height: 56px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid;
    transition: all 0.3s ease;
}

.icon-wrapper i {
    font-size: 28px;
}

.modern-subscription-card:hover .icon-wrapper {
    transform: scale(1.05);
}

.header-text {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.subscription-title {
    margin: 0;
    font-size: 20px;
    font-weight: 700;
    color: #212529;
    letter-spacing: -0.025em;
}

.subscription-subtitle {
    margin: 0;
    font-size: 14px;
    color: #6c757d;
    font-weight: 400;
}

.status-badge {
    padding: 10px 20px;
    border-radius: 12px;
    border: 2px solid;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.025em;
    transition: all 0.3s ease;
}

.status-badge:hover {
    transform: scale(1.05);
}

/* Status Alert Box */
.status-alert-box {
    margin: 24px;
    padding: 20px;
    border-radius: 12px;
    border-left: 4px solid;
    display: flex;
    gap: 16px;
    align-items: flex-start;
    transition: all 0.3s ease;
}

.status-alert-box:hover {
    transform: translateX(4px);
}

.alert-icon {
    font-size: 28px;
    line-height: 1;
    margin-top: 2px;
}

.alert-content {
    flex: 1;
}

.alert-content h4 {
    margin: 0 0 6px 0;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: -0.025em;
}

.alert-content p {
    margin: 0;
    font-size: 14px;
    color: #495057;
    line-height: 1.6;
}

/* Subscription Details Grid */
.subscription-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 12px;
    margin: 0 24px;
}

.detail-item {
    background: #fafbfc;
    padding: 20px;
    display: flex;
    gap: 16px;
    align-items: center;
    transition: all 0.3s ease;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.detail-item:hover {
    background: #ffffff;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    transform: translateY(-2px);
}

.detail-icon {
    width: 44px;
    height: 44px;
    background: #f8f9fa;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: #6c757d;
    border: 1px solid #e9ecef;
}

.detail-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.detail-label {
    font-size: 12px;
    color: #6c757d;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.detail-value {
    font-size: 15px;
    color: #212529;
    font-weight: 600;
}

/* Progress Section */
.progress-section {
    padding: 24px;
    background: #fafbfc;
    margin: 24px;
    border-radius: 12px;
    border: 1px solid #e9ecef;
}

.progress-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.progress-label {
    font-size: 14px;
    color: #495057;
    font-weight: 600;
}

.progress-percentage {
    font-size: 14px;
    color: #6c757d;
    font-weight: 600;
}

.modern-progress-bar {
    height: 12px;
    background: #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    position: relative;
}

.progress-fill {
    height: 100%;
    border-radius: 12px;
    transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.progress-fill::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

.progress-dates {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
}

.date-text {
    font-size: 12px;
    color: #6c757d;
    font-weight: 500;
}

/* Action Buttons */
.subscription-actions {
    padding: 24px;
    display: flex;
    gap: 12px;
    border-top: 1px solid #f0f1f3;
    background: #fafbfc;
}

.modern-btn {
    flex: 1;
    padding: 14px 24px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    letter-spacing: 0.025em;
}

.modern-btn i {
    font-size: 18px;
}

.btn-primary {
    background: #3b82f6;
    color: #ffffff;
}

.btn-primary:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    color: #ffffff;
}

.btn-secondary {
    background: #ffffff;
    color: #495057;
    border: 1px solid #dee2e6;
}

.btn-secondary:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    color: #212529;
    border-color: #ced4da;
}

.btn-danger {
    background: #ef4444;
    color: #ffffff;
}

.btn-danger:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
    color: #ffffff;
}

.btn-block {
    width: 100%;
}

.contact-admin-notice {
    width: 100%;
    padding: 16px;
    background: #fef2f2;
    border-radius: 10px;
    color: #991b1b;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 14px;
}

.contact-admin-notice i {
    font-size: 20px;
}

/* Auto-Renewal Badge */
.auto-renewal-badge {
    margin: 0 24px 24px;
    padding: 12px 16px;
    background: #d1fae5;
    border-radius: 10px;
    color: #065f46;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    font-weight: 600;
}

.auto-renewal-badge i {
    font-size: 16px;
}

/* Responsive Design */
@media (max-width: 768px) {
    .subscription-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .status-badge {
        align-self: flex-start;
    }
    
    .subscription-details-grid {
        grid-template-columns: 1fr;
    }
    
    .subscription-actions {
        flex-direction: column;
    }
    
    .modern-btn {
        width: 100%;
    }
}
</style>

