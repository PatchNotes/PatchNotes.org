<?php

use Illuminate\Auth\Reminders\RemindableInterface;
use Illuminate\Auth\UserInterface;

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

    public function getGravatar() {
        $hash = md5($this->attributes['email']);
        return "http://www.gravatar.com/avatar/$hash";
    }
}
