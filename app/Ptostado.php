<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Ptostado extends Model
{
       protected $table='ptostado';

    protected $primaryKey='idt';

    public $timestamps=false;

    protected $fillable =[
    	'tostador',
    	'cochas',
    	'idmprima',
    	'kgmprima',
		'kgtostado',
		'comision',
		'fecha',
		'responsable'
    ];

    protected $guarded =[

    ];
}
