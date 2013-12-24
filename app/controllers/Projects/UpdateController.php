<?php
namespace Projects;

use App;
use dflydev\markdown\MarkdownParser;
use Event;
use Input;
use Project;
use ProjectManager;
use ProjectUpdate;
use Redirect;
use Response;
use Sentry;
use Str;
use Validator;
use View;

class UpdateController extends BaseController {

    public function __construct() {
        $this->beforeFilter('auth', ['only' => ['create', 'store', 'edit', 'update','destroy']]);
    }

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
    public function store($slug) {
        $project = Project::where('slug', $slug)->firstOrFail();
        if(!$project->isManager(Sentry::getUser())) {
            App::abort(401);
        }

        $input = Input::all();

        $rules = array(
            'title' => 'required|max:200',
            'description' => 'required|max:1000',
            'rank' => 'exists:subscription_levels,level'
        );
        $validator = Validator::make($input, $rules);
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $update = new ProjectUpdate();

        $update->title = $input['title'];
        $update->body = $input['description'];
        $update->slug = Str::slug($input['title']);
        $update->subscription_level = $input['rank'];
        $update->user_id = Sentry::getUser()->id;

        $update = $project->updates()->save($update);

        Event::fire('project.update', array($update));

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param $projectSlug
     * @param $updateSlug
     * @internal param int $id
     *
     * @return Response
     */
    public function show($projectSlug, $updateSlug) {
        $project = Project::where('slug', $projectSlug)->first();
        $update = $project->updates()->where('slug', $updateSlug)->first();

        $parser = new MarkdownParser();

        return View::make('projects/updates/show', array(
            'project' => $project,
            'update' => $update,
            'parser' => $parser,
            'bodyclass' => 'small-container'
        ));
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
