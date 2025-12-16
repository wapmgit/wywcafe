<?php

namespace sisventas;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table='recibos';

    protected $primaryKey='idrecibo';

    public $timestamps=false;

    protected $fillable =[
    	
    	'idventa',
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
