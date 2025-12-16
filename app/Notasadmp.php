<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Notasadmp extends Model
{
   protected $table='notasadmp';

    protected $primaryKey='idnota';

    public $timestamps=false;

    protected $fillable =[
    	'tipo',
    	'idcliente',
    	'descripcion',
    	'referencia',   	
    	'monto',
		'fecha',
		'pendiente',
		'usuario'
    ];

    protected $guarded =[

    ];
}
