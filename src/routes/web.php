<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Redirect root URL directly to the Filament login page.
|
*/

Route::get('/', function () {
    return redirect()->route('filament.admin.auth.login');
});