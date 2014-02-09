<?php

class HomeController extends BaseController {

	public function getIndex() {
		$newProjects = Project::orderBy('created_at', 'desc')->limit(4)->get();

		return View::make('home', array(
			'newProjects' => $newProjects
		));
	}

} 
