<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Functionary extends Model
{
    protected $fillable = [
        'ci',
        'full_name',
        'user_name',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/functionaries/'.$this->getKey());
    }
}
