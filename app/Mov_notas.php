<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Mov_notas extends Model
{
        protected $table='mov_notas';
    
    protected $primaryKey='id_mov';
    
    public $timestamps=false;
    
    protected $fillable =[
        'tipodoc',
        'iddoc',
        'monto'
    ];
    
    protected $guarded =[
        
    ];
}
