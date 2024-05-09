<?php

use App\Models\Group;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('groups', function(Blueprint $table) {
			$table->snowflakeId();
			$table->string('domain')->unique();
			$table->string('name')->unique();
			$table->string('twitter_url')->nullable();
			$table->string('meetup_url')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
		
		Group::create([
			'domain' => 'phpxnyc.com',
			'name' => 'PHP×NYC',
			'twitter_url' => 'https://twitter.com/joetannenbaum',
			'meetup_url' => 'https://www.meetup.com/php-nyc/',
		]);
		
		Group::create([
			'domain' => 'phpxphilly.com',
			'name' => 'PHP×Philly',
			'twitter_url' => 'https://twitter.com/inxilpro',
			'meetup_url' => 'https://www.meetup.com/php-philly/',
		]);
	}
	
	public function down(): void
	{
		Schema::dropIfExists('groups');
	}
};
