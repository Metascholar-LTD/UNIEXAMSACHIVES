<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Schedule auto-archive of completed memos to run daily at 2 AM
Schedule::command('memos:auto-archive')
    ->dailyAt('02:00')
    ->name('auto-archive-completed-memos')
    ->withoutOverlapping()
    ->runInBackground();
