<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Notasadm extends Model
{
    protected $table='notasadm';

    protected $primaryKey='idnota';

    public $timestamps=false;

    protected $fillable =[
    	'tipo',
    	'idcliente',
    	'descripcion',
    	'referencia',   	
    	'monto'
    ];

    protected $guarded =[

    ];
}
