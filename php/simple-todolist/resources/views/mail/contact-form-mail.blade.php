<!DOCTYPE html>
<html>
<head>
    <title>New Contact Form Submission</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>                        <br>

    <p><strong>Name: </strong> {{ $data['name'] }}</p>          <br>
    <p><strong>Email: </strong> {{ $data['email'] }}</p>        <br>
    <p><strong>Message: </strong></p>                           <br>
    <p>{{ $data['message'] }}</p>                               <br>

    <p>Received at: {{ now()->format('Y-m-d H:i:s') }}</p>
</body>
</html>
