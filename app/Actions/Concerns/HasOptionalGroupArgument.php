<?php

namespace App\Actions\Concerns;

use App\Models\Group;
use Illuminate\Console\Command;
use function Laravel\Prompts\select;

trait HasOptionalGroupArgument
{
	protected function getGroupFromCommand(Command $command): Group
	{
		$id = $command->argument('group') ?? select(
			label: 'Which group?',
			options: Group::pluck('name', 'id')
		);
		
		return Group::find($id);
	}
}
