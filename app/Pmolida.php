<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Pmolida extends Model
{
        protected $table='pmolida';

    protected $primaryKey='idm';

    public $timestamps=false;

    protected $fillable =[
    	'idempresa',
    	'responsable',
    	'fecha',
		'kgmprima',
		'tipo',
		'producto',
		'unidades',
		'tkilos',
		'reduccionm'
		
    ];

    protected $guarded =[

    ];
}
