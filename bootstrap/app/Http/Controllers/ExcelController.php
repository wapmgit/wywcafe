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

	public function reportecxc(){
//dd($request);
		Excel::create('hoja',function($excel){
		 $excel->sheet('excel-shhet',function($sheet){
			 	 $data=Articulo::all();
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
