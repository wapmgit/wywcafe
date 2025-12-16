<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Tostador extends Model
{
protected $table='tostador';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'idempresa',
		'nombre',
		'kg',
		'pendiente'
    ];

    protected $guarded =[

    ];
}
