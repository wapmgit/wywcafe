<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Regdeposito extends Model
{
protected $table='reg_deposito';

    protected $primaryKey='idreg';

    public $timestamps=false;

    protected $fillable =[
    	'deposito',
		'idarticulo',
		'debe',
		'debo'
    ];

    protected $guarded =[

    ];
}
