<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduRecord extends Model
{
    protected $fillable = [
        'name', 'gender', 'birth_date', 'age_months', 
        'weight', 'height', 'bmi', 'status_gizi'
    ];
}