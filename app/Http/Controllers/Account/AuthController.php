<?php namespace PatchNotes\Http\Controllers\Account;

use Cartalyst\Sentry\Facades\Laravel\Sentry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use PatchNotes\Contracts\UserCreatorListener;
use PatchNotes\Http\Controllers\Controller;
use PatchNotes\Services\UserCreator;

class AuthController extends Controller implements UserCreatorListener
{
    /**
     * Start the oAuth process
     *
     * @param $provider string
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getOAuthStart($provider)
    {
        $provider = App::make("PatchNotes\\Providers\\OAuth\\{$provider}Provider"); // TODO validate if logins/registrations are allowed
        return redirect($provider->getAuthorizationUri());
    }

    /**
     * oAuth callback
     *
     * @param Request $request
     * @param $provider string
     * @return func|void
     */
    public function getOAuthCallback(Request $request, $provider)
    {
        $provider = App::make("PatchNotes\\Providers\\OAuth\\{$provider}Provider"); // TODO validate if logins/registrations are allowed

        $this->validate($request, ['code' => 'required']);

        if (!$provider->authorizeUser($request->get('code'))) {
            return redirect('auth/oauth-error')->withErrors(['Authorization code was rejected by the ' . $provider]);
        }

        $oauthUser = $provider->getUserDetails();

        $userCreator = new UserCreator($this);
        return $userCreator->createUserFromOAuth($oauthUser);
    }

    /**
     * oAuth user is valid: perform login
     *
     * @param $oauthUser object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function oauthUserIsValid($oauthUser)
    {
        $user = Sentry::findUserById($oauthUser->user->id);
        Sentry::loginAndRemember($user);

        return redirect('/');
    }

    /**
     * oAuth user connected but requires validation: send email and redirect
     * to the validation-required page
     *
     * @param $oauthUser object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function oauthUserRequiresValidation($oauthUser)
    {
        if (!is_null($oauthUser->user->unsubscribed_at)) {
            App::abort(404, "Can't validate user when unsubscribed_at is not null.");
        }

        Mail::send('emails.auth.oauth-validation', array('oauth' => $oauthUser), function ($m) use ($oauthUser) {
            $m->to($oauthUser->user->email)->subject('PatchNotes oAuth validation');
        });

        return redirect('auth/validation-required');
    }

    /**
     * User has been connected to a new oAuth account
     *
     * @param $oauthUser object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function oauthAssociationCreated($oauthUser)
    {
        return redirect('auth/account-connected');
    }

    /**
     * User has registered an account via oAuth
     *
     * @param $user object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userRegisteredFromOauth($user)
    {
        $user = Sentry::findUserById($user->id);
        Sentry::loginAndRemember($user);

        return redirect('/');
    }

    /**
     * Registration via oAuth failed
     *
     * @param $errors array
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userRegistrationFromOauthFailed($errors)
    {
        return redirect('auth/oauth-error')->withErrors($errors);
    }

    /**
     * Tell user that validation is required
     *
     * @return \Illuminate\View\View
     */
    public function getValidationRequired()
    {
        return view('auth.validation-required');
    }

    /**
     * Tell user that the account is now connected
     *
     * @return \Illuminate\View\View
     */
    public function getAccountConnected()
    {
        return view('auth.account-connected');
    }

    /**
     * Tell the user that there was an error authentication via oAuth
     *
     * @return \Illuminate\View\View
     */
    public function getOauthError()
    {
        return view('auth.error');
    }

    public function getValidateAccount($key)
    {
        $userCreator = new UserCreator($this);
        return $userCreator->validateAuth($key);
    }

    public function accountValidated()
    {
        return redirect('auth/account-connected');
    }
}