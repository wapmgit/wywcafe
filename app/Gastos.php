<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
        protected $table='gasto';

    protected $primaryKey='idgasto';

    public $timestamps=false;

    protected $fillable =[
    	'idpersona',
    	'tipop',
    	'documento',
    	'descripcion',
    	'monto',
    	'saldo',
    	'fecha',
    	'usuario'
    ];

    protected $guarded =[

    ];
}

