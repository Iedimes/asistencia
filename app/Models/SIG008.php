<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SIG008 extends Model
{
    protected $table = 'SIG008';
    protected $primaryKey = 'DepenCod';
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
        'DepenCod',
        'DepenDes',
    ];
}
