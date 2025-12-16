<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class precios extends Model
{
      protected $table='tratamientos';
    
    protected $primaryKey='id_tratamiento';
    
    public $timestamps=false;
    
    protected $fillable =[
        'tratamiento',
        'clase',
        'precio_base',
        'status'
    ];
    
    protected $guarded =[
        
    ];
}
