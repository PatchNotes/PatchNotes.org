<?php
namespace Projects;

//use dflydev\markdown\MarkdownParser;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Input;
use Project;
use Redirect;
use Response;
use Sentry;
use Social;
use Str;
use Validator;
use View;
use User;
use Organization;
use App;

class ProjectController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $projects = Project::paginate(16);

        return View::make('projects/index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $githubRepos = array();

        $user = Sentry::getUser();

        $possibleOwners = array(
            'Users' => array(
                'user:' . $user->id => $user->username
            )
        );
        foreach ($user->organizations as $org) {
            if (!isset($possibleOwners['Organizations'])) $possibleOwners['Organizations'] = array();
            $possibleOwners['Organizations']['organization:' . $org->id] = $org->name;
        }

        $githubUser = $user->oauthAccounts()->where('provider', 'GitHub')->first();
        if ($githubUser) {
            $client = new \Github\Client(
                new \Github\HttpClient\CachedHttpClient(array('cache_dir' => storage_path('GitHub')))
            );

            $repos = $client->api('user')->repositories($githubUser->provider_user_details->username);
            foreach ($repos as $repo) {
                if ($repo['fork']) continue;

                $githubRepos[] = array(
                    'name' => $repo['name'],
                    'full_name' => $repo['full_name'],
                    'html_url' => $repo['html_url'],
                    'description' => $repo['description']
                );
            }
        }

        return View::make('projects/create', compact('githubRepos', 'possibleOwners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        $validator = Validator::make(array(
            'owner' => Input::get('owner')
        ), array(
            'owner' => array('regex:/(user|organization)\:\d+/')
        ));
        if ($validator->fails()) {
            App::abort(400, "Don't do that.");
        }

        $inpOwner = explode(':', Input::get('owner'));

        if ($inpOwner[0] === 'user') {
            $owner = User::find($inpOwner[1]);
        } else {
            $owner = Organization::find($inpOwner[1]);
        }
        if (!$owner) {
            return Redirect::back()->withErrors(array('User/Organization not found.'));
        }

        $project = new Project();

        $project->name = Input::get('name');
        $project->slug = Str::slug(Input::get('name'));
        $project->description = Input::get('description');
        $project->site_url = Input::get('url');

        if ($owner->projects()->save($project)) {
            return Redirect::action('Projects\\ProjectController@show', array($owner->slug, $project->slug));
        } else {
            return Redirect::back()->withErrors($project->errors());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        //$parser = new MarkdownParser();

        return View::make('projects/show', compact('project', 'owner'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        if (!Sentry::getUser()->isMember($project) || !Sentry::getUser()->isSuperUser()) {
            App::abort(401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function update($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        if (!Sentry::getUser()->isMember($project) || !Sentry::getUser()->isSuperUser()) {
            App::abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }


        if (!Sentry::getUser()->isMember($project) || !Sentry::getUser()->isSuperUser()) {
            App::abort(401);
        }
    }
}
