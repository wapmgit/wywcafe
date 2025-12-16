<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Detalledevolucion extends Model
{
    
           protected $table='detalle_devolucion';

    protected $primaryKey='iddetalle_devolucion';

    public $timestamps=false;

    protected $fillable =[
    	'iddevolucion',
    	'idarticulo',
    	'cantidad',
    	'precio_venta',
    	'descuento'
    ];

    protected $guarded =[

    ];
}
