<!DOCTYPE html>
<html>
<head>
    <title>Welcome to Our Platform</title>
</head>
<body>
    <h1>Welcome {{ $userName }}!</h1>
    
    <p>Your account has been successfully created with the following details:</p>
    
    <ul>
        <li><strong>Name:</strong> {{ $userName }}</li>
        <li><strong>Email:</strong> {{ $userEmail }}</li>
    </ul>
    
    <p>Thank you for joining our platform!</p>
    
    <p>Best regards,<br>The Team</p>
</body>
</html>
