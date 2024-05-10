<?php

namespace App\Models;

use Glhd\Bits\Database\HasSnowflakes;
use Illuminate\Container\Container;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Cache;

class Group extends Model
{
	use SoftDeletes;
	use HasFactory;
	use HasSnowflakes;
	
	protected static function booted()
	{
		static::saved(fn() => Cache::forget('phpx-network'));
	}
	
	public static function findByDomain(string $domain): ?static
	{
		$container = Container::getInstance();
		$id = "group:{$domain}";
		
		if (! $container->has($id)) {
			$container->instance($id, Group::firstWhere('domain', $domain));
		}
		
		return $container->get($id);
	}
	
	public function url(string $path, array $parameters = [], bool $secure = true): string
	{
		$generator = app(UrlGenerator::class);
		
		try {
			$generator->forceRootUrl('https://'.$this->domain);
			return $generator->to($path, $parameters, $secure);
		} finally {
			$generator->forceRootUrl(null);
		}
	}
	
	public function users(): BelongsToMany
	{
		return $this->belongsToMany(User::class, 'group_memberships')
			->as('group_membership')
			->withPivot('id', 'is_subscribed')
			->withTimestamps()
			->using(GroupMembership::class);
	}
	
	public function meetups(): HasMany
	{
		return $this->hasMany(Meetup::class);
	}
}

