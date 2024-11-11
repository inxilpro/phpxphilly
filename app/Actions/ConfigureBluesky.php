<?php

namespace App\Actions;

use App\Actions\Concerns\FetchesModelsForCommands;
use App\Models\Group;
use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;
use Revolution\Bluesky\Facades\Bluesky;
use Spatie\MailcoachSdk\Mailcoach;
use Throwable;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class ConfigureBluesky
{
	use AsAction;
	use FetchesModelsForCommands;
	
	public function handle(Group $group, string $did, string $app_password)
	{
		$group->update([
			'bsky_did' => $did,
			'bsky_app_password' => $app_password,
		]);
	}
	
	public function getCommandSignature(): string
	{
		return 'group:configure-bsky {group?}';
	}
	
	public function asCommand(Command $command): int
	{
		$group = $this->getGroupFromCommand($command);
		
		$did = text('What is the Bluesky DID?', default: (string) $group->bsky_did, required: true);
		$app_password = text('What is the Bluesky app password?', default: (string) $group->bsky_app_password, required: true);
		
		try {
			Bluesky::login($did, $app_password);
		} catch (Throwable $e) {
			$command->error('Unable to log in to Bluesky:');
			$command->error($e->getMessage());
			return 1;
		}
		
		$this->handle($group, $did, $app_password);
		
		$command->info('Bluesky configured!');
		
		return 0;
	}
}
