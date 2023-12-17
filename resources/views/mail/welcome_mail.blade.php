<!DOCTYPE html>

<html>

<head>

    <title>{{ $mailData['title'] }}</title>

</head>

<body>

    <h1>{{ $mailData['title'] }}</h1>

    <p>Dear Alumni {{ $mailData['name'] }},</p>
    <p>Welcome to CSE Alumni Association Premier University. Here is the login url and credentials for your account</p>

    <a href="{{ $mailData['url'] }}">{{ $mailData['url'] }}</a>

    <p>Student ID: {{ $mailData['student_id'] }}</p>
    <p>Password: {{ $mailData['password'] }}</p>



    <p>Thank you</p>

</body>

</html>
