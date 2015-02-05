<?php namespace PatchNotes\Services;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use PatchNotes\Models\Project;

trait ResolveParticipant {

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