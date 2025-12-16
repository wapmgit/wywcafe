<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Monedas extends Model
{
         protected $table='monedas';

    protected $primaryKey='idmoneda';

    public $timestamps=false;

    protected $fillable =[
    	'nombre',
    	'tipo',
    	'simbolo',
    	'valor'
    ];

    protected $guarded =[

    ];
}
