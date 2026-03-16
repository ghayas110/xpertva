<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    protected $fillable = [
        'client_id',
        'amount',
        'currency',
        'category',
        'region_tag',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
