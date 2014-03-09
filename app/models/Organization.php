<?php

use LaravelBook\Ardent\Ardent;

/**
 * An Eloquent Model: 'Organization'
 *
 */
class Organization extends Ardent {

	public static $rules = array(
		'name' => 'required',
		'slug' => 'required|unique:organizations',
		'site_url' => 'url',
        'email' => 'email',
		'description' => '',
	);

    public static function fetchByCreator(User $user) {

        return array();
    }

}
