<?php

namespace App\Actions\Concerns;

use App\Models\Group;
use App\Models\User;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

trait HasOptionalUserArgument
{
	protected function getUserFromCommand(Command $command, ?Group $group = null): User
	{
		$id = $command->argument('user') ?? select(
			label: 'Which user?',
			options: $group
				? $group->users()->pluck('email', (new User())->qualifyColumn('id'))
				: User::pluck('name', 'id'),
		);
		
		return User::find($id);
	}
}
