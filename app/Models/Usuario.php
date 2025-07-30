<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'USUARIO'; // nombre exacto de la tabla
    protected $primaryKey = 'UsuCod'; // si tu clave primaria es esta

    public $timestamps = false; // porque no usás created_at/updated_at
    protected $connection = 'sqlsrv';

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
