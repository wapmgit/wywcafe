<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DevolucionCompras extends Model
{
          protected $table='devolucioncompras';

    protected $primaryKey='iddevolucion';

    public $timestamps=false;

    protected $fillable =[
    	'idcompra',
    	'fecha_hora',
    	'usuario'
    ];

    protected $guarded =[

    ];
}
