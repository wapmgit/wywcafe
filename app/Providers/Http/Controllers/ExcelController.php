<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\User;
use sisventas\Articulo;
use sisventas\Venta;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Redirect;

class ExcelController extends Controller
{
	 public function __construct()
    {

    } 

	public function reportecxc($v){

 $data=Venta::select('serie_comprobante','venta.num_comprobante','venta.fecha_emi as fecha_hora','c.nombre','c.cedula','c.telefono','venta.diascre','ve.nombre as vendedor','venta.saldo as Pendiente')
			->join('clientes as c','c.id_cliente','=','venta.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','venta.idvendedor')
			->where('venta.idvendedor','=',$v)
			->where('venta.saldo','>',0)
			->where('venta.tipo_comprobante','=','FAC')
			->where('venta.devolu','=',0)
			->orderby('c.nombre','ASC')	
			->get();
			//dd($data);
		Excel::create('CXC-Sysventas',function($excel) use ($data){
		 $excel->sheet('excel-shhet',function($sheet) use ($data){
			 	
			 $sheet->fromArray($data);
		 });
		 ob_end_clean();
		})->export('xlsx');
		 return Redirect::to('/reportes/cobrar');
	}
	public function exportUsers()
	{
	/** Fuente de Datos Eloquent */
$data=Articulo::select('articulo.codigo as Codigo','articulo.nombre as Articulo','categoria.nombre as Grupo','articulo.stock as Cantidad','articulo.costo as Costo','articulo.precio1 as Precio')
   ->Join('categoria', 'articulo.idcategoria', '=', 'categoria.idcategoria')
    ->get();

	/** Creamos nuestro archivo Excel */
	Excel::create('usuarios', function ($excel) use ($data) {
	
	/** Creamos una hoja */
	$excel->sheet('Hoja Uno', function ($sheet) use ($data) {
	/**
•	* Insertamos los datos en la hoja con el método with/fromArray
•	* Parametros: (
•	* Datos,
•	* Valores del encabezado de la columna,
•	* Celda de Inicio,
•	* Comparación estricta de los valores del encabezado
•	* Impresión de los encabezados
•	* )*/
	$sheet->with($data, null, 'A1', false, false);
	});
		/** Descargamos nuestro archivo pasandole la extensión deseada (xls, xlsx) */
	})->download('txt');
	 return Redirect::to('almacen/articulo');
	}
   public function inventariof()
 {	
 $data=Articulo::select('articulo.nombre as Articulo','articulo.stock as Cantidad','articulo.precio1','articulo.precio2')
   ->where('articulo.stock', '>', '0')->get();
	//dd($data);
 /** Creamos nuestro archivo Excel */  
 Excel::create('Inventario', function ($excel) use ($data) {

 /** Creamos una hoja */
 $excel->sheet('lista', function ($sheet) use ($data) {
 /**
 * Insertamos los datos en la hoja con el método with/fromArray
• * Parametros: (
• * Datos,
• * Valores del encabezado de la columna,
• * Celda de Inicio,
• * Comparación estricta de los valores del encabezado
• * Impresión de los encabezados
• * )*/
 $sheet->with($data, null, 'A1', false, false);
 });
 /** Descargamos nuestro archivo pasandole la extensión deseada (xls, xlsx) */
 })->download('txt');
  return Redirect::to('/reportes/inventario');
 }   
}
