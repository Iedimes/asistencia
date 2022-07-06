<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class Help extends Model implements Auditable
{
    protected $fillable = [
        'ci',
        'name',
        'user',
        'dependency',
        'fone',
        'problem',
        'dependency_id'

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    use AuditableTrait;

    protected $guarded = [];

    protected $appends = ['resource_url'];
    protected $with = ['statuses','tecnico'];


    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/helps/'.$this->getKey());
    }

    public function statuses()
    {
        return $this->hasOne(DetailHelp::class)->latest();
    }

    public function tecnico()
    {
        return $this->hasOne(DetailHelp::class)->latest();
    }



}
