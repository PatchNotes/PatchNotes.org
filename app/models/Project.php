<?php

use Illuminate\Database\Eloquent\Model;

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
