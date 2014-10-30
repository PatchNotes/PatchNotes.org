<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'Organization'
 *
 */
class Organization extends Ardent implements Models\Interfaces\Participant
{

    public static $rules = array(
        'name' => 'required',
        'slug' => 'required|unique:organizations',
        'site_url' => 'url',
        'email' => 'required|email',
        'description' => '',
    );

    public function __construct(array $attributes = array())
    {

        parent::__construct($attributes);

        self::events();

    }

    public function projects()
    {
        return $this->morphMany('Project', 'owner');
    }

    public function getNameAttribute()
    {
        return $this->name;
    }

    public function setSlugAttribute($slug) {
        return $this->attributes['slug'] = $slug;
    }

    public function getSlugAttribute()
    {
        return $this->attributes['slug'];
    }

    public function getHrefAttribute() {
        return action('UserController@show', array($this->slug));
    }
    public static function fetchByCreator(User $user)
    {

        return array();
    }

    public function users() {
        return $this->hasMany('OrganizationUser');
    }

    /**
     * Verify we're unique in both users and organizations
     *
     * @return bool
     */
    public static function events()
    {

        self::creating(function ($org) {
            $user = User::where('username', $org->slug)->first();

            if ($user) {
                return false;
            }
        });

        self::updating(function ($org) {
            $user = User::where('username', $org->slug)->first();

            if ($user) {
                return false;
            }
        });

    }

}
