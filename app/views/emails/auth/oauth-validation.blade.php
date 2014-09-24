<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Validate Your PatchNotes oAuth Connection!</h2>

<div>
    <p>To confirm your oAuth connection on PatchNotes please click here:</p>

    <p><a href="{{ URL::to('/auth/validate-account/' . $oauth->validation_key) }}">PatchNotes oAuth Validation</a></p>

    <p>Thanks,<br>
        <i>The Robots @ PatchNotes</i><br></p>
    <hr>
</div>
</body>
</html>
