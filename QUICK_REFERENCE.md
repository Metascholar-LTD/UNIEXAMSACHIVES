# 🚀 SUPER ADMIN - QUICK REFERENCE CARD

## 📍 ACCESS URLS

### Super Admin (Metascholar Consult)
```
🔐 Login:     http://yourdomain.com/super-admin/login
📊 Dashboard: http://yourdomain.com/super-admin
```

### Regular Users (Universities)
```
🔐 Login:     http://yourdomain.com/login
📊 Dashboard: http://yourdomain.com/dashboard
```

---

## 👤 DEFAULT CREDENTIALS

After running seeder:
```
Email:    superadmin@metascholar.com
Password: SuperAdmin@2025
```

⚠️ **Change immediately after first login!**

---

## ⚡ QUICK SETUP (5 Steps)

```bash
# 1. Install dependencies
composer install
composer require barryvdh/laravel-dompdf

# 2. Run migrations
php artisan migrate

# 3. Seed data
php artisan db:seed --class=SuperAdminSystemSeeder

# 4. Start scheduler (Windows)
# Add to Task Scheduler:
# C:\path\to\php.exe C:\path\to\artisan schedule:run

# 5. Configure Paystack
# Login → Settings → Enter API Keys
```

---

## 🎯 SUPER ADMIN FEATURES

```
✅ Manage Subscriptions (Create, Edit, Renew, Suspend)
✅ Process Payments (Manual, Auto, Refunds)
✅ Schedule Maintenance (Plan, Execute, Notify)
✅ Configure Settings (Paystack, System Options)
✅ Manage User Roles (Grant/Revoke Access)
✅ View Analytics (Revenue, Growth, Trends)
✅ Export Reports (CSV, Excel, PDF)
✅ System Notifications (Broadcast to all users)
```

---

## 🚫 WHAT'S NOT IN SUPER ADMIN

```
❌ Exam Archives
❌ Folders & Papers
❌ Memos System
❌ Department Management
❌ Academic Years
❌ Student Features
❌ Subscription Widget
❌ Regular User Stuff
```

---

## 🎨 VISUAL IDENTITY

### Super Admin System
```
Color:  Purple Gradient (#667eea → #764ba2)
Icon:   🛡️ Shield
Style:  Clean, Professional, Focused
Brand:  Metascholar Consult Ltd
```

### Regular System
```
Color:  Teal (#01b2ac)
Icon:   📚 Books
Style:  Feature-rich, Educational
Brand:  University Archive System
```

---

## 🔐 SECURITY RULES

```
✅ Super Admin bypasses subscription checks
✅ Super Admin bypasses maintenance mode
✅ Super Admin has dedicated login
✅ Regular users cannot access super admin panel
✅ Separate authentication flows
✅ Role validated at login time
```

---

## 📋 MAIN MENU (Super Admin)

```
Super Admin Panel:
├─ 📊 Dashboard       → Overview & stats
├─ 📋 Subscriptions   → Manage all subscriptions
├─ 💳 Payments        → Transaction history
├─ 🛠️ Maintenance     → Schedule downtime
├─ ⚙️ Settings        → System configuration
├─ 👥 User Roles      → Grant/revoke access
└─ 📈 Analytics       → Reports & insights
```

---

## 💳 PAYMENT GATEWAY

**Provider:** Paystack

**Test Keys:**
```
Public:  pk_test_xxxxxxxxxxxxx
Secret:  sk_test_xxxxxxxxxxxxx
```

**Live Keys:**
```
Public:  pk_live_xxxxxxxxxxxxx
Secret:  sk_live_xxxxxxxxxxxxx
```

**Configure at:** Settings → Paystack Configuration

---

## 🔄 AUTOMATED TASKS

Runs daily via scheduler:

```
06:00 AM → Check expiring subscriptions
08:00 AM → Send renewal reminders
10:00 AM → Process auto-renewals
12:00 AM → Suspend expired accounts
```

---

## 📊 DASHBOARD METRICS

Super Admin sees:
```
- Total subscriptions
- Active subscriptions
- Monthly revenue
- Total revenue
- Expiring soon count
- Successful payments
- Pending payments
- Upcoming maintenance
```

---

## 🛠️ TROUBLESHOOTING

### Can't login?
```
1. Check URL: /super-admin/login
2. Verify role = 'super_admin' in database
3. Check credentials
```

### Subscription widget showing?
```
1. Clear cache: php artisan cache:clear
2. Check user role in database
3. Verify middleware is registered
```

### Scheduler not running?
```
Windows: Check Task Scheduler
Linux:   Check crontab -e
Test:    php artisan schedule:run
```

---

## 📁 KEY FILES

```
Login Form:
└─ resources/views/super-admin/login.blade.php

Layout:
└─ resources/views/super-admin/layout.blade.php

Dashboard:
└─ resources/views/super-admin/dashboard.blade.php

Controller:
└─ app/Http/Controllers/SuperAdmin/SuperAdminController.php

Middleware:
├─ app/Http/Middleware/SuperAdminMiddleware.php
├─ app/Http/Middleware/SubscriptionActiveMiddleware.php
└─ app/Http/Middleware/CheckMaintenanceMode.php

Routes:
└─ routes/web.php (line 237+)
```

---

## 🎯 SUBSCRIPTION LIFECYCLE

```
1. Create Subscription (Super Admin)
   ↓
2. Payment Processed (Paystack)
   ↓
3. Status: Active
   ↓
4. Reminders Sent (30, 14, 7 days)
   ↓
5. Auto-renewal Attempted (3 days before)
   ↓
6. Grace Period (if expired)
   ↓
7. Suspended (if not renewed)
   ↓
8. Reactivate (after payment)
```

---

## 💡 PRO TIPS

```
✅ Always use correct login URL
✅ Monitor expiring subscriptions daily
✅ Test Paystack keys before going live
✅ Backup system settings regularly
✅ Send reminders 30 days before expiry
✅ Keep separate credentials for each system
✅ Use maintenance mode for major updates
```

---

## 📞 SUPPORT

```
Super Admin Issues:  Contact Metascholar Consult
Regular User Issues: Contact Institution Admin
Technical Support:   Check documentation files
```

---

## 📚 DOCUMENTATION FILES

```
1. SUPER_ADMIN_COMPLETE_SETUP.md  → Full setup guide
2. IMPLEMENTATION_COMPLETE.md      → What was built
3. BEFORE_VS_AFTER.md             → Visual comparison
4. QUICK_REFERENCE.md             → This file
5. SUPER_ADMIN_SETUP_GUIDE.md     → Original guide
```

---

## ✅ CHECKLIST

Before going live:
```
□ Migrations run
□ Seeder executed
□ Super admin created
□ Login tested
□ Paystack configured
□ Scheduler setup
□ Test subscription created
□ Test payment processed
□ Notifications working
□ Maintenance mode tested
□ Backups configured
□ Production credentials updated
```

---

## 🎉 YOU'RE READY!

```
✅ Two separate systems
✅ Clean interfaces
✅ Secure access control
✅ Professional design
✅ Production ready
```

**Start managing your exam archives ecosystem now!** 🚀

---

## 🔗 QUICK LINKS

| Action | URL Path |
|--------|----------|
| Super Admin Login | `/super-admin/login` |
| Super Admin Dashboard | `/super-admin` |
| Subscriptions | `/super-admin/subscriptions` |
| Payments | `/super-admin/payments` |
| Settings | `/super-admin/settings` |
| Maintenance | `/super-admin/maintenance` |
| User Roles | `/super-admin/roles` |
| Analytics | `/super-admin/analytics` |

---

**Keep this reference handy!** 📌

