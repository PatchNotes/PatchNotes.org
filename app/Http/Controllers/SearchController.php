<?php namespace PatchNotes\Http\Controllers;

use Illuminate\Http\Request;
use PatchNotes\Models\Project;
use PatchNotes\Models\User;

class SearchController extends Controller {

    public function getSearch(Request $request) {
        $this->validate($request, ['query' => 'required|alpha_num']);

        $projects = Project::where('name', 'LIKE', '%' . $request->get('query') . '%')->get();
        $users = User::where('username', 'LIKE', '%' . $request->get('query') . '%')->get();

        return view('search', compact('projects', 'users'));
    }

} 
