<?php
namespace Models;

use Project;
use TestCase;

class ProjectTest extends TestCase {

    public function testIsInvalidWithoutAName() {
        $project = new Project;

        $this->assertFalse($project->validate());
    }

    public function testIsInvalidWithoutAValidURL() {
        $project = new Project;
        $project->name = "Project Name";
        $project->site_url = "?";

        $this->assertFalse($project->validate());
    }

}
