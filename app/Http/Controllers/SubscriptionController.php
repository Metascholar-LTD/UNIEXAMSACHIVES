<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

        // Define subscription plans
        $plans = [
            'basic' => [
                'name' => 'Basic',
                'price' => 2000.00,
                'currency' => 'GHS',
                'cycle' => 'annual',
                'features' => [
                    'Up to 100 users',
                    'Basic support',
                    'Standard features',
                    'Email notifications',
                ],
            ],
            'standard' => [
                'name' => 'Standard',
                'price' => 3500.00,
                'currency' => 'GHS',
                'cycle' => 'annual',
                'features' => [
                    'Up to 500 users',
                    'Priority support',
                    'Advanced features',
                    'SMS & Email notifications',
                    'Custom branding',
                ],
            ],
            'premium' => [
                'name' => 'Premium',
                'price' => 5000.00,
                'currency' => 'GHS',
                'cycle' => 'annual',
                'features' => [
                    'Unlimited users',
                    '24/7 Priority support',
                    'All features',
                    'Multi-channel notifications',
                    'Custom domain',
                    'Advanced analytics',
                ],
            ],
            'enterprise' => [
                'name' => 'Enterprise',
                'price' => 8000.00,
                'currency' => 'GHS',
                'cycle' => 'annual',
                'features' => [
                    'Unlimited everything',
                    'Dedicated support',
                    'Custom integrations',
                    'White-label solution',
                    'SLA guarantee',
                    'On-site training',
                ],
            ],
        ];

        return view('subscription.locked', compact('plans', 'canSubscribe'));
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
            'subscription_plan' => 'required|in:basic,standard,premium,enterprise',
            'renewal_cycle' => 'required|in:monthly,quarterly,semi_annual,annual',
        ]);

        // Calculate subscription dates and amount based on plan and cycle
        $planPrices = [
            'basic' => ['monthly' => 200, 'quarterly' => 550, 'semi_annual' => 1000, 'annual' => 2000],
            'standard' => ['monthly' => 350, 'quarterly' => 950, 'semi_annual' => 1750, 'annual' => 3500],
            'premium' => ['monthly' => 500, 'quarterly' => 1350, 'semi_annual' => 2500, 'annual' => 5000],
            'enterprise' => ['monthly' => 800, 'quarterly' => 2200, 'semi_annual' => 4000, 'annual' => 8000],
        ];

        $amount = $planPrices[$validated['subscription_plan']][$validated['renewal_cycle']] ?? 2000.00;
        
        // Calculate end date based on cycle
        $startDate = now();
        $endDate = match($validated['renewal_cycle']) {
            'monthly' => $startDate->copy()->addMonth(),
            'quarterly' => $startDate->copy()->addMonths(3),
            'semi_annual' => $startDate->copy()->addMonths(6),
            'annual' => $startDate->copy()->addYear(),
            default => $startDate->copy()->addYear(),
        };

        // Create subscription
        $subscription = $this->subscriptionManager->createSubscription([
            'institution_name' => $validated['institution_name'],
            'institution_code' => Str::slug($validated['institution_name']),
            'subscription_plan' => $validated['subscription_plan'],
            'subscription_start_date' => $startDate,
            'subscription_end_date' => $endDate,
            'renewal_cycle' => $validated['renewal_cycle'],
            'renewal_amount' => $amount,
            'currency' => 'GHS',
            'auto_renewal' => true,
            'grace_period_days' => 7,
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

