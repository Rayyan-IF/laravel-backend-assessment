<!DOCTYPE html>
<html>
<head>
    <title>New User Registration</title>
</head>
<body>
    <h1>New User Registration</h1>
    
    <p>A new user has registered on the platform:</p>
    
    <ul>
        <li><strong>Name:</strong> {{ $userName }}</li>
        <li><strong>Email:</strong> {{ $userEmail }}</li>
        <li><strong>Role:</strong> {{ $userRole }}</li>
        <li><strong>Registration Date:</strong> {{ $registrationDate }}</li>
    </ul>
    
    <p>Please review the new user account if necessary.</p>
    
    <p>Best regards,<br>System</p>
</body>
</html>
