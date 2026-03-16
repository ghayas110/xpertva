<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LateRecord extends Model
{
    protected $fillable = [
        'user_id',
        'attendance_id',
        'date',
        'month',
        'year',
        'warning_email_sent',
        'deduction_email_sent',
    ];

    protected $casts = [
        'date' => 'date',
        'warning_email_sent' => 'boolean',
        'deduction_email_sent' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class);
    }
}
