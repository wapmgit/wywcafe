<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class recibo_comision extends Model
{
         protected $table='recibo_comision';

    protected $primaryKey='id_recibo';

    public $timestamps=false;

    protected $fillable =[
    	'id_comision',
    	'monto',
       	'observacion',
        'fecha',
		'user'
    
    ];

    protected $guarded =[

    ];
}
