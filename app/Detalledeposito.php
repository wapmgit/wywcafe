<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Detalledeposito extends Model
{
        protected $table='detalledeposito';

    protected $primaryKey='iddetalle';

    public $timestamps=false;

    protected $fillable =[
    	'idregistro',
    	'tipo',
    	'tiporeg',
		'cantidad',
		'fecha',
		'usuario'
    ];

    protected $guarded =[

    ];
}
