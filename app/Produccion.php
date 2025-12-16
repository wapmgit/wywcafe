<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Produccion extends Model
{
       protected $table='produccion';

    protected $primaryKey='idproduccion';

    public $timestamps=false;

    protected $fillable =[
    	'idempresa',
    	'responsable',
    	'encargado',
    	'idprima',
    	'kgsubido',
    	'kgmolidos',
    	'reduccion',
    	'idproductofinal',
    	'tipoemp',
    	'kgempa',
    	'kgdif',
    	'fecha',
    	'usuario'
    ];

    protected $guarded =[

    ];
}
