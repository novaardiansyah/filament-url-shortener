<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return redirect('/admin');
});

// ! Extra routes needed for non-Filament resources.
Route::get('/login', function () {
  return redirect(route('filament.admin.auth.login'));
})->name('login');

Route::get('{shortener_url}', [UrlController::class, 'shortenLink'])->name('shortener-url');