<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Fexterna extends Model
{
        protected $table='ventasexternas';

    protected $primaryKey='idventa';

    public $timestamps=false;

    protected $fillable =[
    	'rif',
    	'cliente',
    	'serie',
    	'tipo',
    	'factura',
    	'control',
    	'fecha',
    	'totalventa',
    	'base',
    	'iva',
    	'exento'
    ];

    protected $guarded =[

    ];
}
