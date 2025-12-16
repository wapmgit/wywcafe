<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class DetalleBloques extends Model
{
        protected $table='detalle_bloque';

    protected $primaryKey='iddetallebloque';

    public $timestamps=false;

    protected $fillable =[
    	'idbloque',
    	'idarticulo'
    ];

    protected $guarded =[

    ];
}
