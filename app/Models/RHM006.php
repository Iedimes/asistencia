<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RHM006 extends Model
{
    protected $table = 'RHM006';
    protected $primaryKey = 'FuncNro';
    public $keyType = 'string';
    public $timestamps = false;
    protected $connection = 'sqlsrv';

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
        'DepenCod',
        'FuncEst',
    ];

    public function dpto()
    {
        return $this->hasOne(SIG008::class, 'DepenCod', 'DepenCod');
    }
}
