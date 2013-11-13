<?php
namespace Projects;

use dflydev\markdown\MarkdownParser;
use Input;
use Project;
use ProjectManager;
use Redirect;
use Sentry;
use Validator;
use View;

class UpdateController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $projects = Project::all();

        return View::make('projects/index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View::make('projects/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $input = Input::all();

        $rules = array(
            'title' => 'required|alpha_num',
            'url' => 'required|url',
            'description' => 'required',
            'body'
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $project = Project::find($projectID);
        $update = new $project->update();

        $update->title = $input['title'];
        $update->description = $input['description'];

        $update->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($slug) {
        $project = Project::where('slug', $slug)->first();

        $parser = new MarkdownParser();

        return View::make('projects/show', compact('project', 'parser'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id) {
        //
    }
}
