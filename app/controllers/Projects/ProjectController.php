<?php
namespace Projects;

use dflydev\markdown\MarkdownParser;
use Input;
use Project;
use ProjectManager;
use Social;
use Redirect;
use Response;
use Sentry;
use Str;
use Validator;
use View;

class ProjectController extends BaseController {

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
        $githubRepos = array();

        $user = Sentry::getUser();

        $githubUser = Social::whereRaw('provider = ? and user_id = ?', array('github', $user->id))->first();
        if($githubUser) {
            $client = new \Github\Client(
                new \Github\HttpClient\CachedHttpClient(array('cache_dir' => storage_path('github')))
            );

            $repos = $client->api('user')->repositories($user->username);
            foreach($repos as $repo) {
                if($repo['fork']) continue;

                $githubRepos[] = array(
                    'name' => $repo['name'],
                    'full_name' => $repo['full_name'],
                    'html_url' => $repo['html_url'],
                    'description' => $repo['description']
                );
            }
        }

        return View::make('projects/create', compact('githubRepos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $input = Input::all();
        $input['slug'] = Str::slug($input['name']);

        $rules = array(
            'name' => 'required',
            'slug' => 'required|unique:projects',
            'url' => 'required|url',
            'description' => 'required',
        );
        $validator = Validator::make($input, $rules, array(
            'slug.unique' => 'Your project name must not evaluate to a taken slug.'
        ));
        if($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $project = new Project();

        $project->name = $input['name'];
        $project->slug = $input['slug'];
        $project->description = $input['description'];
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
