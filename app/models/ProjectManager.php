<?php
use Illuminate\Database\Eloquent\Model;

class ProjectManager extends Model {

    protected $table = 'project_managers';

    public function project() {
        return $this->belongsTo('Project');
    }

    public function user() {
        return $this->belongsTo('User');
    }

} 
