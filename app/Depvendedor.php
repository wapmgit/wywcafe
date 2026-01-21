<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Depvendedor extends Model
{
protected $table='depvendedor';

    protected $primaryKey='id_deposito';

    public $timestamps=false;

    protected $fillable =[
    	'nombre',
		'descripcion',
		'idvendedor'
    ];

    protected $guarded =[

    ];
}
