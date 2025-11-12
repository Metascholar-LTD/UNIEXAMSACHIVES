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
use App\Models\EmailCampaign;
use Illuminate\Support\Facades\DB;
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
                $userId = Auth::id();
                
                // Get bookmarked memo IDs for the current user
                // Query pivot table directly to avoid ambiguous column error
                $bookmarkedMemoIds = DB::table('memo_user_bookmarks')
                    ->where('user_id', $userId)
                    ->pluck('campaign_id')
                    ->toArray();
                
                // Calculate message counts for all authenticated users, excluding bookmarked memos
                $newMessagesQuery = EmailCampaignRecipient::where('user_id', $userId)
                    ->where('is_read', false);
                    
                if (!empty($bookmarkedMemoIds)) {
                    $newMessagesQuery->whereNotIn('comm_campaign_id', $bookmarkedMemoIds);
                }
                $newMessagesCount = $newMessagesQuery->count();
                
                $totalMemosQuery = EmailCampaignRecipient::where('user_id', $userId);
                if (!empty($bookmarkedMemoIds)) {
                    $totalMemosQuery->whereNotIn('comm_campaign_id', $bookmarkedMemoIds);
                }
                $totalMemosCount = $totalMemosQuery->count();
                
                // Calculate bookmarked memos count
                $bookmarkedCount = count($bookmarkedMemoIds);
                
                if (Auth::user()->is_admin) {
                    $exams = Exam::where('user_id', Auth::user()->id)->get();
                    $files = File::where('user_id', Auth::user()->id)->get();

                    $view->with([
                        'newMessagesCount' => $newMessagesCount,
                        'totalMemosCount' => $totalMemosCount,
                        'bookmarkedCount' => $bookmarkedCount,
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
                        'bookmarkedCount' => $bookmarkedCount,
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
