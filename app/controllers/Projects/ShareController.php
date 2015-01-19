<?php
namespace Projects;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Project;
use Redirect;
use Response;

class ShareController extends BaseController {

    public function getTwitter($participantSlug, $projectSlug) {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        $message = urlencode("Subscribe to $project->name on PatchNotes: {$project->href}");

        $url = "https://twitter.com/intent/tweet?text=$message";

        return Redirect::to($url);
    }

    public function getFacebook($participantSlug, $projectSlug) {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        $message = urlencode("Subscribe to $project->name on PatchNotes");

        $redirect = "http://www.facebook.com/sharer/sharer.php?s=100&p[url]={$project->href}&p[images][0]=&p[title]=$message&p[summary]=";

        return Redirect::to($redirect);
    }

    public function getGoogle($participantSlug, $projectSlug) {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch(ModelNotFoundException $e) {
            return Response::json(['success' => false, 'error' => $e->getMessage()]);
        }

        return Redirect::to("https://plus.google.com/share?url={$project->href}");
    }

}
