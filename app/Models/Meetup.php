<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Meetup extends Model
{
	use HasFactory;
	
	protected $casts = [
		'starts_at' => 'datetime',
		'ends_at' => 'datetime',
	];
	
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'rsvps');
	}
}
