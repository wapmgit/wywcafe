<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Comisiones extends Model
{
  protected $table='comision';

    protected $primaryKey='id_comision';

    public $timestamps=false;

    protected $fillable =[
    	'id_vendedor',
    	'montoventas',
    	'montocomision',
		'fecha',
		'usuario'
    ];

    protected $guarded =[

    ];
}
