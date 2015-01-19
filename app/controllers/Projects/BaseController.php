<?php
namespace Projects;

use Project;
use App;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BaseController extends \Controller {

    public function resolveParticipantProject($participantSlug, $projectSlug) {
        $owner = Project::resolveParticipant($participantSlug);
        if (!$owner) {
            throw new ModelNotFoundException('Participant not found.');
        }

        $project = $owner->projects()->where('slug', $projectSlug)->first();
        if (!$project) {
            throw new ModelNotFoundException('Project not found.');
        }

        return [$owner, $project];
    }

} 
