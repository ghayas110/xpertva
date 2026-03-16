<!DOCTYPE html>
<html>
<head>
    <title>Late Arrival Warning</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Warning: Late Arrival Notice</h2>
    <p>Dear {{ $user->name }},</p>
    <p>This is a formal notification that you have clocked in late on <strong>{{ $date->format('F j, Y') }}</strong>.</p>
    <p>According to our records, this marks your <strong>second</strong> late arrival this month. As per company policy, a third late arrival within the same month will result in a 1-day salary deduction.</p>
    <p>Please ensure you clock in before the designated start time to avoid further penalties.</p>
    <br>
    <p>Sincerely,</p>
    <p>HR Department</p>
</body>
</html>
