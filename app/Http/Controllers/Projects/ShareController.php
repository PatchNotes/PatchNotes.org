<?php namespace PatchNotes\Http\Controllers\Projects;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use PatchNotes\Http\Controllers\Controller;
use PatchNotes\Services\ResolveParticipant;


class ShareController extends Controller
{
    use ResolveParticipant;

    public function getTwitter($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        $message = urlencode("Subscribe to $project->name on PatchNotes: {$project->href}");

        $url = "https://twitter.com/intent/tweet?text=$message";

        return redirect($url);
    }

    public function getFacebook($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        $message = urlencode("Subscribe to $project->name on PatchNotes");

        $redirect = "http://www.facebook.com/sharer/sharer.php?s=100&p[url]={$project->href}&p[images][0]=&p[title]=$message&p[summary]=";

        return redirect($redirect);
    }

    public function getGoogle($participantSlug, $projectSlug)
    {
        try {
            list($owner, $project) = $this->resolveParticipantProject($participantSlug, $projectSlug);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()]);
        }

        return redirect("https://plus.google.com/share?url={$project->href}");
    }

}
