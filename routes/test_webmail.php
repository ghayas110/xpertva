<?php
use Illuminate\Support\Facades\Route;

Route::get('/test-webmail', function() {
    auth()->loginUsingId(1);
    return redirect('/email');
});
