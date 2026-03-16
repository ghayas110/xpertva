<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('attendance:process-penalties')->dailyAt('06:00');
Schedule::command('leaves:process-yearly-bonus')->monthlyOn(1, '01:00');
