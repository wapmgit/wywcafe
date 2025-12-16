<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Detallepedido extends Model
{
           protected $table='detalle_pedido';

    protected $primaryKey='iddetalle_venta';

    public $timestamps=false;

    protected $fillable =[
    	'idventa',
    	'idarticulo',
    	'cantidad',
		'costoarticulo',
    	'precio_venta',
    	'descuento',
		'fecha',
		'fecha_emi'
    ];

    protected $guarded =[

    ];
}
