<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class empresa extends Model
{
   protected $table='empresa';
  protected $primaryKey='idempresa';
    public $timestamps=false;

    protected $fillable =[
    	'idempresa',
    	'nombre',
    	'rif',
    	'tc'
    ];
    protected $guarded =[

    ];
}
