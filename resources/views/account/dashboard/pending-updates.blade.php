@extends("layouts/master")

@section('title', "Pending Updates")

@section("content")

    <div class="row">
        <div class="col-md-3">
            @include("account/dashboard/partials/nav")
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Your Pending Updates</h2>
                </div>
            </div>

            <table class="table table-condensed">
                <thead>
                <tr>
                    <th>Project</th>
                    <th>Update</th>
                    <th>Digest</th>
                </tr>
                </thead>
                <tbody>
                @foreach($projectsUpdated as $projectId => $userUpdates)
                    @foreach($userUpdates as $userUpdate)
                    <tr>
                        <td>{{ $userUpdate->project_update->project->name }}</td>
                        <td>{{ $userUpdate->project_update->title }}</td>
                        <td>{{ $userUpdate->notification_level->key }}</td>
                    </tr>
                    @endforeach
                @endforeach
                </tbody>

            </table>

            <h4>Email Preview</h4>
            <pre>
@include('emails/text/updates/grouped', ['user' => $user, 'projectsUpdated' => $projectsUpdated])
            </pre>

        </div>
    </div>


@stop