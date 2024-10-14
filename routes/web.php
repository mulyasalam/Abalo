<?php


use App\Events\Wartungsevent;
use Illuminate\Support\Facades\Route;
Route::view('/newsite', 'homepage');

Route::get('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login');
Route::get('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
Route::get('/isloggedin', [App\Http\Controllers\AuthController::class, 'isloggedin'])->name('haslogin');
Route::post('/articles', [App\Http\Controllers\ArtikelController::class, 'newArticle',])->name('newarticle');
Route::get('/articles', [App\Http\Controllers\ArtikelController::class, 'SearchArticle',]);
Route::get('/newarticle', function (){return view('Artikeleingabe');});

Route::get('/', function () {
    return view('welcome');
});

Route::get('maintenance', function (){
    event(new Wartungsevent());
});
\Illuminate\Support\Facades\Broadcast::routes();

use App\Events\MaintenanceNotification;

Route::get('/send-maintenance-notification', function () {
    event(new MaintenanceNotification('In Kürze verbessern wir Abalo für Sie! Nach einer kurzen Pause sind wir wieder für Sie da! Versprochen.'));
    return 'Maintenance notification sent';
});



