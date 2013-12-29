<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;

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
 */
class User extends Cartalyst\Sentry\Users\Eloquent\User {

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

    protected $defaultLevels = array(
        10 => 168,
        50 => 24,
        100 => 0
    );

    public function subscriptions() {
        return $this->hasMany('Subscription');
    }

    public function getGravatar() {
        $hash = md5($this->attributes['email']);
        return "http://www.gravatar.com/avatar/$hash";
    }

    /**
     * Get the users default settings. If the user changes these they'll be
     * saved in the database with the NULL project_id
     *
     * @return array
     */
    public function getDefaultLevels() {

        $subscriptions = Subscription::where(array(
            'user_id' => $this->id,
            'project_id' => NULL
        ))->get();

        $dbSubscriptions = array();
        foreach($subscriptions as $subscription) {
            $dbSubscriptions[$subscription->subscription_level] = $subscription->notification_level;
        }

        return array_merge($dbSubscriptions, $this->defaultLevels);
    }
}
