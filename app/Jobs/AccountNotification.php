<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

use Artisan;
use Log;
use Mail;

class AccountNotification implements ShouldQueue, ShouldBeEncrypted
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private User $user;
	private $type, $args, $callOnDestruct;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct(User $user, string $type, array $args, bool $callOnDestruct = false) {
		$this->user = $user;
		$this->type = $type;
		$this->args = $args;
		$this->callOnDestruct = $callOnDestruct;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(): void {
		// Sets the subject
		if (!isset($this->args['subject']))
			$this->args['subject'] = "Account Update";
		else
			$this->args['subject'] = ($this->args['subject'] == null) ? "Account Update" : $this->args['subject'];

		// Sends the email to every single one of the recipients
		foreach ($this->args['recipients'] as $r) {
			Mail::send(
				"layouts.emails.account.{$this->type}",
				[
					'user' => $this->user,
					'args' => $this->args,
					'recipient' => $r
				],
				function ($m) use ($r) {
					$m->to($r, $r)
						->subject($this->args['subject']);
				}
			);

			// Logs the sent mail
			activity('mailer')
				->byAnonymous()
				->on($this->user)
				->event('mail-sent')
				->withProperties([
					'subject' => $this->args["subject"],
					'recipients' => $this->args["recipients"],
					'email' => $this->args["email"],
					'type' => $this->type,
				])
				->log("Account mail notification sent to {$this->user->getName()}");
		}
	}

	public function __destruct() {
		if ($this->callOnDestruct) {
			Log::info("[AccountNotification] Running Queue");

			$queueArgs = [
				'--stop-when-empty' => true,
				'--tries' => 3,
				'--once' => true
			];

			if ($this->queue != null)
				$queueArgs['--queue'] = $this->queue;

			Artisan::call('queue:work', $queueArgs);
		}
	}
}
