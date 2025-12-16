<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Metas extends Model
{
      protected $table='metas';
    
    protected $primaryKey='idmeta';
    
    public $timestamps=false;
    
    protected $fillable =[
        'descripcion',
        'creado',
        'inicio',
        'fin',
		'estatus',
		'cumplimiento'
    ];
    
    protected $guarded =[
        
    ];
}
