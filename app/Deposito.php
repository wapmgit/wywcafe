<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
protected $table='deposito';

    protected $primaryKey='id_deposito';

    public $timestamps=false;

    protected $fillable =[
    	'nombre',
		'identificacion',
		'debe',
		'debo'
    ];

    protected $guarded =[

    ];
}
