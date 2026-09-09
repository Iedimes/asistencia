<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'USUARIO';
    protected $primaryKey = 'UsuCod';

    protected $keyType = 'string';
    public $incrementing = false;

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
        'UsuCod',
        'UsuNombre',
        'UsuPass',
        'EmpId',
        'UsuCls',
        'DepenCod',
        'Usuest',
        'UsuFeMo',
        'UsuMod',
        'UsuFeIn',
        'UsuIng',
        'UsuCed',
    ];

    public function dpto()
    {
        return $this->hasOne(SIG008::class, 'DepenCod', 'DepenCod');
    }
}
