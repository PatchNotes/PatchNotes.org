<?php
namespace PatchNotes\Controllers;

use App;
use Event;
use Sentry;
use SentrySocial;
use Input;
use Redirect;
use URL;
use Validator;
use View;

class AccountController extends BaseController {

    private $providers = array('github', 'bitbucket');

    public function __construct() {
        $this->beforeFilter('guest', ['only' => ['getLogin', 'postLogin', 'getRegister', 'postRegister']]);
    }

    public function getAuth($provider) {
        if (!in_array($provider, $this->providers)) {
            App::abort(404, "Provider not found.");
        }

        $callback = URL::to("account/callback/$provider");
        $url = SentrySocial::getAuthorizationUrl($provider, $callback);

        return Redirect::to($url);
    }

    public function getCallback($provider) {
        if (!in_array($provider, $this->providers)) {
            App::abort(404, "Provider not found.");
        }

        // Callback is required for providers such as Facebook and a few others (it's required
        // by the spec, but some providers ommit this).
        $callback = URL::current();

        try {
            $user = SentrySocial::authenticate($provider, URL::current(), function (\Cartalyst\SentrySocial\Links\LinkInterface $link, $provider, $token, $slug) {
                $user = $link->getUser(); // Modify the user in question

                // You could add your custom data
                $data = $provider->getUserDetails($token);

                $user->username = $data->nickname;

                $user->save();
            });

            return Redirect::to('/');
        } catch (\Cartalyst\SentrySocial\AccessMissingException $e) {
            // Missing OAuth parameters were missing from the query string.
            // Either the person rejected the app, or the URL has been manually
            // accesed.
            if ($error = Input::get('error')) {
                return Redirect::to('oauth')->withErrors($error);
            }

            App::abort(404);
        }
    }

    public function getLogin() {
        return View::make('account.login');
    }

    public function postLogin() {
        $input = Input::all();

        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::to('account/login')->withErrors($validator);
        }

        try {
            // Set login credentials
            $credentials = array(
                'email' => $input['email'],
                'password' => $input['password'],
            );

            // Try to authenticate the user
            $user = Sentry::authenticate($credentials, true);
            Event::fire('user.login', array($user));

            return Redirect::to('panel/user/index');
        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return Redirect::to('account/login')->withErrors(['Login field is required.']);
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return Redirect::to('account/login')->withErrors(['Password field is required.']);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('account/login')->withErrors(['User was not found.']);
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return Redirect::to('account/login')->withErrors(['User is not activated.']);
        } // The following is only required if throttle is enabled
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return Redirect::to('account/login')->withErrors(['User is suspended.']);
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            return Redirect::to('account/login')->withErrors(['User is banned.']);
        }
    }

    public function getRegister() {
        return View::make('account.register', array('bodyclass' => 'smaller-container'));
    }

    public function postRegister() {
        $input = Input::all();

        $rules = array(
            'username' => 'required|min:2|max:32|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::to('account/register')->withErrors($validator);
        }

        try {
            $user = Sentry::register(
                array(
                    'username' => $input['username'],
                    'email' => $input['email'],
                    'password' => $input['password']
                )
            );
            $activationCode = $user->getActivationCode();

            Event::fire('user.register', array($user, $activationCode));

            return Redirect::to('account/thanks');
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            return Redirect::to('account/register')->withErrors(['User with this login already exists.']);
        }
    }

    public function getThanks() {
        return View::make('account.thanks');
    }

    public function getValidate($email, $key) {
        try {
            // Find the user using the user id
            $user = Sentry::getUserProvider()->findByLogin($email);

            // Attempt to activate the user
            if ($user->attemptActivation($key)) {
                Sentry::login($user, true);

                return Redirect::to('/help/welcome');
            } else {
                return Redirect::to('account/login');
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('account/register')->withErrors(['User was not found.']);
        } catch (\Cartalyst\SEntry\Users\UserAlreadyActivatedException $e) {
            return Redirect::to('account/login')->withErrors(['User is already activated.']);
        }
    }

    public function getForgot() {
        return View::make('account.forgot');
    }

    public function postForgot() {
        $input = Input::all();

        $rules = array(
            'email' => 'required|email'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::to('account/forgot')->withErrors($validator);
        }


        try {
            // Find the user using the user email address
            $user = Sentry::getUserProvider()->findByLogin($input['email']);

            $forgotCode = $user->getResetPasswordCode();
            Event::fire('user.forgot', array($user, $forgotCode));

            return Redirect::to('account/resetting');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to('account/forgot')->withErrors(['User was not found.']);
        }
    }

    public function getResetting() {
        return View::make('account.resetting');
    }

    public function getReset($email, $code) {
        return View::make('account.reset', array('email' => $email, 'code' => $code));
    }

    public function postReset() {
        $input = Input::all();

        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'code' => 'required'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return Redirect::to(URL::to('account/reset', array($input['email'], $input['code'])))->withErrors(
                $validator
            );
        }

        try {
            // Find the user using the user id
            $user = Sentry::getUserProvider()->findByLogin($input['email']);

            // Check if the reset password code is valid
            if ($user->checkResetPasswordCode($input['code'])) {
                // Attempt to reset the user password
                if ($user->attemptResetPassword($input['code'], $input['password'])) {
                    return Redirect::to('account/login');
                } else {
                    return Redirect::to('account/forgot');
                }
            } else {
                return Redirect::to(URL::to('account/reset', array($input['email'], $input['code'])))->withErrors(['Invalid reset key.']);
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return Redirect::to(URL::to('account/reset', array($input['email'], $input['code'])))->withErrors(['User was not found.']);
        }
    }

    public function getLogout() {
        Sentry::logout();

        return Redirect::to('');
    }
}
