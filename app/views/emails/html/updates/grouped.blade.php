<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<div>
    <p>Hey there {{{ $user->fullname }}},</p>

    <p>Here's your digest of updates!</p>

    @foreach($projectsUpdated as $projectId => $userUpdates)
        <h4>{{{ Project::where('id', $projectId)->first()->name }}}</h4>
        <ul>
            @foreach($userUpdates as $userUpdate)
                <li><a href="{{ $userUpdate->project_update->href }}">{{{ $userUpdate->project_update->title }}}</a></li>
            @endforeach
        </ul>
    @endforeach

    <p>See something you don't like? Curate your subscriptions on <a href="{{ URL::action('Account\\DashboardController@getSubscriptions') }}">Your Dashboard</a></p>

    <p>Thanks,</p>
    <p>{{ Config::get('patchnotes.emails.updates.from.name') }}</p>

    <p><a href="{{ URL::action('HomeController@getUnsubscribe') }}?email={{ $user->email }}&token={{ $user->unsubscribe_token }}">Unsubscribe from all emails from PatchNotes.</a></p>
</div>
</body>
</html>
