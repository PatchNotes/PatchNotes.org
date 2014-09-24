<?php
namespace Projects;

use Project;
use Redirect;

class ShareController extends BaseController {

    public function getTwitter($participant, $projectSlug) {
        $project = Project::where('slug', $projectSlug)->first();

        $message = urlencode("Subscribe to $project->name on PatchNotes: {$project->href}");

        $url = "https://twitter.com/intent/tweet?text=$message";

        return Redirect::to($url);
    }

    public function getFacebook($participant, $projectSlug) {
        $project = Project::where('slug', $projectSlug)->first();

        $message = urlencode("Subscribe to $project->name on PatchNotes");

        $redirect = "http://www.facebook.com/sharer/sharer.php?s=100&p[url]={$project->href}&p[images][0]=&p[title]=$message&p[summary]=";

        return Redirect::to($redirect);
    }

    public function getGoogle($participant, $projectSlug) {
        $project = Project::where('slug', $projectSlug)->first();

        return Redirect::to("https://plus.google.com/share?url={$project->href}");
    }

}
