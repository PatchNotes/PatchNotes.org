<?php
namespace Account;

use App;
use Input;
use Mail;
use PatchNotes\Users\UserCreator;
use PatchNotes\Users\UserCreatorListenerInterface;
use Redirect;
use Request;
use Sentry;
use URL;
use View;

class AuthController extends BaseController implements UserCreatorListenerInterface
{
    /**
     * Start the oAuth process
     *
     * @param $provider string
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getOAuthStart($provider)
    {
        $provider = App::make("PatchNotes\OAuth\\{$provider}Provider"); // TODO validate if logins/registrations are allowed
        return Redirect::to($provider->getAuthorizationUri());
    }

    /**
     * oAuth callback
     *
     * @param $provider string
     * @return \PatchNotes\Users\func|void
     */
    public function getOAuthCallback($provider)
    {
        $provider = App::make("PatchNotes\OAuth\\{$provider}Provider"); // TODO validate if logins/registrations are allowed

        if (!Input::has('code'))
        {
            return Redirect::to('auth/oauth-error')->withErrors(['Authorization code missing']);
        }

        if (!$provider->authorizeUser(Input::get('code')))
        {
            return Redirect::to('auth/oauth-error')->withErrors(['Authorization code was rejected by the ' . $provider]);
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

        return Redirect::to('/');
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
        if(!is_null($oauthUser->user->unsubscribed_at)) {
            App::abort(404, "Can't validate user when unsubscribed_at is not null.");
        }

        Mail::send('emails.auth.oauth-validation', array('oauth' => $oauthUser), function ($m) use ($oauthUser) {
            $m->to($oauthUser->user->email)->subject('PatchNotes oAuth validation');
        });

        return Redirect::to('auth/validation-required');
    }

    /**
     * User has been connected to a new oAuth account
     *
     * @param $oauthUser object
     * @return \Illuminate\Http\RedirectResponse
     */
    public function oauthAssociationCreated($oauthUser)
    {
        return Redirect::to('auth/account-connected');
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

        return Redirect::to('/');
    }

    /**
     * Registration via oAuth failed
     *
     * @param $errors array
     * @return \Illuminate\Http\RedirectResponse
     */
    public function userRegistrationFromOauthFailed($errors)
    {
        return Redirect::to('auth/oauth-error')->withErrors($errors);
    }

    /**
     * Tell user that validation is required
     *
     * @return \Illuminate\View\View
     */
    public function getValidationRequired()
    {
        return View::make('auth.validation-required');
    }

    /**
     * Tell user that the account is now connected
     *
     * @return \Illuminate\View\View
     */
    public function getAccountConnected()
    {
        return View::make('auth.account-connected');
    }

    /**
     * Tell the user that there was an error authentication via oAuth
     *
     * @return \Illuminate\View\View
     */
    public function getOauthError()
    {
        return View::make('auth.error');
    }

    public function getValidateAccount($key)
    {
        $userCreator = new UserCreator($this);
        return $userCreator->validateAuth($key);
    }

    public function accountValidated()
    {
        return Redirect::to('auth/account-connected');
    }
}