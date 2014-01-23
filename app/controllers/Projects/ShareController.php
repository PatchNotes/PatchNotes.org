<?php
namespace Projects;

use Project;
use Redirect;

class ShareController extends BaseController {

	public function getTwitter($projectSlug) {
		$project = Project::where('slug', $projectSlug)->first();

		$url = action('Projects\\ProjectController@show', array($project->slug));
		$message = urlencode("Subscribe to $project->name on PatchNotes: $url");

		$url = "https://twitter.com/intent/tweet?text=$message";

		return Redirect::to($url);
	}

	public function getFacebook($projectSlug) {
		$project = Project::where('slug', $projectSlug)->first();

		$url = action('Projects\\ProjectController@show', array($project->slug));
		$message = urlencode("Subscribe to $project->name on PatchNotes");

		$redirect = "http://www.facebook.com/sharer/sharer.php?s=100&p[url]=$url&p[images][0]=&p[title]=$message&p[summary]=";

		return Redirect::to($redirect);
	}

	public function getGoogle($projectSlug) {
		$project = Project::where('slug', $projectSlug)->first();

		$url = urlencode(action('Projects\\ProjectController@show', array($project->slug)));

		return Redirect::to("https://plus.google.com/share?url=$url");
	}

}
