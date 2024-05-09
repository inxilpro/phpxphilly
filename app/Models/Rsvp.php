<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Rsvp extends Pivot
{
	use HasFactory;
	use HasSnowflakes;
	
	protected $casts = [
		'interests' => 'collection',
	];
	
	public function meetup()
	{
		return $this->belongsTo(Meetup::class);
	}
}
