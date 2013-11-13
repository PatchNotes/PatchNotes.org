<?php

class ProjectUpdate extends Eloquent {

    protected $table = "project_updates";

    public function project() {
        return $this->belongsTo('Project');
    }

    public function author() {
        return $this->belongsTo('User');
    }

} 
