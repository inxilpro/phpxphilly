<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMembership extends Pivot
{
	public $incrementing = true;
	
	public $timestamps = true;
	
	protected $casts = [
		'is_subscribed' => 'boolean',
	];
}
