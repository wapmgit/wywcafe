<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Pacientes extends Model
{
    protected $table='clientes';
    
    protected $primaryKey='id_cliente';
    
    public $timestamps=false;
    
    protected $fillable =[
        'nombre',
        'cedula',
        'telefono',
        'status',
        'imagen'
    ];
    
    protected $guarded =[
        
    ];
    
}
