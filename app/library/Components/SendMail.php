<?php

class SendMail
{

	public static function sendMailToModerator($postData)
	{
		// get moderator
		$moderator = User::getModerator();

		// send email
		Mail::send(
			'emails.moderate',
			array(
				'post' => $postData,
			), function($message) use ($moderator)
			{
				$message->to($moderator->email);
				$message->subject(date('d.m.Y H:i').' New job post created');
			}
		);
	}


	public static function sendMailToManager($post, $action)
	{
		Mail::send(
			'emails.moderated',
			array(
				'post' => $post->toArray(),
			), function($message) use ($post, $action)
			{
				$message->to($post->email);
				$message->subject(date('d.m.Y H:i').' your first post is '.($action == 'approve' ? 'approved' : 'rejected'));
			}
		);
	}
}