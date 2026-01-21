<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Traslado extends Model
{
		protected $table='traslado';
       protected $primaryKey='idtraslado';

    public $timestamps=false;

    protected $fillable =[
    	'origen',
		'destino',
		'concepto',
		'responsable',
		'total_traslado',
		'fecha',
		'user'
    ];

    protected $guarded =[

    ];
}
