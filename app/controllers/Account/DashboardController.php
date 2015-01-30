<?php
namespace Account;

use App;
use Redirect;
use Sentry,
    User,
    View,
    Response,
    Input;
use Symfony\Component\EventDispatcher\Tests\SubscriberService;
use Validator;

class DashboardController extends BaseController {

    /**
     * @var User
     */
    private $user;

    public function __construct() {
        $this->beforeFilter('auth');

        $this->user = Sentry::getUser();
        View::share('user', $this->user);
    }

    public function getIndex() {
        return View::make("account/dashboard/index", array('user' => $this->user));
    }

    public function getProfile() {

    }

    public function getSubscriptions() {
        $projectSubscriptions = $this->user->subscriptions->groupBy('project_id')->sortBy('project_update_level_id');

        return View::make("account/dashboard/subscriptions", compact("projectSubscriptions"));
    }

    public function postSubscriptions() {
        foreach (Input::get('subscriptions') as $subKey => $subValues) {
            $subscription = \Subscription::where('id', $subKey)
                ->where('project_update_level_id', key($subValues['project_update_level_id']))
                ->firstOrFail();
            if ($subscription->user->id !== Sentry::getUser()->id) {
                return App::abort(400, "Don't do that.");
            }

            $subscription->notification_level_id = head($subValues['project_update_level_id']);
            $subscription->save();
        }

        return \Redirect::back()->with('success', true);
    }

    public function getPreferences() {
        $preference = \UserPreference::firstOrNew(['user_id' => $this->user->id]);

        return View::make("account/dashboard/preferences", compact('preference'));
    }

    public function postPreferences() {
        $data = Input::all();
        $rules = [
            'timezone' => 'required|timezone',
            'daily_time' => 'required|date_format:H:00:00',
            'weekly_day' => 'required|date_format:l',
            'weekly_time' => 'required|date_format:H:00:00'
        ];
        $validator = Validator::make($data, $rules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $preference = \UserPreference::firstOrNew(['user_id' => $this->user->id]);
        $preference->timezone = $data['timezone'];
        $preference->daily_time = $data['daily_time'];
        $preference->weekly_day = $data['weekly_day'];
        $preference->weekly_time = $data['weekly_time'];

        $preference->save();

        return Redirect::back()->with('success', true);

    }

}
