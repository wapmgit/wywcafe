<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
        protected $table='movimientos';
    
    protected $primaryKey='id';
    
    public $timestamps=false;
    
    protected $fillable =[
        'tipo',
        'deposito',
		'articulo',
		'exisant',
		'exismov',
		'fecha',
		'usuario'
    ];
    
    protected $guarded =[
        
    ];
}
