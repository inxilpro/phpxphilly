<?php

namespace App\Actions;

use App\Models\Group;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\suggest;
use function Laravel\Prompts\table;
use function Laravel\Prompts\text;

class CreateGroup
{
	use AsAction;
	
	public function handle(
		string $domain,
		string $name,
		string $description,
		string $timezone = 'America/New_York', // One true timezone
		?string $bsky_url = null,
		?string $meetup_url = null,
	): Group {
		$group = Group::updateOrCreate([
			'domain' => $domain,
		], [
			'name' => $name,
			'description' => $description,
			'timezone' => $timezone,
			'bsky_url' => $bsky_url ?: null,
			'meetup_url' => $meetup_url ?: null,
		]);
		
		app()->instance("group:{$domain}", $group);
		
		return $group;
	}
	
	public function getCommandSignature(): string
	{
		return 'group:create';
	}
	
	public function asCommand(Command $command): int
	{
		$domain = text('What is the domain?', default: 'phpx', required: true);
		$name = text('What is the group name?', default: 'PHP×', required: true);
		$description = text('What is the description?', default: 'A local PHP meetup for web artisans who want to learn and connect.', required: true);
		$timezone = suggest('Timezone', \DateTimeZone::listIdentifiers(), default: 'America/New_York', required: true);
		$bsky_url = text('Is there a Bluesky URL?');
		$meetup_url = text('Is there a Meetup URL?');
		
		table(['Option', 'Value'], [
			['Name', $name],
			['Description', $description],
			['Timezone', $timezone],
			['Bluesky', $bsky_url],
			['Meetup', $meetup_url],
		]);
		
		if (confirm('Is this correct?')) {
			$group = $this->handle($domain, $name, $description, $timezone, $bsky_url, $meetup_url);
			$command->info("Created group <{$group->getKey()}>!");
			return 0;
		}
		
		return 1;
	}
}
