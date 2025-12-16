<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Vendedores extends Model
{
        protected $table='vendedores';

    protected $primaryKey='id_vendedor';

    public $timestamps=false;

    protected $fillable =[
    	'nombre',
    	'telefono',
    	'cedula',
		'direccion'
    ];

    protected $guarded =[

    ];

}
