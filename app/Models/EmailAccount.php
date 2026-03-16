<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailAccount extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'password',
        'imap_host',
        'imap_port',
        'smtp_host',
        'smtp_port',
    ];

    protected $casts = [
        'password' => 'encrypted',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
