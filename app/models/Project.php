<?php

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    public function userIsManager() {


        return false;
    }

}
