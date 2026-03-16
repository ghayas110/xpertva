<!DOCTYPE html>
<html>
<head>
    <title>Notice of Termination</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    
    <div style="text-align: center; margin-bottom: 30px;">
        <h2 style="color: #d9534f;">Notice of Termination</h2>
    </div>

    <p>Dear {{ $user->name }},</p>

    <p>We are writing to inform you that your employment with XpertVA is being terminated, effective immediately.</p>

    <p><strong>Reason for termination:</strong></p>
    <div style="background-color: #f9f9f9; border-left: 4px solid #d9534f; padding: 10px 15px; margin-bottom: 20px;">
        <em>{{ $reason }}</em>
    </div>

    <p>We apologize that we are not able to continue our working relationship. We wish you the best in your future endeavors.</p>

    <p>Sincerely,<br>
    HR Department<br>
    XpertVA</p>

</body>
</html>
