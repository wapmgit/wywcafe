<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Formalibre extends Model
{
       protected $table='formalibre';

    protected $primaryKey='idforma';

    public $timestamps=false;

    protected $fillable =[
    	'idventa',
    	'nrocontrol'
    ];

    protected $guarded =[

    ];
}
