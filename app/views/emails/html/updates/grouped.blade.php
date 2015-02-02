@extends('layouts/email')

@section('content')

    <table class="row">

        <tr>
            <td class="wrapper last">

                <table class="twelve columns">
                    <tr>
                        <td>
                            <h1>Hi, {{{ $user->username }}}</h1>
                            <p class="lead">This is your {{ $nLevel->name }}. You have {{ $numUpdates }} updates from {{ $numProjects }} projects that you follow.</p>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

    @foreach($projectsUpdated as $projectId => $pUpdates)
        <h4>{{{ Project::whereId($projectId)->firstOrFail()->name }}} <small>by <a href="{{ Project::whereId($projectId)->firstOrFail()->owner->href }}">{{{ Project::whereId($projectId)->firstOrFail()->owner->name }}}</a></small></h4>

        @foreach($pUpdates as $pu)
            <p>
                <a href="{{ $pu->project_update->href }}">{{{ $pu->project_update->title }}}</a><br/>
                {{{ str_limit($pu->project_update->body, 80, '...') }}}
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