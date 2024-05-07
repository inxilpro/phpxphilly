<?php

use App\Http\Controllers\NewsletterSubscriberController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/rsvp', 'rsvp');
Route::view('/newsletter', 'newsletter')->name('newsletter-subscriber.create');
Route::post('/newsletter', [NewsletterSubscriberController::class, 'store'])->name('newsletter-subscriber.store');
