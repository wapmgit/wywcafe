<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Relacionncp extends Model
{
       protected $table='relacionncp';

    protected $primaryKey='id';

    public $timestamps=false;

    protected $fillable =[
    	'idmov',
    	'idnota'
    ];

    protected $guarded =[

    ];
}
