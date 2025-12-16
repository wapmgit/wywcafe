<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Relacionnc extends Model
{
       protected $table='relacionnc';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'idmov',
    	'idnota'
    ];

    protected $guarded =[

    ];
}
