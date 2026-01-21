<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalleTraslado extends Model
{
  protected $table='detalle_traslado';

    protected $primaryKey='iddetalle';

    public $timestamps=false;

    protected $fillable =[
    	'idpedido',
		'idarticulo',
		'cantidad',
		'precio'
    ];

    protected $guarded =[

    ];
}
