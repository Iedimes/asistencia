<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SIG008 extends Model
{
    protected $table = 'SIG008';
    //protected $primaryKey = 'VivPer';
    //public $keyType = 'string';
    //public $timestamps = false;
    protected $connection = 'sqlsrv';
    public $incrementing = false;

    protected $fillable = [


    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/assists/'.$this->getKey());
    }
}
