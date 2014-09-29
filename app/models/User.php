<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;
use Zizaco\Entrust\HasRole;

/**
 * User
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\Config::get('entrust::role[] $roles
 */
class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait, HasRole;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	protected static $_moderator = null;

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');


	public static function confirmationCode()
	{
		return md5(microtime().Config::get('app.key'));
	}


	public static function getModerator()
	{
		if (is_null(static::$_moderator)) {
			static::$_moderator = static::find(1);
		}
		return static::$_moderator;
	}
}
