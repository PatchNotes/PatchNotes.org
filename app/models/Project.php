<?php

use Illuminate\Database\Eloquent\Model;

/**
 * An Eloquent Model: 'Project'
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $content
 * @property string $site_url
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\ProjectUpdate[] $updates
 * @property-read \Illuminate\Database\Eloquent\Collection|\ProjectManager[] $managers
 */
class Project extends Model {

    public function updates() {
        return $this->hasMany('ProjectUpdate');
    }

    public function managers() {
        return $this->hasMany('ProjectManager');
    }

    public function isManager(User $user) {
        $managers = $this->managers;
        foreach($managers as $manager) {
            if($manager->user_id == $user->id) return true;
        }

        return false;
    }

}
