<?php

namespace App\Providers;

use App\Models\Group;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Lorisleiva\Actions\Facades\Actions;

class AppServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		//
	}
	
	public function boot(): void
	{
		Model::unguard();
		
		Actions::registerCommands();
		
		Route::middleware('web')->group(fn() => Actions::registerRoutes());
		
		$this->sharePhpxNetwork();
	}
	
	protected function sharePhpxNetwork()
	{
		$network = Cache::remember('phpx-network', now()->addWeek(), function() {
			return Group::query()
				->select('domain', 'name', 'region')
				->chunkMap(fn(Group $group) => $group->label())
				->toArray();
		});
		
		View::share('phpx_network', $network);
	}
}
