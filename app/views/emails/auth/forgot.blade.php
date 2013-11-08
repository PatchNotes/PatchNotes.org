<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <div>
            <p>Hey there, it seems you or someone else thought you forgot your password for
                <a href="{{URL::to('/')}}">PatchNotes</a>. If this is a mistake, just ignore this email.</p>

            <p>Anyways, so here's how you can reset your password: </p>

            <ol>
                <li><a href="{{ URL::to('account/reset', array($user->email, $forgotCode)) }}">Visit this page</a></li>
                <li>Pick a new password</li>
                <li>Login using the new password!</li>
            </ol>

            <p>We hope that's pretty simple, if not, let us know!</p>

            <p>Thanks,<br>
                <i>The Robots @ PatchNotes</i><br></p>
        </div>
    </body>
</html>
