<?php

class HomeController extends BaseController {

	protected $layout = "layouts.main";

	/**
	 * Home page action
	 * @return \Illuminate\View\View
	 */
	public function index()
	{
		$title = 'All active posts';

		$posts = Post::where('confirmed', '=',  1)->orderBy('posts.updated_at', 'desc')->get();

		return View::make('home.index', array(
			'title' => $title,
			'posts' => $posts,
			'canApprove' => false,
		));
	}


	/**
	 * Page for offer create
	 * @return \Illuminate\View\View
	 */
	public function showCreate()
	{
		return View::make('home.create');
	}


	/**
	 * Process ofer create
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function postCreate()
	{
		// set that post is first for the user
		$isFirstPost = false;

		// pre validation
		$params = Input::all();
		foreach ($params as $key => $value) {
			$params[$key] = htmlspecialchars($value);
		}

		$validator = Post::validateOnCreate($params);

		// Check if the form validates with success
		if (!$validator->passes()) {
			// Form validation failed
			return Redirect::back()->withInput($params)->withErrors($validator);
		}

		// raw post data for save
		$postData = array(
			'title' => $params['title'],
			'description' => nl2br($params['description']),
			'email' => $params['email'],
			'confirmed' => Post::POST_STATUS_PENDING,
		);

		// check if user already created post before
		/** @var Post $existFirstPost */
		$existFirstPost = Post::getFirstPost($params['email']);
		if (!empty($existFirstPost)) {
			// if user's first post
			if ($existFirstPost->isPostInPending()) {
				return Redirect::back()->withInput($params)->withErrors(array('Your first post is not approved, you cannot add new posts now'));
			}
			$postData['confirmed'] = $existFirstPost->confirmed;
		} else {
			$isFirstPost = true;
		}

		$post = Post::create($postData);
		//check is approved
		if (!empty($post)) {

			$postData['id'] = $post->id;
			// if this post is first for user - send email to moderator
			if ($isFirstPost) {
				ProjectMailer::prepareMailToModerator($postData);
			}

			// success redirect
			$message = 'New post is created';
			if ($isFirstPost) {
				$message .= ', your post is under moderation now';
			}
			return Redirect::to('/')->with('message', $message);
		}

		// error redirect
		return Redirect::to('create')->with('error', 'New post is not created');
	}
}
