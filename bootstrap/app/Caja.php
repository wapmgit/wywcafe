<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table='mov_ban';

    protected $primaryKey='id_mov';

    public $timestamps=false;

    protected $fillable =[
    	'idcaja',
    	'tipo_mov',
    	'numero',
		'concepto',
		'idbeneficiario',
		'monto',
		'tasadolar',
		'estatus',
		'user'
    ];

    protected $guarded =[

    ];
}
