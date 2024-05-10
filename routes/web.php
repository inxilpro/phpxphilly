<?php

use App\Models\Meetup;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');
Route::view('/join', 'join');

Route::get('meetups/{meetup}/rsvps', function(Meetup $meetup) {
	return view('rsvp', [
		'meetup' => $meetup,
	]);
});
