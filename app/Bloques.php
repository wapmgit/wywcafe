<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Bloques extends Model
{
        protected $table='bloques';

    protected $primaryKey='idbloque';

    public $timestamps=false;

    protected $fillable =[
    	'descripcion',
    	'articulos',
		'responsable',
		'fecha',
		'estatus'
    ];

    protected $guarded =[

    ];
}
