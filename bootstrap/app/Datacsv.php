<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Datacsv extends Model
{
        protected $table='datacsv';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'idarticulo',
    	'nombre',
    	'costo',
    	'cantidad'
    ];

    protected $guarded =[

    ];
}
