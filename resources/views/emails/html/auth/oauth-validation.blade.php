@extends('layouts/email')

@section('content')
    <table class="row">

        <tr>
            <td class="wrapper last">

                <table class="twelve columns">
                    <tr>
                        <td>
                            <p>To confirm your oAuth connection on PatchNotes please click here:</p>

                            <p><a href="{{ URL::to('/auth/validate-account/' . $oauth->validation_key) }}">PatchNotes oAuth Validation</a></p>
                        </td>
                        <td class="expander"></td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>

@stop

