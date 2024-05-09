<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Rsvp extends Pivot
{
	use HasSnowflakes;
	
	public $timestamps = true;
	
	protected $casts = [
		'interests' => 'collection',
	];
}
