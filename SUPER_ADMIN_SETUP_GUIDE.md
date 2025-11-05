# 🚀 SUPER ADMIN & SUBSCRIPTION MANAGEMENT SYSTEM
## Complete Setup & Usage Guide

---

## 📋 **TABLE OF CONTENTS**

1. [System Overview](#system-overview)
2. [Installation Steps](#installation-steps)
3. [Initial Configuration](#initial-configuration)
4. [Paystack Integration](#paystack-integration)
5. [Usage Guide](#usage-guide)
6. [Automation & Scheduling](#automation--scheduling)
7. [Testing Guide](#testing-guide)
8. [Troubleshooting](#troubleshooting)

---

## 🎯 **SYSTEM OVERVIEW**

This Super Admin system provides:

✅ **Subscription Management** - Track renewals, expirations, grace periods  
✅ **Payment Processing** - Paystack integration (auto & manual renewals)  
✅ **Maintenance Scheduling** - System updates with user notifications  
✅ **System Settings** - Centralized configuration management  
✅ **Role Management** - Super Admin hierarchy  
✅ **Automated Tasks** - Daily checks, reminders, and renewals  
✅ **Analytics & Reports** - Revenue tracking, subscription analytics  

---

## 🛠️ **INSTALLATION STEPS**

### 1. Install Required Dependencies

```bash
# Install PDF generation library (for invoices/receipts)
composer require barryvdh/laravel-dompdf

# Clear cache
php artisan cache:clear
php artisan config:clear
```

### 2. Run Database Migrations

```bash
php artisan migrate

# You should see 7 new migrations run:
# - 2025_11_05_000001_add_role_system_to_users_table
# - 2025_11_05_000002_create_system_subscriptions_table
# - 2025_11_05_000003_create_payment_transactions_table
# - 2025_11_05_000004_create_system_maintenance_logs_table
# - 2025_11_05_000005_create_system_notifications_table
# - 2025_11_05_000006_create_user_notification_reads_table
# - 2025_11_05_000007_create_system_settings_table
```

### 3. Run Seeder (Create Super Admin & Settings)

```bash
php artisan db:seed --class=SuperAdminSystemSeeder

# ⚠️ IMPORTANT: Save these credentials!
# Email: superadmin@metascholar.com
# Password: SuperAdmin@2025
# CHANGE THIS PASSWORD IMMEDIATELY AFTER FIRST LOGIN!
```

### 4. Setup Task Scheduler (CRITICAL for auto-renewals)

**For Production (Linux/Ubuntu):**
```bash
# Edit crontab
crontab -e

# Add this line:
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

**For Development (Windows):**
```bash
# Run scheduler manually (keep this terminal open)
php artisan schedule:work
```

### 5. Verify Installation

```bash
# Check if super admin was created
php artisan tinker
>>> App\Models\User::where('role', 'super_admin')->count()
# Should return: 1

# Check system settings
>>> App\Models\SystemSetting::count()
# Should return: 12
```

---

## ⚙️ **INITIAL CONFIGURATION**

### 1. Login as Super Admin

1. Go to: `http://your-domain.com/login`
2. Email: `superadmin@metascholar.com`
3. Password: `SuperAdmin@2025`
4. **IMMEDIATELY CHANGE YOUR PASSWORD!**

### 2. Access Super Admin Dashboard

After login, go to: `http://your-domain.com/super-admin`

You should see:
- Dashboard with statistics
- Subscription management
- Payment tracking
- Maintenance scheduler
- System settings

---

## 💳 **PAYSTACK INTEGRATION**

### Step 1: Get Paystack API Keys

1. Go to: https://dashboard.paystack.com/
2. Sign up / Login
3. Navigate to: **Settings > API Keys & Webhooks**
4. Copy:
   - **Public Key** (starts with `pk_test_` or `pk_live_`)
   - **Secret Key** (starts with `sk_test_` or `sk_live_`)

### Step 2: Configure Paystack in System

1. Login as Super Admin
2. Go to: **Super Admin > Settings**
3. Find **Payment Gateway** section
4. Enter:
   - **Paystack Public Key**: `pk_test_xxxxxxxxxxxxx`
   - **Paystack Secret Key**: `sk_test_xxxxxxxxxxxxx`
5. Click **Save Settings**
6. Click **Test Paystack Connection** to verify

### Step 3: Setup Webhook (For auto-payment confirmations)

1. In Paystack Dashboard, go to: **Settings > API Keys & Webhooks**
2. Under **Webhooks**, add:
   - **URL**: `https://your-domain.com/webhooks/paystack`
3. Copy the **Webhook Secret**
4. In Super Admin Settings, add:
   - **Paystack Webhook Secret**: `whsec_xxxxxxxxxxxxx`
5. Save

**Events to Enable:**
- `charge.success`
- `subscription.create`
- `subscription.disable`

---

## 📚 **USAGE GUIDE**

### Creating a Subscription

1. Go to: **Super Admin > Subscriptions > Create New**
2. Fill in:
   - Institution Name
   - Subscription Plan (Basic/Standard/Premium/Enterprise)
   - Start Date & End Date
   - Renewal Amount
   - Renewal Cycle (Monthly/Quarterly/Annual)
   - Auto-Renewal (Enable/Disable)
   - Grace Period Days (default: 7)
3. Click **Create Subscription**

### Processing Renewal Payment

#### Option A: Manual Renewal
1. Go to subscription details
2. Click **Renew Now**
3. User will be redirected to Paystack payment page
4. After payment, system auto-updates subscription

#### Option B: Automatic Renewal
- System automatically charges saved payment method 3 days before expiry
- Runs daily at 10:00 AM via scheduler
- Notifications sent on success/failure

### Scheduling Maintenance

1. Go to: **Super Admin > Maintenance > Create New**
2. Fill in:
   - Maintenance Type
   - Title & Description
   - Scheduled Start & End
   - Impact Level (Low/Medium/High/Critical)
   - Requires Downtime? (Yes/No)
   - Display Banner? (Yes/No)
3. Click **Schedule Maintenance**
4. Click **Notify Users** to send notifications

### Managing System Settings

1. Go to: **Super Admin > Settings**
2. Categories:
   - **Payment Gateway**: Paystack keys
   - **Subscription**: Grace period, auto-renewal
   - **General**: System name, email
   - **Email**: Notification preferences
3. Make changes
4. Click **Save Settings**
5. Click **Clear Cache** after changes

### Granting Super Admin Access

1. Go to: **Super Admin > User Roles**
2. Find user
3. Click **Grant Super Admin**
4. Confirm action
5. User immediately gets super admin privileges

---

## ⏰ **AUTOMATION & SCHEDULING**

The system runs 4 automated tasks daily:

### 1. **Check Expiring Subscriptions** (6:00 AM)
```bash
php artisan subscriptions:check-expiring
```
- Updates subscription statuses
- Marks expiring/expired/suspended subscriptions

### 2. **Send Renewal Reminders** (8:00 AM)
```bash
php artisan subscriptions:send-reminders
```
- Sends reminders at: 30, 14, 7, 1 days before expiry
- Email + in-app notifications

### 3. **Process Auto-Renewals** (10:00 AM)
```bash
php artisan subscriptions:process-auto-renewals
```
- Attempts auto-renewal for expiring subscriptions
- Uses saved payment methods
- Sends success/failure notifications

### 4. **Suspend Expired Subscriptions** (12:00 AM)
```bash
php artisan subscriptions:suspend-expired
```
- Suspends subscriptions beyond grace period
- Blocks user access until payment

**Manual Execution (for testing):**
```bash
php artisan subscriptions:check-expiring
php artisan subscriptions:send-reminders
php artisan subscriptions:process-auto-renewals
php artisan subscriptions:suspend-expired
```

---

## 🧪 **TESTING GUIDE**

### Test Payment Flow

```bash
# Use Paystack Test Cards:

# Successful Payment:
Card: 4084084084084081
CVV: 408
Expiry: 12/25
PIN: 0000
OTP: 123456

# Failed Payment:
Card: 4084080000000409
CVV: 408
Expiry: 12/25
```

### Test Subscription Flow

1. **Create Test Subscription** (expires in 2 days):
```bash
php artisan tinker

$subscription = App\Models\SystemSubscription::create([
    'institution_name' => 'Test Institution',
    'institution_code' => 'test-inst',
    'subscription_plan' => 'standard',
    'subscription_start_date' => now(),
    'subscription_end_date' => now()->addDays(2), // Expires in 2 days
    'renewal_cycle' => 'annual',
    'renewal_amount' => 100.00,
    'currency' => 'GHS',
    'status' => 'active',
    'auto_renewal' => true,
    'grace_period_days' => 7,
    'created_by' => 1,
]);
```

2. **Test Renewal Reminder**:
```bash
php artisan subscriptions:send-reminders
# Should send notification for subscription expiring in 2 days
```

3. **Test Auto-Renewal**:
```bash
php artisan subscriptions:process-auto-renewals
# Will attempt auto-renewal
```

---

## 🚨 **TROUBLESHOOTING**

### Issue: "Paystack is not configured"

**Solution:**
```bash
# 1. Check settings
php artisan tinker
>>> App\Models\SystemSetting::where('key', 'paystack_public_key')->first()->value
>>> App\Models\SystemSetting::where('key', 'paystack_secret_key')->first()->value

# 2. If empty, set manually
>>> App\Models\SystemSetting::set('paystack_public_key', 'pk_test_xxx', 1);
>>> App\Models\SystemSetting::set('paystack_secret_key', 'sk_test_xxx', 1);

# 3. Clear cache
php artisan cache:clear
```

### Issue: Scheduler Not Running

**Check if cron is set up:**
```bash
crontab -l
# Should show: * * * * * cd /path && php artisan schedule:run
```

**Manual test:**
```bash
php artisan schedule:run
# Should show list of tasks running
```

### Issue: Webhook Not Working

**Test webhook manually:**
```bash
curl -X POST https://your-domain.com/webhooks/paystack \
  -H "Content-Type: application/json" \
  -H "X-Paystack-Signature: test_signature" \
  -d '{"event":"charge.success","data":{"reference":"test123"}}'
```

### Issue: Access Denied to Super Admin

**Grant super admin manually:**
```bash
php artisan tinker
>>> $user = App\Models\User::where('email', 'your-email@example.com')->first();
>>> $user->grantSuperAdminAccess(1);
>>> $user->role
# Should return: "super_admin"
```

### Clear All Caches

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan optimize:clear
```

---

## 📊 **SYSTEM ENDPOINTS**

### Super Admin Dashboard
- **URL**: `/super-admin`
- **Access**: Super Admin only

### Subscription Management
- **List**: `/super-admin/subscriptions`
- **Create**: `/super-admin/subscriptions/create`
- **View**: `/super-admin/subscriptions/{id}`
- **Edit**: `/super-admin/subscriptions/{id}/edit`

### Payment Management
- **List**: `/super-admin/payments`
- **View**: `/super-admin/payments/{id}`
- **Receipt**: `/super-admin/payments/{id}/receipt`

### Maintenance
- **List**: `/super-admin/maintenance`
- **Create**: `/super-admin/maintenance/create`

### Settings
- **View/Edit**: `/super-admin/settings`

### Webhooks
- **Paystack**: `/webhooks/paystack` (POST, no auth)

---

## 🎉 **YOU'RE ALL SET!**

Your Super Admin system is now fully functional with:

✅ Subscription tracking
✅ Payment processing (Paystack)
✅ Auto-renewals
✅ Maintenance scheduling
✅ System notifications
✅ Analytics & reports

**Next Steps:**

1. ✅ Change super admin password
2. ✅ Configure Paystack keys
3. ✅ Create your first subscription
4. ✅ Test payment flow
5. ✅ Enable task scheduler

**Need Help?**
- Check logs: `storage/logs/laravel.log`
- Run: `php artisan tinker` for debugging
- Test commands manually before relying on scheduler

---

**Built with ❤️ for Metascholar Consult Ltd**

