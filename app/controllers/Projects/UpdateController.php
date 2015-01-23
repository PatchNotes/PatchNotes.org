<?php
namespace Projects;

use App;
use Event;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Input;
use Project;
use ProjectUpdate;
use Redirect;
use Response;
use Rss;
use Sentry;
use Str;
use Validator;
use View;

class UpdateController extends BaseController
{

    public function __construct()
    {
        $this->beforeFilter('auth', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Return a list of the projects updates in the RSS format.
     *
     * @param $participant
     * @param $projectSlug
     * @return \Illuminate\Http\Response
     */
    public function indexRSS($participantSlug, $projectSlug)
    {
        list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);

        $feed = Rss::feed('2.0', 'UTF-8');
        $feed->channel(array(
            'title' => $project->name,
            'description' => $project->description,
            'link' => $project->href
        ));

        foreach ($project->updates()->get() as $update) {
            $feed->item(array(
                'title' => $update->title,
                'description' => $update->body,
                'link' => action('Projects\\UpdateController@show', array($owner->slug, $project->slug, $update->slug))
            ));
        }

        return Response::make($feed, 200, array('Content-Type' => 'text/xml'));
    }


    /**
     * Create a project update
     *
     * @param $slug
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        if (Sentry::getUser()->isMember($project) === false) {
            return Response::json(['success' => false, 'error' => 'User is not member of organization.']);
        }

        $input = Input::all();

        $rules = array(
            'title' => 'required|max:200',
            'description' => 'required|max:1000',
            'level' => 'exists:project_updates_levels,level'
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }

        $projectUpdateLevel = \ProjectUpdateLevel::whereLevel($input['level'])->firstOrFail();

        $update = new ProjectUpdate();

        $update->title = $input['title'];
        $update->body = $input['description'];
        $update->slug = Str::slug($input['title']);
        $update->project_update_level_id = $projectUpdateLevel->id;
        $update->user_id = Sentry::getUser()->id;

        $update = $project->updates()->save($update);

        Event::fire('project.update.create', array($project, $update));

        return Redirect::back();
    }

    /**
     * Display the specified resource.
     *
     * @param $participant
     * @param $project
     * @param $update
     * @internal param $projectSlug
     * @internal param $updateSlug
     * @internal param int $id
     *
     * @return Response
     */
    public function show($participantSlug, $projectSlug, $update)
    {
        list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);

        $update = $project->updates()->where('slug', $update)->first();


        return View::make('projects/updates/show', array(
            'project' => $project,
            'update' => $update,
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
    public function edit($participantSlug, $projectSlug, $update)
    {
        list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);

        if (Sentry::getUser()->isMember($project) === false) {
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
    public function update($participantSlug, $projectSlug, $update)
    {
        list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);

        if (Sentry::getUser()->isMember($project) === false) {
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
    public function destroy($participantSlug, $projectSlug, $update)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }


        if (Sentry::getUser()->isMember($project) === false) {
            App::abort(401);
        }
    }
}
