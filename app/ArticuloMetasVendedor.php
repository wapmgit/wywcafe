<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class ArticuloMetasVendedor extends Model
{
      protected $table='articulometasvendedor';
    
    protected $primaryKey='id';
    
    public $timestamps=false;
    
    protected $fillable =[
        'idmeta',
        'idarticulo',
        'cantidad',
		'valor'
    ];
    
    protected $guarded =[
        
    ];
}
