<?php

namespace App\Http\Middleware;

use App\Models\Group;
use Closure;
use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Context;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SetGroupFromDomainMiddleware
{
	public function handle(Request $request, Closure $next)
	{
		if (! $group = $this->group($request)) {
			throw new NotFoundHttpException();
		}
		
		Container::getInstance()->instance(Group::class, $group);
		Container::getInstance()->instance("group:{$group->domain}", $group);
		Context::add('group_id', $group->getKey());
		View::share('group', $group);
		$request->attributes->set('group', $group);
		
		config(['app.timezone' => $group->timezone]);
		
		$response = $next($request);
		
		if ($response instanceof Response && $response->isRedirect()) {
			Log::debug(json_encode(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS), JSON_PRETTY_PRINT));
		}
		
		return $response;
	}
	
	protected function group(Request $request): ?Group
	{
		$host = str($request->host())->after('www.');
		
		if (App::isLocal()) {
			$host = $host->replaceEnd('.test', '.com');
		}
		
		$attributes = Cache::remember(
			key: "group:{$host}",
			ttl: now()->addWeek(),
			callback: fn() => Group::toBase()->where('domain', $host)->first()
		);
		
		return $attributes
			? (new Group())->newFromBuilder($attributes)
			: null;
	}
}
