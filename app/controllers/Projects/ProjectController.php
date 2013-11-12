<?php
namespace Projects;

use dflydev\markdown\MarkdownParser;
use Input;
use Project;
use ProjectManager;
use Redirect;
use Response;
use Sentry;
use Str;
use Validator;
use View;

class ProjectController extends BaseController {

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
            'name' => 'required|alpha_num',
            'url' => 'required|url',
            'description' => 'required',
            'body'
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $project = new Project();

        $project->name = $input['name'];
        $project->slug = Str::slug($input['name']);
        $project->description = $input['description'];
        $project->content = $input['body'];
        $project->site_url = $input['url'];

        $project->save();
        if(!$project) {
            return Redirect::back()->withErrors(array('Name already exists.'));
        }

        $manager = new ProjectManager();
        $manager->user_id = Sentry::getUser()->id;
        $manager->project_id = $project->id;
        $manager->save();

        return Redirect::action('Projects\\ProjectController@show', array($project->slug));
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
