<?php namespace PatchNotes\Http\Controllers\Account;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Http\Request;
use PatchNotes\Commands\UserRegistered;
use PatchNotes\Http\Controllers\Controller;
use Sentry;

class AccountController extends Controller
{
    protected $redirectPath;

    /**
     * Create a new authentication controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    public function getLogin()
    {
        return view('account.login');
    }

    public function postLogin(Request $request)
    {
        if (isset($input['register'])) {
            return redirect('account/register')->withInput();
        }

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {

            // Set login credentials
            $credentials = array(
                'email' => $request->get('email'),
                'password' => $request->get('password'),
            );

            // Try to authenticate the user
            $user = Sentry::authenticate($credentials, true);

            return redirect()->intended($this->redirectPath());

        } catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
            return redirect('account/login')->withErrors(['Login field is required.']);
        } catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
            return redirect('account/login')->withErrors(['Password field is required.']);
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return redirect('account/login')->withErrors(['User was not found.']);
        } catch (\Cartalyst\Sentry\Users\UserNotActivatedException $e) {
            return redirect('account/login')->withErrors(['User is not activated.']);
        } // The following is only required if throttle is enabled
        catch (\Cartalyst\Sentry\Throttling\UserSuspendedException $e) {
            return redirect('account/login')->withErrors(['User is suspended.']);
        } catch (\Cartalyst\Sentry\Throttling\UserBannedException $e) {
            return redirect('account/login')->withErrors(['User is banned.']);
        }
    }

    public function getRegister()
    {
        return view('account.register', array('bodyclass' => 'smaller-container'));
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:2|max:32|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        try {
            $user = Sentry::register(array(
                'username' => $request->get('username'),
                'email' => $request->get('email'),
                'password' => $request->get('password')
            ));

            $this->dispatch(
                new UserRegistered($user)
            );

            return redirect('account/thanks');
        } catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
            return redirect('account/register')->withErrors(['User with this login already exists.']);
        }
    }

    public function getThanks()
    {
        return view('account.thanks');
    }

    public function getValidate($email, $key)
    {
        try {
            // Find the user using the user id
            $user = Sentry::getUserProvider()->findByLogin($email);

            // Attempt to activate the user
            if ($user->attemptActivation($key)) {
                Sentry::login($user, true);

                return redirect('/help/welcome');
            } else {
                return redirect('account/login');
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return redirect('account/register')->withErrors(['User was not found.']);
        } catch (\Cartalyst\SEntry\Users\UserAlreadyActivatedException $e) {
            return redirect('account/login')->withErrors(['User is already activated.']);
        }
    }

    public function getForgot()
    {
        return view('account.forgot');
    }

    public function postForgot()
    {
        $input = Input::all();

        $rules = array(
            'email' => 'required|email'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect('account/forgot')->withErrors($validator);
        }


        try {
            // Find the user using the user email address
            $user = Sentry::getUserProvider()->findByLogin($input['email']);

            $forgotCode = $user->getResetPasswordCode();
            Event::fire('user.forgot', array($user, $forgotCode));

            return redirect('account/resetting');
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return redirect('account/forgot')->withErrors(['User was not found.']);
        }
    }

    public function getResetting()
    {
        return view('account.resetting');
    }

    public function getReset($email, $code)
    {
        return view('account.reset', array('email' => $email, 'code' => $code));
    }

    public function postReset()
    {
        $input = Input::all();

        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
            'code' => 'required'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect(URL::to('account/reset', array($input['email'], $input['code'])))->withErrors(
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
                    return redirect('account/login');
                } else {
                    return redirect('account/forgot');
                }
            } else {
                return redirect(URL::to('account/reset',
                    array($input['email'], $input['code'])))->withErrors(['Invalid reset key.']);
            }
        } catch (\Cartalyst\Sentry\Users\UserNotFoundException $e) {
            return redirect(URL::to('account/reset',
                array($input['email'], $input['code'])))->withErrors(['User was not found.']);
        }
    }

    public function getLogout()
    {
        Sentry::logout();

        return redirect('');
    }

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (property_exists($this, 'redirectPath')) {
            return $this->redirectPath;
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/';
    }

    /**
     * Get the path to the login route.
     *
     * @return string
     */
    public function loginPath()
    {
        return property_exists($this, 'loginPath') ? $this->loginPath : '/account/login';
    }
}
