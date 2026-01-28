<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Maquinaria extends Model
{
	protected $table='depmaquina';
	protected $primaryKey='iddep';

    public $timestamps=false;

    protected $fillable =[
    	'idempresa',
		'nombre',
		'marca',
		'serie',
		'tipo',
		'kg',
		'pendiente'
    ];

    protected $guarded =[

    ];
}
