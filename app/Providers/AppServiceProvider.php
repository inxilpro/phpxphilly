<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
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
		Actions::registerRoutes();
    }
}
