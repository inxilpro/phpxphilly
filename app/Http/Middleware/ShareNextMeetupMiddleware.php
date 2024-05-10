<?php

namespace App\Http\Middleware;

use App\Models\Group;
use App\Models\Meetup;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;

class ShareNextMeetupMiddleware
{
	public function handle(Request $request, Closure $next)
	{
		$group = $request->attributes->get('group');
		
		if ($group instanceof Group) {
			View::share('next_meetup', $this->meetup($group));
		}
		
		return $next($request);
	}
	
	protected function meetup(Group $group): ?Meetup
	{
		$key = "group:{$group->getKey()}:next-meetup";
		
		// If we have a cached meetup, just use that
		if (Cache::has($key)) {
			return (new Meetup())->newFromBuilder(Cache::get($key));
		}
		
		// If there's not an upcoming meetup, abort
		if (! $meetup = $group->meetups()->future()->first()) {
			return null;
		}
		
		// Otherwise, cache the upcoming meetup and return
		Cache::put($key, $meetup->getRawOriginal(), $meetup->ends_at);
		return $meetup;
	}
}
