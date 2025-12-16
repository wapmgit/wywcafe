<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Almacenvacios extends Model
{
protected $table='almacenvacios';

    protected $primaryKey='idregistro';

    public $timestamps=false;

    protected $fillable =[
    	'entrada',
		'salida',
		'idarticulo',
		'concepto',
		'responsable',
		'fecha'
    ];

    protected $guarded =[

    ];
}
