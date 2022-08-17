<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
    protected $table = 'reporte';

    protected $fillable = [
        'inicio',
        'fin',
        'user_id',
    
    ];
    
    
    protected $dates = [
        'inicio',
        'fin',
    
    ];
    public $timestamps = false;
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/reportes/'.$this->getKey());
    }
}
