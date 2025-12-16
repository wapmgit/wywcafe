<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalleProduccion extends Model
{
         protected $table='detalle_produccion';

    protected $primaryKey='iddetalle';

    public $timestamps=false;

    protected $fillable =[
    	'idproduccion',
    	'idproducto',
    	'cantidad',
    	'kgproduccion'
    ];

    protected $guarded =[

    ];
}
