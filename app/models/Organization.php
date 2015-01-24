<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'Organization'
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $site_url
 * @property string $email
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Project[] $projects
 * @property-read mixed $href
 * @property-read \Illuminate\Database\Eloquent\Collection|\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\Organization whereId($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereName($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereSlug($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereSiteUrl($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereEmail($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereDescription($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereCreatedAt($value) 
 * @method static \Illuminate\Database\Query\Builder|\Organization whereUpdatedAt($value) 
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
