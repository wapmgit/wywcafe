<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
       protected $table='roles';

    protected $primaryKey='idrol';

    public $timestamps=false;

    protected $fillable =[
    	'newcliente',
    	'editcliente',
    	'editvendedor',
    	'newvendedor',
    	'newproveedor',
    	'editproveedor',
    	'newarticulo',
    	'editarticulo',
    	'crearcompra',
		'anularcompra',
		'crearventa',
		'anularventa',
		'creargasto',
		'anulargasto',
		'crearajuste',
		'abonarcxp',
		'abonarcxc',
		'abonargasto',
		'actroles',
		'comisiones',
		'acttasa',
		'actuser'
    ];

    protected $guarded =[

    ];
}
