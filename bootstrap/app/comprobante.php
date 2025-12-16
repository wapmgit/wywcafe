<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class comprobante extends Model
{
   protected $table='comprobante';

    protected $primaryKey='idrecibo';

    public $timestamps=false;

    protected $fillable =[
    	
    	'idcompra',
    	'monto',
    	'efectivo',
    	'debito',
    	'refdeb',
    	'cheque',
    	'refche',
    	'transferencia',
    	'reftrans',
    	'aux',
    ];

    protected $guarded =[

    ];
}
