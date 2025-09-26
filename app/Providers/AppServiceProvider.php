<?php

namespace App\Providers;

use App\Models\Detail;
use App\Models\Exam;
use App\Models\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Message;
use App\Models\EmailCampaignRecipient;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Configure authentication redirects
        $this->configureAuthenticationRedirects();
        
        View::composer('*', function ($view) {
            if(Auth::check()){
                if (Auth::user()->is_admin) {
                    $newMessagesCount = EmailCampaignRecipient::where('user_id', Auth::id())
                        ->where('is_read', false)
                        ->count();
                    $totalMemosCount = EmailCampaignRecipient::where('user_id', Auth::id())->count();
                    $exams = Exam::where('user_id', Auth::user()->id)->get();
                    $files = File::where('user_id', Auth::user()->id)->get();

                    $view->with([
                        'newMessagesCount' => $newMessagesCount,
                        'totalMemosCount' => $totalMemosCount,
                        'allExansCount' => $exams->count(),
                        'approvedCount' => $exams->where('is_approve', 1)->count(),
                        'pendingCount' => $exams->where('is_approve', 0)->count(),
                        'allFilesCount' => $files->count(),
                        'approvedFilesCount' => $files->where('is_approve', 1)->count(),
                        'pendingFilesCount' => $files->where('is_approve', 0)->count(),
                        'systemDetail' => Detail::all(),
                        'showPasswordReminder' => !Auth::user()->password_changed,
                    ]);
                }else{
                    $exams = Exam::all();
                    $files = File::all();
                    $view->with([
                        'allExansCount' => $exams->count(),
                        'approvedCount' => $exams->where('is_approve', 1)->count(),
                        'pendingCount' => $exams->where('is_approve', 0)->count(),
                        'allFilesCount' => $files->count(),
                        'approvedFilesCount' => $files->where('is_approve', 1)->count(),
                        'pendingFilesCount' => $files->where('is_approve', 0)->count(),
                        'systemDetail' => Detail::all(),
                        'showPasswordReminder' => !Auth::user()->password_changed,
                    ]);
                }
            }else{
                $view->with([
                    'systemDetail' => Detail::all(),
                ]);
            }

        });
    }

    /**
     * Configure authentication redirects for clean URL structure
     */
    private function configureAuthenticationRedirects(): void
    {
        // Configure Laravel's default authentication redirects
        // Use URL instead of route() to avoid circular dependency during boot
        URL::defaults(['login' => '/login']);
    }
}
