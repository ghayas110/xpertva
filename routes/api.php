<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AgentController;

/*
 | Desktop monitoring agent API.
 | Stateless: authenticated per-request by the employee's agent token
 | (X-Agent-Token header), so no browser session / CSRF is involved.
 */
Route::prefix('agent')->middleware('agent.token')->group(function () {
    Route::get('/config',    [AgentController::class, 'config'])->name('api.agent.config');
    Route::post('/consent',  [AgentController::class, 'consent'])->name('api.agent.consent');
    Route::post('/activity', [AgentController::class, 'activity'])->name('api.agent.activity');
});
