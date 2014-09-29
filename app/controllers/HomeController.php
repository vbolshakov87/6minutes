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
		$existFirstPost = Post::getFirstPost($params['email']);

		if (!empty($existFirstPost)) {
			// if user's first
			if ($existFirstPost->confirmed == Post::POST_STATUS_PENDING) {
				return Redirect::back()->withInput($params)->withErrors(array('Your first post is not approved, you cannot add new posts now'));
			}
			$postData['confirmed'] = $existFirstPost->confirmed;
			$isFirstPost = false;
		} else {
			$isFirstPost = true;
		}

		$post = Post::create($postData);
		//check is approved
		if (!empty($post)) {

			$postData['id'] = $post->id;
			// if this post is first for user - send email to moderator
			if ($isFirstPost) {
				SendMail::sendMailToModerator($postData);
			}

			// success redirect
			return Redirect::to('/')->with('message', 'New post is created');
		}

		// error redirect
		return Redirect::to('create')->with('error', 'New post is not created');
	}
}