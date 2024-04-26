<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewsletterSubscriberRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Session;

class NewsletterSubscriberController extends Controller
{
	public function store(NewsletterSubscriberRequest $request)
	{
		if (NewsletterSubscriber::where('email', $request->validated('email'))->doesntExist()) {
			NewsletterSubscriber::create($request->validated());
		}
		
		Session::flash('message', 'You’re on the list! Don’t forget to check out the Discord, too.');
		
		return redirect()->back();
	}
}
