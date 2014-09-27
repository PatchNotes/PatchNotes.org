@extends("layouts/master")

@section("content")

<div class="row">
    <div class="col-lg-6">
        <h2>Your Subscriptions</h2>
        <p>Some text if required.</p>
    </div>
</div>

<table class="table">
    <thead>
        <tr>
            <th>Project</th>
            <th>Project Update Level</th>
            <th>Notification Level</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subscriptions as $subscription)
        <tr>
            <td>{{ $subscription->project->name }}</td>
            <td>{{ $subscription->project_update_level->name }}</td>
            <td>{{ $subscription->notification_level->name }}</td>
            <td>{{ $subscription->created_at }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center">
{{ $subscriptions->links(); }}
</div>

@stop