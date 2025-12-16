<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Depmaquina extends Model
{
protected $table='depmaqina';

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
