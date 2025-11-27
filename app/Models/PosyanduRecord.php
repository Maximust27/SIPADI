<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PosyanduRecord extends Model
{
    protected $fillable = [
        'user_id', 
        'child_name', 
        'gender', 
        'birth_date', 
        'age_months', 
        'weight', 
        'height', 
        'bmi', 
        'status_gizi'
    ];
    public function parent()
    {
        // belongsTo artinya "Record ini milik User tertentu"
        return $this->belongsTo(User::class, 'user_id');
    }
}