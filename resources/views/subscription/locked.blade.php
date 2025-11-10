<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Required - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/icofont@1.0.1/dist/icofont.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .locked-container {
            max-width: 900px;
            width: 100%;
            background: white;
            border-radius: 2rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideUp 0.5s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .locked-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 2rem;
            text-align: center;
        }

        .locked-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        .locked-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .locked-header p {
            font-size: 1.125rem;
            opacity: 0.9;
        }

        .locked-body {
            padding: 3rem 2rem;
        }

        .alert {
            border-radius: 1rem;
            border: none;
            padding: 1.25rem;
            margin-bottom: 2rem;
        }

        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .plan-card {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
        }

        .plan-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-color: #667eea;
        }

        .plan-card.selected {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        }

        .plan-name {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .plan-price {
            font-size: 2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 0.25rem;
        }

        .plan-cycle {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 1rem;
        }

        .plan-features {
            list-style: none;
            margin-top: 1rem;
        }

        .plan-features li {
            padding: 0.5rem 0;
            font-size: 0.875rem;
            color: #4b5563;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .plan-features li i {
            color: #10b981;
            font-size: 1rem;
        }

        .subscribe-form {
            background: #f8f9fa;
            border-radius: 1rem;
            padding: 2rem;
            margin-top: 2rem;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .btn-subscribe {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 0.75rem;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 1.5rem;
        }

        .btn-subscribe:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-subscribe:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .info-text {
            text-align: center;
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 1rem;
        }

        @media (max-width: 768px) {
            .locked-header h1 {
                font-size: 2rem;
            }

            .locked-icon {
                font-size: 4rem;
            }

            .plans-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="locked-container">
        <div class="locked-header">
            <div class="locked-icon">
                <i class="icofont-lock"></i>
            </div>
            <h1>Subscription Required</h1>
            <p>Please subscribe to continue using the system</p>
        </div>

        <div class="locked-body">
            @if(session('info'))
            <div class="alert alert-info">
                <i class="icofont-info-circle"></i> {{ session('info') }}
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">
                <i class="icofont-warning"></i> {{ session('error') }}
            </div>
            @endif

            @if($canSubscribe)
                <h3 class="text-center mb-4" style="color: #1f2937; font-weight: 600;">Choose Your Plan</h3>
                
                <form action="{{ route('subscription.subscribe') }}" method="POST" id="subscribeForm">
                    @csrf
                    
                    <div class="plans-grid" id="plansGrid">
                        @foreach($plans as $planKey => $plan)
                        <div class="plan-card" data-plan="{{ $planKey }}" onclick="selectPlan('{{ $planKey }}')">
                            <div class="plan-name">{{ $plan['name'] }}</div>
                            <div class="plan-price">{{ $plan['currency'] }} {{ number_format($plan['price'], 2) }}</div>
                            <div class="plan-cycle">per year</div>
                            <ul class="plan-features">
                                @foreach($plan['features'] as $feature)
                                <li>
                                    <i class="icofont-check-circled"></i>
                                    {{ $feature }}
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endforeach
                    </div>

                    <input type="hidden" name="subscription_plan" id="selectedPlan" required>
                    <input type="hidden" name="renewal_cycle" value="annual">

                    <div class="subscribe-form">
                        <div class="mb-3">
                            <label for="institution_name" class="form-label">
                                <i class="icofont-building"></i> Institution Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control" 
                                   id="institution_name" 
                                   name="institution_name" 
                                   placeholder="Enter your institution name"
                                   required>
                        </div>

                        <button type="submit" class="btn-subscribe" id="subscribeBtn" disabled>
                            <i class="icofont-credit-card"></i> Subscribe Now
                        </button>

                        <p class="info-text">
                            <i class="icofont-shield"></i> Secure payment powered by Paystack
                        </p>
                    </div>
                </form>
            @else
                <div class="text-center py-5">
                    <i class="icofont-info-circle" style="font-size: 3rem; color: #6b7280;"></i>
                    <h3 class="mt-3" style="color: #1f2937;">Contact Administrator</h3>
                    <p class="text-muted mt-2">
                        Only administrators can create subscriptions. Please contact your system administrator to set up a subscription.
                    </p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function selectPlan(planKey) {
            // Remove selected class from all cards
            document.querySelectorAll('.plan-card').forEach(card => {
                card.classList.remove('selected');
            });

            // Add selected class to clicked card
            event.currentTarget.classList.add('selected');

            // Set hidden input value
            document.getElementById('selectedPlan').value = planKey;

            // Enable subscribe button
            document.getElementById('subscribeBtn').disabled = false;
        }

        // Form validation
        document.getElementById('subscribeForm').addEventListener('submit', function(e) {
            const plan = document.getElementById('selectedPlan').value;
            const institutionName = document.getElementById('institution_name').value;

            if (!plan || !institutionName.trim()) {
                e.preventDefault();
                alert('Please select a plan and enter your institution name.');
                return false;
            }
        });
    </script>
</body>
</html>

