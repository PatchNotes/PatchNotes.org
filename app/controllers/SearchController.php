<?php

class SearchController extends BaseController {

    public function getSearch() {
        $rules = array('query' => 'required|alpha_num');
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return View::make('search', array('errors' => $validator->errors()));
        }

        $projects = Project::where('name', 'LIKE', '%' . Input::get('query') . '%')->get();
        $users = User::where('username', 'LIKE', '%' . Input::get('query') . '%')->get();

        return View::make('search', compact('projects', 'users'));
    }

} 
