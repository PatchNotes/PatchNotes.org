<?php namespace PatchNotes\Http\Controllers\Account;

use Illuminate\Http\Request;
use PatchNotes\Http\Controllers\Controller;
use PatchNotes\Models\NotificationLevel;
use PatchNotes\Models\Subscription;
use PatchNotes\Models\UserPreference;
use PatchNotes\Models\UserProjectUpdate;

class DashboardController extends Controller {

    /**
     * @var User
     */
    private $user;

    public function __construct() {
        $this->middleware('auth');

        $this->user = Auth::getUser();
        View::share('user', $this->user);
    }

    public function getIndex() {
        return view("account/dashboard/index");
    }

    public function getProfile() {

    }

    public function getSubscriptions() {
        $projectSubscriptions = $this->user->subscriptions->groupBy('project_id')->sortBy('project_update_level_id');

        return view("account/dashboard/subscriptions", compact("projectSubscriptions"));
    }

    public function postSubscriptions(Request $request) {
        foreach ($request->get('subscriptions') as $subKey => $subValues) {
            $subscription = Subscription::where('id', $subKey)
                ->where('project_update_level_id', key($subValues['project_update_level_id']))
                ->firstOrFail();
            if ($subscription->user->id !== Auth::getUser()->id) {
                return abort(400, "Don't do that.");
            }

            $subscription->notification_level_id = head($subValues['project_update_level_id']);
            $subscription->save();
        }

        return redirect()->back()->with('success', true);
    }

    public function getPreferences() {
        $preference = UserPreference::firstOrNew(['user_id' => $this->user->id]);

        return view("account/dashboard/preferences", compact('preference'));
    }

    public function postPreferences(Request $request) {
        $this->validate($request,[

            'timezone' => 'required|timezone',
            'daily_time' => 'required|date_format:H:00:00',
            'weekly_day' => 'required|date_format:l',
            'weekly_time' => 'required|date_format:H:00:00'
        ]);

        $preference = UserPreference::firstOrNew(['user_id' => $this->user->id]);
        $preference->timezone = $data['timezone'];
        $preference->daily_time = $data['daily_time'];
        $preference->weekly_day = $data['weekly_day'];
        $preference->weekly_time = $data['weekly_time'];

        $preference->save();

        return redirect()->back()->with('success', true);

    }

    public function getPendingUpdates() {
        $projectsUpdated = UserProjectUpdate::where('emailed_at', null)->where('user_id', $this->user->id)->get()->groupBy('project_id');

        return view('account/dashboard/pending-updates', compact('projectsUpdated'));
    }

    public function getEmailPreview(Request $request) {
        $nLevel = NotificationLevel::where('key', $request->get('key'))->firstOrFail();
        $userUpdates = UserProjectUpdate::where('emailed_at', null)->where('user_id', $this->user->id)->get();
        $projectsUpdated = $userUpdates->groupBy('project_id');
        $user = $this->user;
        $numUpdates = count($userUpdates);
        $numProjects = count($projectsUpdated);

        return view('emails/html/updates/grouped', compact(
            'projectsUpdated',
            'user',
            'numUpdates',
            'numProjects',
            'nLevel'
        ));
    }


}
