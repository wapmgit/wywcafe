<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Existencia extends Model
{
	protected $table='existencia';
    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'id_almacen',
    	'idvendedor',
		'idarticulo',
		'existencia'
    ];

    protected $guarded =[

    ];
}
