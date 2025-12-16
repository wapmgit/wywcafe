<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class ArticuloMetas extends Model
{
      protected $table='articulometas';
    
    protected $primaryKey='id';
    
    public $timestamps=false;
    
    protected $fillable =[
        'idmeta',
        'idarticulo',
        'cantidad'
    ];
    
    protected $guarded =[
        
    ];
}
