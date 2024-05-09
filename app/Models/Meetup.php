<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meetup extends Model
{
	use HasSnowflakes;
	use HasFactory;
	
	protected $casts = [
		'starts_at' => 'datetime',
		'ends_at' => 'datetime',
	];
	
	public function group(): BelongsTo
	{
		return $this->belongsTo(Group::class);
	}
	
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'rsvps')
			->as('rsvp')
			->withTimestamps()
			->using(Rsvp::class);
	}
}
