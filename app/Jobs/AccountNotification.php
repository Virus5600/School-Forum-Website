<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Enums\EmailVerificationType;

use App\Models\User;

use Artisan;
use Log;
use Mail;

/**
 * Sends an email notification to the user.
 *
 * When dispatching this job, you can pass the following arguments:
 *
 * - `user` (User): The user affected by the notification
 * - `type` (EmailVerificationType|string): The type of notification to send
 * - `args` (array): The arguments to pass to the email view
 * - `callOnDestruct` (bool): Whether to call the queue on destruct
 *
 * The `args` array should at least contain the following keys:
 *
 * - `subject` (string): The subject of the email
 * - `recipients` (array): The recipients of the email
 * - `email` (string): The email address of the sender or initiator
 *
 * @package App\Jobs
 * @version 1.0.0
 */
class AccountNotification implements ShouldQueue, ShouldBeEncrypted
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	private User $user;
	private $type, $args, $callOnDestruct;

	/**
	 * Create a new job instance.
	 *
	 * @param User $user							The user affected by the notification
	 * @param EmailVerificationType|string $type	The type of notification to send
	 * @param array $args							The arguments to pass to the email view
	 * @param bool $callOnDestruct					Whether to call the queue on destruct
	 *
	 * @return void
	 */
	public function __construct(User $user, EmailVerificationType|string $type, array $args, bool $callOnDestruct = false) {
		if ($type instanceof EmailVerificationType)
			$type = $type->value;

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
			Log::info("[AccountNotification] Running Queue ({$this->queue})");

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
