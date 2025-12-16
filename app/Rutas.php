<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
       protected $table='rutas';

    protected $primaryKey='idruta';

    public $timestamps=false;

    protected $fillable =[
    	'nombre',
    	'descripcion'
    ];

    protected $guarded =[

    ];
}
