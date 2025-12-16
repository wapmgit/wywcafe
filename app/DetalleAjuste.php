<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalleAjuste extends Model
{
   
           protected $table='detalle_ajuste';

    protected $primaryKey='iddetalle_ajuste';

    public $timestamps=false;

    protected $fillable =[
    	'idajuste',
    	'idarticulo',
    	'tipo_ajuste',
    	'cantidad',   	
    	'valorizado'
    ];

    protected $guarded =[

    ];
}
