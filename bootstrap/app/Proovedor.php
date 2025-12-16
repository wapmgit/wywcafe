<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Proovedor extends Model
{
 protected $table='proveedor';

    protected $primaryKey='idproveedor';

    public $timestamps=false;

    protected $fillable =[
    	
    	'nombre',
    	'rif',
    	'direccion',
    	'telefono',
    ];

    protected $guarded =[

    ];

}