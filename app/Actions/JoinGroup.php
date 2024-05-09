<?php

namespace App\Actions;

use App\Models\Group;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class JoinGroup
{
	use AsAction;
	
	public static function routes(Router $router): void
	{
		$router->post('join', static::class);
	}
	
	public function handle(Group $group, string $name, string $email, bool $subscribe = false): User
	{
		$user = User::firstOrCreate(
			[
				'email' => $email,
			], [
				'name' => $name,
				'password' => Hash::make(Str::random(32)),
			]
		);
		
		$user->groups()->syncWithoutDetaching([$group->getKey() => ['is_subscribed' => $subscribe]]);
		$user->update(['current_group_id' => $group->getKey()]);
		
		return $user;
	}
	
	public function rules(): array
	{
		return [
			'group' => ['required', 'integer', 'exists:groups,id'],
			'name' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:255'],
			'subscribe' => ['nullable', 'boolean'],
		];
	}
	
	public function asController(ActionRequest $request)
	{
		$group = Group::findOrFail($request->validated('group'));
		
		$this->handle(
			group: $group,
			name: $request->validated('name'),
			email: $request->validated('email'),
			subscribe: $request->boolean('subscribe'),
		);
		
		$message = $request->boolean('subscribe')
			? "You are now subscribed to updates from {$group->name}."
			: "You are now unsubscribed from {$group->name} updates";
		
		Session::flash($message);
		
		return redirect()->back();
	}
	
	public function getCommandSignature(): string
	{
		return 'join:group {group} {name} {email} {--subscribe}';
	}
	
	public function asCommand(Command $command): int
	{
		$group = Group::query()
			->when(
				value: is_numeric($command->argument('group')),
				callback: fn(Builder $query) => $query->where('id', $command->argument('group')),
				default: fn(Builder $query) => $query->where('domain', $command->argument('group')),
			)
			->sole();
		
		$this->handle(
			group: $group,
			name: $command->argument('name'),
			email: $command->argument('email'),
			subscribe: $command->option('subscribe')
		);
		
		$command->info('User added to group.');
		return 0;
	}
}
