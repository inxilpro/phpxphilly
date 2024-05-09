<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Meetup extends Model
{
	use HasFactory;
	
	protected $casts = [
		'starts_at' => 'datetime',
		'ends_at' => 'datetime',
	];
	
	public function rsvps(): HasMany
	{
		return $this->hasMany(Rsvp::class);
	}
	
	public function users(): HasManyThrough
	{
		return $this->hasManyThrough(User::class, Rsvp::class);
	}
}
