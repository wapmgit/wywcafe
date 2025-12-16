<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Devolucion extends Model
{
     protected $table='devolucion';

    protected $primaryKey='iddevolucion';

    public $timestamps=false;

    protected $fillable =[
    	'idventa',
    	'comprobante',
    	'fecha_hora',
    	'user'
    ];
    protected $guarded =[

    ];

}
