<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class MetasVendedor extends Model
{
       protected $table='metasvendedor';
    
    protected $primaryKey='idmeta';
    
    public $timestamps=false;
    
    protected $fillable =[
        'descripcion',
        'creado',
        'inicio',
        'fin',
		'estatus',
		'cumplimiento',
		'cntarticulos',
		'valormeta',
		'nclientes',
		'pnclientes',
		'cobranza',		
		'pcobranza',		
		'reactivar',
		'preactivar',
		'crecimento',
		'pcrecimento'
    ];
    
    protected $guarded =[
        
    ];   //
}
