<?php namespace PatchNotes\Http\Controllers\Projects;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use PatchNotes\Http\Controllers\Controller;
use PatchNotes\Models\Organization;
use PatchNotes\Models\User;
use PatchNotes\Services\ResolveParticipant;
use PatchNotes\Models\Project;
use Sentry;

class ProjectController extends Controller
{
    use ResolveParticipant;

    public function __construct()
    {
        $this->middleware('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $projects = Project::paginate(12);

        return view('projects/index', compact('projects'));
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

        return view('projects/create', compact('githubRepos', 'possibleOwners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'owner' => ['regex:/(user|organization)\:\d+/'],
            'name' => 'required',
            'site_url' => 'required|url',
            'description' => 'required'
        ]);

        $inpOwner = explode(':', $request->get('owner'));

        if ($inpOwner[0] === 'user') {
            $owner = User::find($inpOwner[1]);
        } else {
            $owner = Organization::find($inpOwner[1]);
        }
        if (!$owner) {
            return redirect()->back()->withErrors(array('User/Organization not found.'));
        }

        $project = new Project();

        $project->name = $request->get('name');
        $project->slug = str_slug($request->get('name'));
        $project->description = $request->get('description');
        $project->site_url = $request->get('url');

        if ($owner->projects()->save($project)) {
            return redirect(action('Projects\\ProjectController@show', array($owner->slug, $project->slug)));
        } else {
            return redirect()->back()->withErrors($project->errors());
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
        } catch (ModelNotFoundException $e) {
            return abort(404);
        }

        //$parser = new MarkdownParser();

        return view('projects/show', compact('project', 'owner'));
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
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        if (!Sentry::getUser()->isMember($project) || !Sentry::getUser()->isSuperUser()) {
            return abort(401);
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
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        if (!Sentry::getUser()->isMember($project) || !Sentry::getUser()->isSuperUser()) {
            return abort(401);
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
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }


        if (!Sentry::getUser()->isMember($project) || !Sentry::getUser()->isSuperUser()) {
            return abort(401);
        }
    }
}
