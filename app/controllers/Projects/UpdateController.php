<?php
namespace Projects;

use App;
use dflydev\markdown\MarkdownParser;
use Event;
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
	public function indexRSS($participant, $projectSlug)
	{
		$owner = Project::resolveParticipant($participant);
		if (!$owner) {
			return Response::json(array('success' => false, 'error' => 'Participant not found.'));
		}

		$project = $owner->projects()->where('slug', $projectSlug)->first();
		if (!$project) {
			return Response::json(array('success' => false, 'error' => 'Project not found.'));
		}

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
	public function store($participant, $project)
	{
		$owner = Project::resolveParticipant($participant);
		if (!$owner) {
			return Response::json(array('success' => false, 'error' => 'Participant not found.'));
		}

		$project = $owner->projects()->where('slug', $project)->first();
		if (!$project) {
			return Response::json(array('success' => false, 'error' => 'Project not found.'));
		}
		if (Sentry::getUser()->isMember($project) === false) {
			App::abort(401);
		}

		$input = Input::all();

		$rules = array(
			'title' => 'required|max:200',
			'description' => 'required|max:1000',
			'rank' => 'exists:project_updates_levels,level'
		);
		$validator = Validator::make($input, $rules);
		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator);
		}

		$update = new ProjectUpdate();

		$update->title = $input['title'];
		$update->body = $input['description'];
		$update->slug = Str::slug($input['title']);
		$update->level = $input['rank'];
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
	public function show($participant, $project, $update)
	{
		$project = Project::where('slug', $project)->first();
		$update = $project->updates()->where('slug', $update)->first();

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
	public function edit($participant, $project, $update)
	{
		$owner = Project::resolveParticipant($participant);
		if (!$owner) {
			return Response::json(array('success' => false, 'error' => 'Participant not found.'));
		}

		$project = $owner->projects()->where('slug', $project)->first();
		if (!$project) {
			return Response::json(array('success' => false, 'error' => 'Project not found.'));
		}
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
	public function update($participant, $project, $update)
	{
		$owner = Project::resolveParticipant($participant);
		if (!$owner) {
			return Response::json(array('success' => false, 'error' => 'Participant not found.'));
		}

		$project = $owner->projects()->where('slug', $project)->first();
		if (!$project) {
			return Response::json(array('success' => false, 'error' => 'Project not found.'));
		}
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
	public function destroy($participant, $project, $update)
	{
		$owner = Project::resolveParticipant($participant);
		if (!$owner) {
			return Response::json(array('success' => false, 'error' => 'Participant not found.'));
		}

		$project = $owner->projects()->where('slug', $project)->first();
		if (!$project) {
			return Response::json(array('success' => false, 'error' => 'Project not found.'));
		}
		if (Sentry::getUser()->isMember($project) === false) {
			App::abort(401);
		}
	}
}
