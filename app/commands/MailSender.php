<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MailSender extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'mail:sender';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command for mail sending';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$start = microtime(true);
		echo "\nstart\n";

		$mailDataArr = MailQueue::where('status', '=', MailQueue::STATUS_PENDIDNG)->get();

		// set correct statuses, in order to use queue in several streams
		foreach ($mailDataArr as $mailQueue) {
			$mailQueue->status = MailQueue::STATUS_IN_PROGRESS;
			$mailQueue->save();
		}

		// send mails
		foreach ($mailDataArr as $mailQueue) {
			if ($mailQueue->type == MailQueue::TYPE_MODERATOR) {
				$method = 'sendMailToModerator';
			} else {
				$method = 'sendMailToManager';
			}

			try {
				// send email process
				call_user_func_array(array('ProjectMailer', $method), array(
					'postData' => MailQueue::stringToArray($mailQueue->data),
					'to' => $mailQueue->to,
					'subject' => $mailQueue->subject
				));
			} catch (Exception $e) {
				$mailQueue->status = MailQueue::STATUS_FAILED;
				$mailQueue->save();
			}


			$mailQueue->status = MailQueue::STATUS_DONE;
			$mailQueue->save();
		}

		$total = microtime(true) - $start;
		echo "\nfinish, took: $total ms\n";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
