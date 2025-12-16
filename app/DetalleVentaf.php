<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalleVentaf extends Model
{
    
	protected $table='detalle_ventaf';

    protected $primaryKey='iddetalle_venta';

    public $timestamps=false;

    protected $fillable =[
    	'idventa',
    	'idarticulo',
    	'cantidad',
    	'precio_venta',
    	'descuento'
    ];

    protected $guarded =[

    ];
}
