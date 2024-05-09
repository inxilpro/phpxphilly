<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
	use SoftDeletes;
	use HasFactory;
	use HasSnowflakes;
	
	public static function findByDomain(string $domain): ?static
	{
		$container = Container::getInstance();
		$id = "group:{$domain}";
		
		if (! $container->has($id)) {
			$container->instance($id, Group::firstWhere('domain', $domain));
		}
		
		return $container->get($id);
	}
	
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'group_memberships')
			->as('group_membership')
			->withPivot(['is_subscribed'])
			->withTimestamps()
			->using(GroupMembership::class);
	}
}
