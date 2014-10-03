<?php

class ProjectMailer
{

	public static function sendMailToModerator($postData, $to, $subject)
	{
		// send email
		Mail::send(
			'emails.moderate',
			array(
				'post' => $postData,
			), function($message) use ($to, $subject)
			{
				$message->to($to);
				$message->subject($subject);
			}
		);

		return true;
	}


	public static function sendMailToManager($postData, $to, $subject)
	{
		Mail::send(
			'emails.moderated',
			array(
				'post' => $postData,
			), function($message) use ($to, $subject)
			{
				$message->to($to);
				$message->subject($subject);
			}
		);

		return true;
	}


	public static function prepareMailToModerator($postData)
	{
		// get moderator
		$moderator = User::getModerator();

		MailQueue::create(array(
			'subject' => date('d.m.Y H:i').' New job post created',
			'to' => $moderator->email,
			'type' => MailQueue::TYPE_MODERATOR,
			'data' => MailQueue::arrayToString($postData),
		));

		return true;
	}


	public static function prepareMailToManager($post, $action)
	{
		MailQueue::create(array(
			'subject' => date('d.m.Y H:i').' your first post is '.($action == 'approve' ? 'approved' : 'rejected'),
			'to' => $post['email'],
			'type' => MailQueue::TYPE_MANAGER,
			'data' => MailQueue::arrayToString($post),
		));

		return true;
	}
}