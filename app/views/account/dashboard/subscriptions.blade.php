@extends("layouts/master")

@section("content")

    <div class="row">
        <div class="col-md-3">
            @include("account/dashboard/partials/nav")
        </div>
        <div class="col-md-9">

            <div class="row">
                <div class="col-lg-6">
                    <h2>Your Subscriptions</h2>
                </div>
            </div>

            {{ Form::open(['method' => 'POST', 'action' => 'Account\\DashboardController@postSubscriptions']) }}
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
                @foreach($projectSubscriptions as $psub)
                    @foreach($psub as $subscription)
                        <tr>
                            <td><a href="{{ $subscription->project->href }}">{{ $subscription->project->name }}</a></td>
                            <td>
                                {{ $subscription->project_update_level->name }}
                            </td>
                            <td>
                                {{ Form::select(
                                    "subscriptions[{$subscription->id}][project_update_level_id][{$subscription->project_update_level->id}]",
                                    NotificationLevel::selectBox(),
                                    $subscription->notification_level->id,
                                    ['class' => 'form-control']
                                ) }}

                            </td>
                            <td>{{ $subscription->created_at }}</td>
                        </tr>
                    @endforeach
                @endforeach
                </tbody>
            </table>

            <div class="pull-right">
                <input type="submit" class="btn btn-primary" value="Update Subscriptions"/>
            </div>

            {{ Form::close() }}
        </div>
    </div>




@stop