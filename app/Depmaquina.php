<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Depmaquina extends Model
{
protected $table='depmaquina';

    protected $primaryKey='iddep';

    public $timestamps=false;

    protected $fillable =[
    	'nombre',
		'kg',
		'pendiente'
    ];

    protected $guarded =[

    ];
}
