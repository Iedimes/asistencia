<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $table = 'RHM006';
    protected $primaryKey = 'FuncNro';
    public $keyType = 'string';
    public $timestamps = false;
    protected $connection = 'sqlsrv';
    public $incrementing = false;

    public function getConnectionName()
    {
        if (app()->environment('testing')) {
            return config('database.default');
        }

        return $this->connection;
    }

    protected $fillable = [
        'FuncNro',
        'FuncNom',
        'FUsuCod',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['resource_url'];

    /* ************************ ACCESSORS ************************* */

    public function getFuncNomAttribute($value)
    {
        return is_string($value) ? trim($value) : $value;
    }

    public function getFUsuCodAttribute($value)
    {
        return is_string($value) ? trim($value) : $value;
    }

    public function getResourceUrlAttribute()
    {
        return url('/admin/funcionarios/'.$this->getKey());
    }
}
