<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RHM006 extends Model
{
    protected $table = 'RHM006';
    //protected $primaryKey = 'VivPer';
    //public $keyType = 'string';
    //public $timestamps = false;
    protected $connection = 'sqlsrv';
    public $incrementing = false;

    protected $fillable = [


    ];

    protected $appends = ['resource_url'];
    protected $with = ['dpto'];


    public function dpto()
    {
        return $this->hasOne(SIG008::class, 'DepenCod', 'UniOrgCod');
    }


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/assists/'.$this->getKey());
    }
}
