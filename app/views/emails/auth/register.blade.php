<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Welcome to PatchNotes!</h2>

        <div>
            <p>In case you forgot, <a href="{{URL::to('/')}}">PatchNotes</a> INSERT SOME DESCRIPTION OF THE WEBSITE HERE.</p>

            <p>Anyways, here's the stuff you need to know to login: </p>

            <ol>
                <li><a href="{{ URL::to('account/validate', array($user->email, $activationCode)) }}">Validate Your Email</a>[1]</li>
            </ol>

            <p>We hope that's pretty simple, if not, let us know!</p>

            <p>Thanks,<br>
                <i>The Robots @ PatchNotes</i><br></p>
            <hr>

            <ol>
                <li>{{ URL::to('account/validate', array($user->email, $activationCode)) }}</li>
            </ol>
        </div>
    </body>
</html>
