<?php

namespace App\Actions\Emails;

use App\Actions\Concerns\FetchesModelsForCommands;
use App\Models\Meetup;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsAction;

class SendRsvpReceipt
{
	use AsAction;
	use FetchesModelsForCommands;
	
	protected ?string $abort_reason = null;
	
	public function handle(Meetup $meetup, User $user): bool
	{
		if (! $meetup->group->email) {
			$this->abort_reason = 'No group email';
			return false;
		}
		
		if (! $mailcoach = $meetup->group->mailcoach()) {
			$this->abort_reason = 'Mailcoach not configured';
			return false;
		}
		
		$transactional_email = $meetup->group->mailcoach_transactional_emails()
			->where('action_name', static::class)
			->first();
		
		if (! $transactional_email) {
			$this->abort_reason = 'Transactional message not configured';
			return false;
		}
		
		$mailcoach->sendTransactionMail(
			name: $transactional_email->mail_name,
			from: $meetup->group->email,
			to: $user->email,
			replacements: Arr::dot([
				'meetup' => $meetup->toArray(),
				'user' => $user->toArray(),
			]),
		);
		
		return true;
	}
	
	public function getCommandSignature(): string
	{
		return 'email:send-rsvp-receipt {meetup?} {user?}';
	}
	
	public function asCommand(Command $command): int
	{
		$meetup = $this->getMeetupFromCommand($command);
		$user = $this->getUserFromCommand($command, $meetup);
		
		if ($this->handle($meetup, $user)) {
			$command->info('Receipt sent!');
			return 0;
		}
		
		$command->error("Receipt not sent because: {$this->abort_reason}");
		return 1;
	}
}
