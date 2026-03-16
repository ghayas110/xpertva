<!DOCTYPE html>
<html>
<head>
    <title>Salary Deduction Notice</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Notice: Salary Deduction for Late Arrivals</h2>
    <p>Dear {{ $user->name }},</p>
    <p>This email is to inform you that you arrived late on <strong>{{ $date->format('F j, Y') }}</strong>.</p>
    <p>This is your <strong>third</strong> late arrival this month. Pursuant to company policy, a 1-day salary deduction will be applied to your upcoming payroll.</p>
    <p>Additionally, please be aware that being habitually late (3 late arrivals for 2 consecutive months) will result in the loss of your yearly/monthly bonuses.</p>
    <p>If you believe there has been an error, please contact HR immediately.</p>
    <br>
    <p>Sincerely,</p>
    <p>HR Department</p>
</body>
</html>
