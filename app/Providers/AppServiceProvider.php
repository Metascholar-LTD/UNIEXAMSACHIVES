<?php

namespace App\Providers;

use App\Models\Detail;
use App\Models\Exam;
use App\Models\File;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Message;

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
        View::composer('*', function ($view) {
            if(Auth::check()){
                if (Auth::user()->is_admin) {
                    $newMessagesCount = Message::with(['users' => function ($query) {
                        $query->where('user_id', Auth::id())->where('is_read', 0);
                    }])->count();
                    $exams = Exam::where('user_id', Auth::user()->id)->get();
                    $files = File::where('user_id', Auth::user()->id)->get();

                    $view->with([
                        'newMessagesCount' => $newMessagesCount,
                        'allExansCount' => $exams->count(),
                        'approvedCount' => $exams->where('is_approve', 1)->count(),
                        'pendingCount' => $exams->where('is_approve', 0)->count(),
                        'allFilesCount' => $files->count(),
                        'approvedFilesCount' => $files->where('is_approve', 1)->count(),
                        'pendingFilesCount' => $files->where('is_approve', 0)->count(),
                        'systemDetail' => Detail::all(),
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

                    ]);
                }
            }else{
                $view->with([
                    'systemDetail' => Detail::all(),
                ]);
            }

        });
    }
}
