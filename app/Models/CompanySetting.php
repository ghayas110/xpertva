<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = ['shift_start', 'shift_end', 'late_cutoff'];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1], [
            'shift_start' => '09:00:00',
            'shift_end'   => '17:00:00',
            'late_cutoff' => '16:55:00',
        ]);
    }
}
