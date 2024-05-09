<?php

namespace App\Actions;

use App\Models\Group;
use App\Models\Meetup;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class RsvpToMeetup
{
	use AsAction;
	
	public static function routes(Router $router): void
	{
		$router->post('meetups/{meetup}/rsvps', static::class)->middleware('web');
	}
	
	public function handle(Meetup $meetup, User $user): void
	{
		$meetup->users()->syncWithoutDetaching($user->getKey());
	}
	
	public function rules(): array
	{
		return [
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255'],
			// 'interests' => ['array'],
		];
	}
	
	public function asController(ActionRequest $request, Group $group)
	{
		// $this->handle(
		// 	group: $group,
		// 	name: $request->validated('name'),
		// 	email: $request->validated('email'),
		// 	subscribe: $request->boolean('subscribe'),
		// );
		//
		// $message = $request->boolean('subscribe')
		// 	? "You are now subscribed to updates from {$group->name}."
		// 	: "You are now unsubscribed from {$group->name} updates";
		//
		// Session::flash($message);
		
		return redirect()->back();
	}
	
	public function getCommandSignature(): string
	{
		return 'meetup:rsvp {meetup} {name} {email} {--subscribe}';
	}
	
	public function asCommand(Command $command): int
	{
		$meetup = Meetup::findOrFail($command->argument('meetup'));
		
		$user = JoinGroup::run(
			group: $meetup->group, 
			name: $command->argument('name'), 
			email: $command->argument('email'),
			subscribe: $command->option('subscribe'), 
		);
		
		$this->handle($meetup, $user);
		
		$command->info('User is now RSVP’d.');
		return 0;
	}
}
