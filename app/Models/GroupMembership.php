<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupMembership extends Pivot
{
	use HasSnowflakes;
	
	public $timestamps = true;
	
	protected $table = 'group_memberships';
	
	protected $casts = [
		'is_subscribed' => 'boolean',
	];
}
