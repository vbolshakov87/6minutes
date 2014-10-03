<?php
use Illuminate\Support\Facades\URL;

class MailQueue extends Eloquent {

	const TYPE_MANAGER = 'user';
	const TYPE_MODERATOR = 'moderator';

	const STATUS_PENDIDNG = 'pending';
	const STATUS_IN_PROGRESS = 'in process';
	const STATUS_DONE = 'done';
	const STATUS_FAILED = 'failed';

	protected $fillable = array('subject','to','type','data', 'status');


	public static function arrayToString($data)
	{
		return json_encode($data);
	}

	public static function stringToArray($data)
	{
		return json_decode($data, true);
	}
}
