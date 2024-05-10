<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
	public function run(): void
	{
		$nyc = Group::create([
			'domain' => 'phpxnyc.com',
			'name' => 'PHP×NYC',
			'twitter_url' => 'https://twitter.com/joetannenbaum',
			'meetup_url' => 'https://www.meetup.com/php-nyc/',
		]);
		
		app()->instance('group:phpxnyc.com', $nyc);
		
		$philly = Group::create([
			'domain' => 'phpxphilly.com',
			'name' => 'PHP×Philly',
			'twitter_url' => 'https://twitter.com/inxilpro',
			'meetup_url' => 'https://www.meetup.com/php-philly/',
		]);
		
		app()->instance('group:phpxphilly.com', $philly);
	}
}
