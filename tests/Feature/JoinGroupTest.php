<?php

namespace Tests\Feature;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JoinGroupTest extends TestCase
{
	use RefreshDatabase;
	
	public function test_you_can_join_a_group_and_subscribe_to_updates(): void
	{
		$this->withoutExceptionHandling();
		
		$philly = Group::findByDomain('phpxphilly.com');
		$nyc = Group::findByDomain('phpxnyc.com');
		
		$payload = [
			'name' => 'Chris Morrell',
			'email' => 'chris@phpxphilly.com',
			'subscribe' => '1',
		];
		
		// Join Philly
		
		$this->post('https://phpxphilly.com/join', $payload)
			->assertSessionHasNoErrors()
			->assertRedirect();
		
		$philly_user = $philly->users()->sole();
		
		$this->assertEquals('Chris Morrell', $philly_user->name);
		$this->assertEquals('chris@phpxphilly.com', $philly_user->email);
		$this->assertTrue($philly_user->group_membership->is_subscribed);
		$this->assertTrue($philly_user->current_group()->is($philly));
		
		// Unsubscribe from Philly
		
		$this->post('https://phpxphilly.com/join', array_merge($payload, ['subscribe' => '0']))
			->assertSessionHasNoErrors()
			->assertRedirect();
		
		$philly_user = $philly->users()->sole();
		
		$this->assertEquals('Chris Morrell', $philly_user->name);
		$this->assertEquals('chris@phpxphilly.com', $philly_user->email);
		$this->assertFalse($philly_user->group_membership->is_subscribed);
		$this->assertTrue($philly_user->current_group()->is($philly));
		
		// Join NYC
		
		$this->post('https://phpxnyc.com/join', $payload)
			->assertSessionHasNoErrors()
			->assertRedirect();
		
		$nyc_user = $nyc->users()->sole();
		
		$this->assertTrue($nyc_user->is($philly_user));
		$this->assertEquals('Chris Morrell', $nyc_user->name);
		$this->assertEquals('chris@phpxphilly.com', $nyc_user->email);
		$this->assertTrue($nyc_user->group_membership->is_subscribed);
		$this->assertTrue($nyc_user->current_group()->is($nyc));
		
		// Unsubscribe from NYC
		
		$this->post('https://phpxnyc.com/join', array_merge($payload, ['subscribe' => '0']))
			->assertSessionHasNoErrors()
			->assertRedirect();
		
		$nyc_user = $nyc->users()->sole();
		
		$this->assertEquals('Chris Morrell', $nyc_user->name);
		$this->assertEquals('chris@phpxphilly.com', $nyc_user->email);
		$this->assertFalse($nyc_user->group_membership->is_subscribed);
		$this->assertTrue($nyc_user->current_group()->is($nyc));
	}
}
