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

    // Fill in attributes
    // ==================
    public function setSlugAttribute($slug) {
        return $this->attributes['slug'] = $slug;
    }

    public function getNameAttribute() {
        return $this->attributes['name'];
    }

    public function getSlugAttribute() {
        return $this->attributes['slug'];
    }

    public function getHrefAttribute() {
        return action('OrganizationController@show', array($this->slug));
    }

    // Pivot
    // =====

    public function users() {
        return $this->belongsToMany('User')->withPivot(['creator']);
    }

    public function creator() {
        $org = $this;
        $user = Organization::with(array('users' => function($query) use($org) {
            $query->where('creator', true);
            $query->where('organization_id', $org->id);
        }))->find(1);

        return $user;
    }

    // Helper
    // ======
    public static function fetchByCreator(User $creator) {
        return $creator->organizations()->wherePivot('creator', true)->get();
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
