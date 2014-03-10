<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'Organization'
 *
 */
class Organization extends Ardent implements Models\Interfaces\Participant {

	public static $rules = array(
		'name' => 'required',
		'slug' => 'required|unique:organizations',
		'site_url' => 'url',
        'email' => 'email',
		'description' => '',
	);

    public function projects() {
        return $this->morphMany('Project', 'owner');
    }

    public function getNameAttribute() {
        return $this->name;
    }

    public function getSlugAttribute() {
        return $this->slug;
    }

    public static function fetchByCreator(User $user) {

        return array();
    }

    /**
     * Verify we're unique in both users and organizations
     *
     * @return bool
     */
    public function beforeSave() {
        $user = User::where('slug', $this->slug)->first();

        if($user) {
            return false;
        }
    }

}
