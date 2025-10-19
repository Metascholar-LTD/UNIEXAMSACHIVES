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
use Illuminate\Support\Str;

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
        
        // Register HTML sanitization helper
        $this->registerHtmlSanitization();
        
        View::composer('*', function ($view) {
            if(Auth::check()){
                // Calculate message counts for all authenticated users
                $newMessagesCount = EmailCampaignRecipient::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
                $totalMemosCount = EmailCampaignRecipient::where('user_id', Auth::id())->count();
                
                if (Auth::user()->is_admin) {
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
    
    /**
     * Register HTML sanitization helper for memo messages
     */
    private function registerHtmlSanitization(): void
    {
        // Create a helper function to sanitize HTML content
        if (!function_exists('sanitize_memo_html')) {
            function sanitize_memo_html($html) {
                // Allow safe HTML tags for memo formatting
                $allowedTags = '<p><br><strong><b><em><i><u><s><strike><ul><ol><li><h1><h2><h3><h4><h5><h6><blockquote><pre><code><a><img><span><div>';
                
                // Strip dangerous tags and attributes
                $sanitized = strip_tags($html, $allowedTags);
                
                // Remove potentially dangerous attributes
                $sanitized = preg_replace('/on\w+="[^"]*"/i', '', $sanitized);
                $sanitized = preg_replace('/javascript:/i', '', $sanitized);
                $sanitized = preg_replace('/vbscript:/i', '', $sanitized);
                $sanitized = preg_replace('/data:/i', '', $sanitized);
                
                return $sanitized;
            }
        }
    }
}
