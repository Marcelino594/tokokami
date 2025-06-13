<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route :: get(' /dashboard', function() {
    return view (' /dashboard');
})->middleware({'auth', 'verified'})->name('dashboard');

Route :: middleware('auth')->group(function () {
    Route :: get ('products', [ProductController::class, 'index'])->name('products.index');
    Route :: get ('/proflie', [ProfileController::class, 'edit'])->name('profile.edit');
    Route :: patch ('/proflie', [ProfileController::class, 'update'])->name('profile.update');
    Route :: delete ('/proflie', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ , '/auth.php';