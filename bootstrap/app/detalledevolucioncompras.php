<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class detalledevolucioncompras extends Model
{
       protected $table='detalle_devolucioncompras';

    protected $primaryKey='iddetalle';

    public $timestamps=false;

    protected $fillable =[
    	'codarticulo',
    	'cantidad'
    ];

    protected $guarded =[

    ];
}
