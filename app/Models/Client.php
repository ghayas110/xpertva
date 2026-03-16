<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'company_name',
        'company_logo',
        'email',
        'phone',
        'background_info',
        'website',
        'source',
        'attached_file',
        'status',
        'assigned_sales_id',
        'assigned_va_id',
        'contract_link',
    ];

    protected $casts = [
        'email' => 'array',
        'phone' => 'array',
    ];

    public function assignedSales()
    {
        return $this->belongsTo(User::class, 'assigned_sales_id');
    }

    public function assignedVA()
    {
        return $this->belongsTo(User::class, 'assigned_va_id');
    }

    public function financials()
    {
        return $this->hasMany(Financial::class);
    }
}
