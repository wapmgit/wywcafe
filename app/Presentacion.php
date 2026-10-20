<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Presentacion extends Model
{
     protected $table='presentacion';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'idarticulo',
    	'descripcion',
    	'costo',
    	'utilidad',
    	'cantidad',
    	'preciov'
    ];

    protected $guarded =[

    ];
}
