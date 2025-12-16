<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Mov_notasp extends Model
{
          protected $table='mov_notasp';
    
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
