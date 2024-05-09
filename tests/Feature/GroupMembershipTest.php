<?php

namespace Tests\Feature;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GroupMembershipTest extends TestCase
{
	use RefreshDatabase;
	
	public function test_you_can_join_a_group_and_subscribe_to_updates(): void
	{
		$group = Group::findByDomain('phpxphilly.com');
		
		// $this->get('https://phpxphilly.com/join')
		// 	->assertOk()
		// 	->assertSee($group->name);
		
		$payload = [
			'group' => $group->getKey(),
			'name' => 'Chris Morrell',
			'email' => 'chris@phpxphilly.com',
			'subscribe' => '1',
		];
		
		$this->post('https://phpxphilly.com/join', $payload)
			->assertSessionHasNoErrors()
			->assertRedirect();
		
		$user = $group->users()->sole();
		
		$this->assertEquals('Chris Morrell', $user->name);
		$this->assertEquals('chris@phpxphilly.com', $user->email);
		$this->assertTrue($user->group_membership->is_subscribed);
		$this->assertTrue($user->current_group()->is($group));
		
		$this->post('https://phpxphilly.com/join', array_merge($payload, ['subscribe' => '0']) )
			->assertSessionHasNoErrors()
			->assertRedirect();
		
		$user = $group->users()->sole();
		
		$this->assertEquals('Chris Morrell', $user->name);
		$this->assertEquals('chris@phpxphilly.com', $user->email);
		$this->assertFalse($user->group_membership->is_subscribed);
		$this->assertTrue($user->current_group()->is($group));
	}
}
