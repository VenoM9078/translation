<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Verification</title>
</head>
<body>
    {{$contractor['name']}}
    <h1>Email Verification</h1>
    <p>Please click the button below to verify your email address:</p>
    <a href="{{ url('contractor/verify', $contractor->verifyContractor->token)}}" style="display: inline-block; padding: 10px 20px; background-color: #3490dc; color: #ffffff; text-decoration: none;">Verify Email Address</a>
    <p>If you did not create an account, you can ignore this email.</p>
</body>
</html>