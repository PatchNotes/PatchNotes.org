@extends("layouts/master")

@section("content")

    <div class="row">
        <div class="col-md-3">
            @include("account/dashboard/partials/nav")
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-lg-6">
                    <h2>Your Preferences</h2>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <h4>Notification Settings</h4>

                    @if ($errors->has())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    {{ Form::open(['method' => 'POST', 'action' => 'Account\\DashboardController@postPreferences', 'class' => 'form-horizontal']) }}
                    <div class="form-group">
                        <label for="inputTimezone" class="col-sm-4 control-label">Timezone</label>

                        <div class="col-sm-8">
                            {{ Form::select('timezone', UserPreference::timezoneSelectBox(), (isset($preference->timezone) ? $preference->timezone : "UTC"), [
                                'class' => 'form-control',
                                'id' => 'inputTimezone'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputDailyTime" class="col-sm-4 control-label">Daily Update Time</label>

                        <div class="col-sm-8">
                            {{ Form::select('daily_time', UserPreference::timeSelectBox(), $preference->daily_time, [
                                'class' => 'form-control',
                                'id' => 'inputDailyTime'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputWeeklyDay" class="col-sm-4 control-label">Weekly Update Day</label>

                        <div class="col-sm-8">
                            {{ Form::select('weekly_day', UserPreference::daySelectBox(), $preference->weekly_day, [
                                'class' => 'form-control',
                                'id' => 'inputWeeklyDay'
                            ]) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputWeeklyTime" class="col-sm-4 control-label">Weekly Update Time</label>

                        <div class="col-sm-8">
                            {{ Form::select('weekly_time', UserPreference::timeSelectBox(), $preference->weekly_time, [
                                'class' => 'form-control',
                                'id' => 'inputWeeklyTime'
                            ]) }}
                        </div>
                    </div>


                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>

        </div>
    </div>


@stop