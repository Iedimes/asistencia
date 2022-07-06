<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;


class DetailHelp extends Model implements Auditable
{
    protected $fillable = [
        'help_id',
        'user_id',
        'state_id',
        'solution',
        'date',
        'category_id',
        'patrimony',

    ];


    protected $dates = [
        'date',
        'created_at',
        'updated_at',

    ];

    use AuditableTrait;

    protected $guarded = [];

    protected $appends = ['resource_url'];
    protected $with = ['state','category','user'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/detail-helps/'.$this->getKey());
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State');

    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\AdminUser', 'user_id', 'id');
    }






}
