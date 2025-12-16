<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Ajuste extends Model
{
     protected $table='ajuste';

    protected $primaryKey='idajuste';

    public $timestamps=false;

    protected $fillable =[
    	'concepto',
    	'responsable',
       	'fecha_hora',
        'monto'
    
    ];

    protected $guarded =[

    ];
}
