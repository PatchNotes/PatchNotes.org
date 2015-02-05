Hey there {{{ $user->fullname }}},

Here's your digest of updates!

@foreach($projectsUpdated as $projectId => $userUpdates)
{{{ Project::where('id', $projectId)->first()->name }}}
@foreach($userUpdates as $userUpdate)
 * {{{ $userUpdate->project_update->title }}} [{{ $userUpdate->project_update->href }}]
@endforeach

@endforeach

See something you don't like? Curate your subscriptions at {{ URL::action('Account\\DashboardController@getSubscriptions') }}

Thanks,
{{ Config::get('patchnotes.emails.updates.from.name') }}

Unsubscribe from all emails from PatchNotes at {{ URL::action('HomeController@getUnsubscribe') }}?email={{ $user->email }}&token={{ $user->unsubscribe_token }}