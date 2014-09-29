<?php

/**
 * Controller for the moderation stuff
 * Class AdminController
 */
class AdminController extends BaseController
{
	/**
	 * Instantiate a new AdminController instance.
	 */
	public function __construct()
	{
		// only authorized users can access
		$this->beforeFilter('auth');

		// only admin can access
		if (!Auth::user()->hasRole(Role::ROLE_ADMIN)) {
			return Redirect::to('/')->with('message', 'Permission denied');
		}
	}


	/**
	 * Moderate page for one post
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function moderate($id)
	{
		$title = 'Post to approve';

		$post = Post::find($id);
		if (empty($post)) {
			return Redirect::to('index')->with('error', 'Post '.$id.' does not exist');
		}

		return View::make('admin.moderate', array(
			'title' => $title,
			'posts' => array($post),
			'canApprove' => true,
		));
	}


	/**
	 * List of all posts need to be moderated
	 * @return \Illuminate\View\View
	 */
	public function moderateAll()
	{
		$title = 'Posts to approve';

		// get all posts in moderation status
		$posts = Post::where('confirmed', '=', Post::POST_STATUS_PENDING)->get();

		return View::make('admin.moderate', array(
			'title' => $title,
			'posts' => $posts,
			'canApprove' => true,
		));
	}


	/**
	 * Process Moderate Image
	 * @param $action
	 * @param $id
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function doModerate($action, $id)
	{
		// url for redirect if something is wrong
		$postModerateUrl = URL::to('moderate', array('id' => $id));

		$params = array(
			'id'   => $id,
			'action' => $action,
		);

		$validator = Post::validateOnApproval($params);

		// if data is not valid - do nothing and redirect to home page
		if (!$validator) {
			return Redirect::to('index', array('id'))->with('error', 'Data is not valid');
		}

		// get current post
		$post = Post::find($id);
		if (empty($post)) {
			return Redirect::to('index')->with('error', 'Post '.$id.' does not exist');
		}

		/*
		// only pending posts can be approved
		if ($post->confirmed != Post::POST_STATUS_PENDING) {
			return Redirect::to($postModerateUrl)->with('error', 'User '.$post->email.' is not under moderation');
		}*/

		$newConfirm = $action == 'approve'? Post::POST_STATUS_APPROVED : Post::POST_STATUS_REJECTED;
		if ($post->confirmed == $newConfirm) {
			return Redirect::to($postModerateUrl)->with('message', 'User '.$post->email.' is already '.$action.'ed. Email is not sent');
		}

		// save new confirmed status
		$post->confirmed = $newConfirm;
		if (!$post->save()) {
			return Redirect::to($postModerateUrl)->with('error', 'User '.$post->email.' is not updated');
		}

		SendMail::sendMailToManager($post, $action);

		return Redirect::to($postModerateUrl)->with('message', 'User '.$post->email.' is '.$action.'ed');
	}
} 