<?php namespace PatchNotes\Models;

use Illuminate\Database\Eloquent\Model;
use PatchNotes\Contracts\Participant;

/**
 * An Eloquent Model: 'User'
 *
 * @property integer $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property string $permissions
 * @property boolean $activated
 * @property string $activation_code
 * @property \Carbon\Carbon $activated_at
 * @property \Carbon\Carbon $last_login
 * @property string $persist_code
 * @property string $reset_password_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Sentry\Groups\Eloquent\Group[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\Subscription[] $subscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\UserOauth[] $oauthAccounts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|\Organization[] $organizations
 * @property-read mixed $name
 * @property-read mixed $slug
 * @property-read mixed $href
 * @method static \Illuminate\Database\Query\Builder|\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePermissions($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereActivated($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereActivationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereActivatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereLastLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\User wherePersistCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereResetPasswordCode($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUpdatedAt($value)
 * @property string $unsubscribe_token
 * @property string $unsubscribed_at
 * @property-read \PatchNotes\Models\UserPreference $preferences
 * @property-read mixed $fullname
 * @method static \Illuminate\Database\Query\Builder|\User whereUnsubscribeToken($value)
 * @method static \Illuminate\Database\Query\Builder|\User whereUnsubscribedAt($value)
 * @property-read mixed $gravatar 
 * @method static \Illuminate\Database\Query\Builder|\PatchNotes\Models\User whereFullname($value)
 */
class User extends \Cartalyst\Sentry\Users\Eloquent\User implements Participant
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = array('password');

    protected $fillable = ['username', 'fullname', 'email', 'password', 'activated', 'activation_code', 'activated_at', 'last_login', 'persist_code', 'reset_password_code'];

    protected $defaultLevels = array(
        array(
            'notification_level' => 168,
            'project_update_level' => 10
        ),
        array(
            'notification_level' => 24,
            'project_update_level' => 50
        ),
        array(
            'notification_level' => 0,
            'project_update_level' => 100
        ),
    );

    public function preferences()
    {
        return $this->hasOne('PatchNotes\Models\UserPreference');
    }

    public function oauthAccounts()
    {
        return $this->hasMany('PatchNotes\Models\UserOauth', 'user_id', 'id');
    }

    public function projects()
    {
        return $this->morphMany('PatchNotes\Models\Project', 'owner');
    }

    public function organizations()
    {
        return $this->belongsToMany('PatchNotes\Models\Organization', 'organization_user');
    }

    public function subscriptions()
    {
        return $this->hasMany('PatchNotes\Models\Subscription');
    }

    public function getGravatarAttribute()
    {
        $hash = md5($this->email);
        return "http://www.gravatar.com/avatar/$hash?s=200&d=retro";
    }

    public function getNameAttribute()
    {
        return $this->username;
    }

    public function getSlugAttribute()
    {
        return $this->username;
    }

    public function getHrefAttribute()
    {
        return action('UserController@getUser', array($this->slug));
    }

    public function getSubscriptionLevel(Project $project, $updateLevel)
    {

    }

    public function isMember(Project $project)
    {
        if ($project->owner instanceof Organization) {

            foreach ($project->owner->users as $user) {
                if ($user->id === $this->id) {
                    return true;
                }
            }

        } elseif ($project->owner instanceof User) {
            if ($project->owner->id === $this->id) {
                return true;
            }
        } else {
            throw new \Exception("Project doesn't have an owner.");
        }

        return false;
    }

    /**
     * Get the users default settings. If the user changes these they'll be
     * saved in the database with the NULL project_id
     *
     * @return array
     */
    public function getDefaultLevels()
    {
        $subscriptions = Subscription::where('user_id', $this->id)->where('project_id', NULL)->get();

        $dbSubscriptions = array();
        foreach ($subscriptions as $subscription) {
            $dbSubscriptions[$subscription->project_update_level_id] = $subscription->notification_level_id;
        }

        return array_merge($dbSubscriptions, $this->defaultLevels);
    }

    /**
     * @param ProjectUpdate $update
     * @return NotificationLevel
     */
    public function getNotificationLevel(ProjectUpdate $update)
    {
        $subscription = Subscription::where('user_id', $this->id)
            ->where('project_id', $update->project->id)
            ->where('project_update_level_id', $update->id)
            ->first();

        if (is_null($subscription)) {
            return $this->getDefaultNotificationLevel($update->level);
        }

        return NotificationLevel::where('id', $subscription->notification_level_id)->first();
    }

    /**
     * Fetch a users default notification level
     *
     * @param $updateLevel
     * @return NotificationLevel
     * @throws Exception
     */
    public function getDefaultNotificationLevel($level)
    {
        $projectUpdateLevel = ProjectUpdateLevel::where('level', $level)->firstOrFail();
        $subscription = Subscription::where('user_id', $this->id)->where('project_id', NULL)->where('project_update_level_id', $projectUpdateLevel->id)->first();

        if ($subscription) {
            return NotificationLevel::where('level', $subscription->notification_level)->first();
        }

        foreach ($this->defaultLevels as $level) {
            if ($level['project_update_level'] == $projectUpdateLevel->level) return NotificationLevel::where('level', $level['notification_level'])->first();
        }

        throw new \Exception("No default level found, updateLevel must be out of range.");
    }

}
