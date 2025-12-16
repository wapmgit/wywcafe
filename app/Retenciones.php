<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Retenciones extends Model
{
       protected $table='retenciones';

    protected $primaryKey='idretencion';

    public $timestamps=false;

    protected $fillable =[
    	'idingreso',
    	'retenc',
    	'mfac',
    	'mbase',
    	'miva',
    	'mexento',
    	'mfecha',
		'mret',
		'mretd'
    ];

    protected $guarded =[

    ];
}
