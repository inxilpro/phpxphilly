<?php

namespace App\Actions;

use App\Models\Group;
use App\Models\Meetup;
use Carbon\CarbonInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Date;
use Lorisleiva\Actions\Concerns\AsAction;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;
use function Laravel\Prompts\textarea;

class CreateMeetup
{
	use AsAction;
	
	public function handle(
		Group $group,
		string $location,
		string $description,
		int $capacity,
		CarbonInterface $starts_at,
		CarbonInterface $ends_at,
	): Meetup {
		return $group->meetups()->create([
			'location' => $location,
			'description' => $description,
			'capacity' => $capacity,
			'starts_at' => $starts_at,
			'ends_at' => $ends_at,
		]);
	}
	
	public function getCommandSignature(): string
	{
		return 'meetup:create';
	}
	
	public function asCommand(Command $command): int
	{
		$group = Group::find(select('Which group?', Group::all()->pluck('name', 'id')));
		$location = text('What is the meetup location?', required: true);
		$description = textarea('Event description (markdown)', required: true);
		$capacity = (int) text('What is the capacity of the location?', required: true);
		$starts_at = Date::parse(text('When does the event start?', required: true));
		$ends_at = Date::parse(text('When does the event end?', required: true));
		
		table(['Option', 'Value'], [
			['Group', $group->name],
			['Location', $location],
			['Description', $description],
			['Capacity', $capacity],
			['Starts at', $starts_at->toDateTimeString()],
			['Ends at', $ends_at->toDateTimeString()],
		]);
		
		if (confirm('Is this correct?')) {
			$meetup = $this->handle($group, $location, $description, $capacity, $starts_at, $ends_at);
			$command->info("Created meetup <{$meetup->getKey()}>!");
			return 0;
		}
		
		return 1;
	}
}
