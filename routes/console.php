<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule weekly visitor report every Monday at 9 AM
Schedule::command('visitors:weekly-report')
    ->weeklyOn(1, '9:00')
    ->timezone('America/New_York')
    ->emailOutputOnFailure(config('mail.admin_emails', ['patrick@nmtechnology.us']));

