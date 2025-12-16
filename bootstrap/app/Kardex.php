<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Kardex extends Model
{
       protected $table='kardex';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'id',
    	'fecha',
    	'documento',
    	'cantidad',
    	'costo',
		'user',
    	'tipo'
    ];

    protected $guarded =[

    ];
}
