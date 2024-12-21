<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Brackets\Media\HasMedia\ProcessMediaTrait;
use Brackets\Media\HasMedia\AutoProcessMediaTrait;
use Brackets\Media\HasMedia\HasMediaCollectionsTrait;
use Brackets\Media\HasMedia\HasMediaThumbsTrait;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;

class Help extends Model implements Auditable, HasMedia
{
    use AuditableTrait;
    use ProcessMediaTrait, AutoProcessMediaTrait, HasMediaCollectionsTrait, HasMediaThumbsTrait;

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

    protected $guarded = [];

    protected $appends = ['resource_url'];
    protected $with = ['statuses', 'tecnico', 'detailsHelps', 'documento'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/helps/' . $this->getKey());
    }

    public function statuses()
    {
        return $this->hasOne(DetailHelp::class)->latest();
    }

    public function tecnico()
    {
        return $this->hasOne(DetailHelp::class)->latest();
    }

    public function detailsHelps()
    {
        return $this->hasMany(DetailHelp::class);  // Relación de uno a muchos
    }

    public function documento()
    {
        return $this->belongsTo('App\Models\Medium', 'id', 'model_id');
    }

    /* ************************ MEDIA CONFIGURATION ************************* */

    function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery')
            ->maxFilesize(1024 * 1024 * 30) // Tamaño máximo 30 MB
            ->maxNumberOfFiles(1);          // Máximo 5 archivos
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->autoRegisterThumb200();
    }
}
