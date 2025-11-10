<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use App\Services\SubscriptionManager;
use App\Services\PaystackService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubscriptionController extends Controller
{
    private SubscriptionManager $subscriptionManager;
    private PaystackService $paystack;

    public function __construct()
    {
        $this->subscriptionManager = new SubscriptionManager();
        $this->paystack = new PaystackService();
    }

    /**
     * Show locked page when no subscription exists
     */
    public function locked()
    {
        // Check if user is admin (role='user') or super admin
        $user = auth()->user();
        $canSubscribe = $user && ($user->isRegularUser() || $user->isSuperAdmin());

        // Get subscription pricing from settings
        $basePrice = (float) SystemSetting::get('subscription_base_price', 5000.00);
        $currency = SystemSetting::get('default_currency', 'GHS');
        
        $monthlyMultiplier = (float) SystemSetting::get('subscription_monthly_multiplier', 0.1);
        $quarterlyMultiplier = (float) SystemSetting::get('subscription_quarterly_multiplier', 0.275);
        $semiAnnualMultiplier = (float) SystemSetting::get('subscription_semi_annual_multiplier', 0.5);

        // Calculate prices for each cycle
        $pricing = [
            'monthly' => [
                'name' => 'Monthly',
                'price' => round($basePrice * $monthlyMultiplier, 2),
                'cycle' => 'monthly',
                'description' => 'Billed monthly',
            ],
            'quarterly' => [
                'name' => 'Quarterly',
                'price' => round($basePrice * $quarterlyMultiplier, 2),
                'cycle' => 'quarterly',
                'description' => 'Billed every 3 months',
            ],
            'semi_annual' => [
                'name' => 'Semi-Annual',
                'price' => round($basePrice * $semiAnnualMultiplier, 2),
                'cycle' => 'semi_annual',
                'description' => 'Billed every 6 months',
            ],
            'annual' => [
                'name' => 'Annual',
                'price' => $basePrice,
                'cycle' => 'annual',
                'description' => 'Billed yearly (Best Value)',
            ],
        ];

        return view('subscription.locked', compact('pricing', 'currency', 'canSubscribe'));
    }

    /**
     * Handle subscription creation and payment initiation
     */
    public function subscribe(Request $request)
    {
        // Only admins (role='user') or super admins can subscribe
        $user = auth()->user();
        if (!$user || (!$user->isRegularUser() && !$user->isSuperAdmin())) {
            return back()->with('error', 'Only administrators can create subscriptions.');
        }

        $validated = $request->validate([
            'institution_name' => 'required|string|max:255',
            'renewal_cycle' => 'required|in:monthly,quarterly,semi_annual,annual',
        ]);

        // Get subscription pricing from settings
        $basePrice = (float) SystemSetting::get('subscription_base_price', 5000.00);
        $currency = SystemSetting::get('default_currency', 'GHS');
        
        $monthlyMultiplier = (float) SystemSetting::get('subscription_monthly_multiplier', 0.1);
        $quarterlyMultiplier = (float) SystemSetting::get('subscription_quarterly_multiplier', 0.275);
        $semiAnnualMultiplier = (float) SystemSetting::get('subscription_semi_annual_multiplier', 0.5);

        // Calculate amount based on cycle
        $amount = match($validated['renewal_cycle']) {
            'monthly' => round($basePrice * $monthlyMultiplier, 2),
            'quarterly' => round($basePrice * $quarterlyMultiplier, 2),
            'semi_annual' => round($basePrice * $semiAnnualMultiplier, 2),
            'annual' => $basePrice,
            default => $basePrice,
        };
        
        // Calculate end date based on cycle
        $startDate = now();
        $endDate = match($validated['renewal_cycle']) {
            'monthly' => $startDate->copy()->addMonth(),
            'quarterly' => $startDate->copy()->addMonths(3),
            'semi_annual' => $startDate->copy()->addMonths(6),
            'annual' => $startDate->copy()->addYear(),
            default => $startDate->copy()->addYear(),
        };

        // Get grace period from settings
        $gracePeriodDays = SystemSetting::getGracePeriodDays();

        // Create subscription (using 'standard' as default plan since we only have one price now)
        $subscription = $this->subscriptionManager->createSubscription([
            'institution_name' => $validated['institution_name'],
            'institution_code' => Str::slug($validated['institution_name']),
            'subscription_plan' => 'standard', // Default plan
            'subscription_start_date' => $startDate,
            'subscription_end_date' => $endDate,
            'renewal_cycle' => $validated['renewal_cycle'],
            'renewal_amount' => $amount,
            'currency' => $currency,
            'auto_renewal' => SystemSetting::getAutoRenewalEnabled(),
            'grace_period_days' => $gracePeriodDays,
            'created_by' => $user->id,
        ]);

        // Initiate payment
        $callbackUrl = route('super-admin.payments.callback');
        
        $result = $this->subscriptionManager->initiateManualRenewal(
            $subscription,
            $user->id,
            $callbackUrl
        );

        if ($result['success']) {
            return redirect()->away($result['payment_url']);
        }

        return back()->with('error', $result['message'] ?? 'Failed to initiate payment. Please try again.');
    }
}

