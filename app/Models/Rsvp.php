<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Rsvp extends Pivot
{
	public $timestamps = true;
	
	protected $casts = [
		'interests' => 'collection',
	];
}
