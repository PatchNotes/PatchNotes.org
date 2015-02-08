@extends('layouts/email')

@section('content')

    <table class="row">

        <tr>
            <td class="wrapper last">

                <table class="twelve columns">
                    <tr>
                        <td class="center">
                            <h1 class="center">
                                PatchNotes
                            </h1>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="lead">Hi {{ $user->username }}, this is your {{ $nLevel->name }}. You have {{ $numUpdates }} updates from {{ $numProjects }} projects that you follow.</p>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

    @foreach($projectsUpdated as $projectId => $pUpdates)
        <h4>{{ PatchNotes\Models\Project::whereId($projectId)->firstOrFail()->name }}
            <small>by <a href="{{ PatchNotes\Models\Project::whereId($projectId)->firstOrFail()->owner->href }}">
                    {{ PatchNotes\Models\Project::whereId($projectId)->firstOrFail()->owner->name }}</a>
            </small>
        </h4>

        @foreach($pUpdates as $pu)
            <p>
                <a href="{{ $pu->projectUpdate->href }}">{{ $pu->projectUpdate->title }}</a><br/>
                {{ str_limit($pu->projectUpdate->body, 80, '...') }}
            </p>
        @endforeach

        <br/>
    @endforeach

    <table class="row callout">
        <tr>
            <td class="wrapper last">

                <table class="twelve columns">
                    <tr>
                        <td class="panel">
                            <p>Don't like what you see? <a href="{{ URL::action('Account\\DashboardController@getSubscriptions') }}">Manage your subscriptions »</a></p>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
@stop