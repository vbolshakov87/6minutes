<?php

use Illuminate\Support\Facades\URL;

/**
 * Post
 *
 * @property-read \User $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\Comment[] $comments
 */
class Post extends Eloquent {

	const POST_STATUS_PENDING = 0;
	const POST_STATUS_APPROVED = 1;
	const POST_STATUS_REJECTED = 2;

	protected $fillable = array('title','description','email','confirmed');

	/**
	 * Returns a formatted post content entry,
	 * this ensures that line breaks are returned.
	 *
	 * @return string
	 */
	public function content()
	{
		return nl2br($this->description);
	}

	/**
	 * Get the post's author.
	 *
	 * @return User
	 */
	public function author()
	{
		return $this->belongsTo('User', 'user_id');
	}


    /**
     * Get the date the post was created.
     *
     * @param \Carbon|null $date
     * @return string
     */
    public function date($date=null)
    {
        if(is_null($date)) {
            $date = $this->created_at;
        }

        return String::date($date);
    }


	public static function getStatus($status)
	{
		switch ($status) {
			case  Post::POST_STATUS_APPROVED : return 'approved';
			case  Post::POST_STATUS_REJECTED : return 'rejectd';
			default : return 'pending';
		}
	}


	/**
	 * @param $params
	 * @return \Illuminate\Validation\Validator
	 */
	public static function validateOnCreate($params)
	{
		// Declare the rules for the form validation
		$rules = array(
			'title'   => 'required|min:3',
			'description' => 'required|min:3',
			'email' => 'required|email|min:3',
		);

		// Validate the inputs
		return Validator::make($params, $rules);
	}


	public static function validateOnApproval($params)
	{
		// validation rules
		$rules = array(
			'id'   => 'required|integer',
			'action' => 'in:approve,reject',
		);

		// Validate the inputs
		return Validator::make($params, $rules);
	}


	public static function getFirstPost($email)
	{
		$existFirstPost = Post::where('email', '=', $email)
			->where('confirmed', '!=', Post::POST_STATUS_REJECTED)
			->limit(1)
			->orderBy('created_at', 'asc')->get();

		return (!empty($existFirstPost[0])) ? $existFirstPost[0] : null;
	}


	public function isPostInPending()
	{
		return $this->confirmed == static::POST_STATUS_PENDING;
	}
}
