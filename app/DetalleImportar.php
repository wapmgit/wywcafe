<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalleImportar extends Model
{
    
	protected $table='detalleimportar';

    protected $primaryKey='iddetalle';

    public $timestamps=false;

    protected $fillable =[
    	'idarticulo',
    	'cantidad',
    	'precio_venta',
    	'descuento'
    ];

    protected $guarded =[

    ];
}
