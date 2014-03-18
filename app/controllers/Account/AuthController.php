<?php
namespace Account;

use App;
use Input;
use Redirect;
use Request;
use URL;

class AuthController extends BaseController
{
	public function __construct()
	{
		$provider = Request::segment(2);
		// TODO Validate available providers
		$this->provider = App::make("PatchNotes\OAuth\\{$provider}Provider");
	}

	public function getOAuthStart($provider)
	{
		return Redirect::to($this->provider->getAuthorizationUri());
	}

	public function getOAuthCallback($provider)
	{
		if (!Input::has('code')) return App::abort(404);

		if (!$this->provider->authorizeUser(Input::get('code')))
		{
			App::abort(404, 'OAuth authorization has failed'); // TODO A pretty error page
		}

		$oauthUser = $this->provider->getUserDetails();

		return 'Welcome to PatchNotes from ' . $oauthUser['provider'] . ' OAuth user ' . $oauthUser['username'];

		// TODO pass the oauth user details to the account listener
		// TODO Redirect with a 301 so that callback URL isn't in history
	}

	public function localAccountExistsConfirmMerge()
	{
		// TODO send email and redirect
	}

	public function localAccountCreated()
	{
		// TODO do login
		// TODO redirect to their account
	}
}