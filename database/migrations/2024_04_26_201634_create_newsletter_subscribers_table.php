<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('newsletter_subscribers', function(Blueprint $table) {
			$table->snowflakeId();
			$table->string('full_name');
			$table->string('email');
			$table->timestamps();
		});
	}
	
	public function down(): void
	{
		Schema::dropIfExists('newsletter_subscribers');
	}
};
