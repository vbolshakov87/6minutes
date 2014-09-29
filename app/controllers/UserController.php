<?php
class UserController extends BaseController
{
	/**
	 * Show login page
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function showLogin()
	{
		if (Auth::check()) {
			return Redirect::to('/');
		}

		return View::make('user.login');
	}


	/**
	 * Process login
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function doLogin()
	{
		if (Auth::check()) {
			return Redirect::to('/');
		}

		// validation rules
		$rules = array(
			'username'    => 'required|min:3',
			'password' => 'required|min:3'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Redirect::to('auth')
				->withErrors($validator)
				->withInput(Input::except('password'));
		} else {
			// create our user data for the authentication
			$userdata = array(
				'username' => Input::get('username'),
				'password' => Input::get('password')
			);

			// attempt to do the login
			if (Auth::attempt($userdata)) {
				return Redirect::to('/');
			} else {
				// validation not successful, send back to form
				return
					Redirect::to('login')
					->withErrors(array(
							'Login/password is incorrect'
						))
					->withInput(Input::except('password'));
			}
		}
	}


	/**
	 * Process logout
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function doLogout()
	{
		Auth::logout();
		return Redirect::to('login');
	}
} 