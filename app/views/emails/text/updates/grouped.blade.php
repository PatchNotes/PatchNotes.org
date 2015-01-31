Hey there {{{ $user->fullname }}},

Below are your updates:
@foreach($projectsUpdated as $projectId => $userUpdates)
<?php $project = Project::find($projectId)->firstOrFail(); ?>

{{{ $project->name }}}
@foreach($userUpdates as $userUpdate)
 * {{{ $userUpdate->project_update->title }}} [{{ $userUpdate->project_update->href }}]
@endforeach
Unsubscribe from emails about {{ $project->name }}: {{ $project->unsubscribe_href }}
@endforeach

Thanks,
{{ Config::get('patchnotes.emails.updates.from.name') }}