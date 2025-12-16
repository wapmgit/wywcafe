<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use DB;
use sisventas\Venta;
use sisventas\Ingreso;
use sisventas\Recibo;
use sisventas\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use response;
use Illuminate\Support\Collection;
use Auth;


class ImpuestosController extends Controller
{
    public function __construct()
    {
     
    }
	public function librov(Request $request)
    {
		//dd($request);
		$ide=Auth::user()->idempresa;
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			//$query2 = date_create($query2);
           // date_add($query2, date_interval_create_from_date_string('1 day'));
          //  $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('ventaf as v')          
			->join('formalibre as fl','fl.idventa','=','v.idventa')
             ->join ('clientes as cl', 'cl.id_cliente','=','v.idcliente')      
            -> select('fl.anulado','v.fecha_fac as fecha','v.tasa','v.formato','v.texe','v.mcosto','v.mivaf','v.tipo_comprobante as tipo','cl.cedula as rif','cl.nombre','v.serie_comprobante as serie','fl.idforma as factura','fl.nrocontrol as control','v.total_venta','v.total_iva')
            ->whereBetween('v.fecha_fac', [$query, $query2])
			->where('v.tipo_comprobante','=','FAC')
			-> orderby('fl.idForma','asc')
			//->OrderBy('v.idventa','asc')
            ->get();
			
			$datosb=DB::table('ventasexternas as v')    
			-> join ('clientes as p','v.cliente','=','p.id_cliente')			
            ->whereBetween('v.fecha', [$query, $query2])
			 ->get();
			 $retenc=DB::table('retencionventas as ret')    
			-> join ('formalibre as fl','fl.idventa','=','ret.idfactura')			
			-> join ('clientes as p','p.id_cliente','=','ret.idcliente')			
            ->whereBetween('ret.fecha', [$query, $query2])
			 ->get();
			//$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.impuestos.librov.index',["retenc"=>$retenc,"datosb"=>$datosb,"datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
		public function libroc(Request $request)
    {
		//dd($request);
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
			 if($request->get('moneda')){$moneda=$request->get('moneda');}else{ $moneda=1;}
             if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('ingreso as c')            
             ->join ('proveedor as p', 'p.idproveedor','=','c.idproveedor')      
            -> select('c.tasa','c.idingreso','c.emision as fecha','c.fecha_hora as recepcion','c.tipo_comprobante as tipo','c.serie_comprobante as factura','p.rif','p.nombre','c.num_comprobante as control','c.total','c.base','c.miva as iva','c.exento')
				->whereBetween('c.emision', [$query, $query2])
				->where('c.tipo_comprobante','=',"FAC")
				->where('c.estatus','=',0)
			->OrderBy('c.emision','asc')
            ->get();
			//dd($datos);
			$retenc=DB::table('retenciones as rt')
			->join('retenc as tret','tret.codigo','=','rt.retenc')
			->select('rt.idingreso as idcompra','rt.correlativo','rt.fecha','rt.mretd','tret.ret','tret.afiva')            
            ->whereBetween('rt.fecha', [$query, $query2])
			->where('anulada','=',0)
			->OrderBy('rt.fecha','asc')
            ->get();
			//dd($retenc);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.impuestos.libroc.index',["moneda"=>$moneda,"retenc"=>$retenc,"datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
		public function valorizado(Request $request)
    {
	//	dd($request);
		$year= $request->get('ano');	
        $corteHoy = date("Y-m");      
		$pd=$corteHoy."-01";
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$tc=$empresa->tc; 
		if($request->get('tasa')){$tc=$request->get('tasa');}
        $query=trim($request->get('mes'));
        $mes=trim($request->get('mes'));

		
             if (($query)==""){$query=$corteHoy;  $mes=date("m");}else{			
			 $query=$year."-".$mes;
			 $aux=$year."-".$mes."-01";
		$pd=date("Y-m-d",strtotime($aux."- 1 days"));}
			//	dd($pd);
			$articulo=DB::table('articulo')
			->join('categoria as cat','cat.idcategoria','=','articulo.idcategoria')
			->select('articulo.*')
			->where('estado','=',"Activo")
			->where('cat.servicio','=',0)
			->get();
			$anteriorin=DB::table('kardex as dv')            
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')   
            -> select(DB::raw('sum(dv.cantidad) as cantidad'),DB::raw('AVG(dv.costo) as costop'),'a.idarticulo','dv.tipo')
            ->where('dv.fecha','<=',$pd)
			->where('dv.tipo','=',1)			
            ->groupby('dv.idarticulo','dv.tipo')
            ->get();
			//dd($anteriorin);
			$anteriorout=DB::table('kardex as dv')            
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 			 
            -> select(DB::raw('sum(dv.cantidad) as cantidad'),DB::raw('AVG(dv.costo) as costop'),'a.idarticulo','dv.tipo')
            ->where('dv.fecha','<=',$pd)
			->where('dv.tipo','=',2)
			->groupby('dv.idarticulo','dv.tipo')
            ->get();
			//Sdd($query);		
            $entrada=DB::table('kardex as dv')            
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  
			-> select(DB::raw('sum(dv.cantidad) as cantidad'),DB::raw('AVG(dv.costo) as costop'),'a.idarticulo','dv.tipo')
			->where('dv.tipo','=',1)
			->where('dv.fecha','LIKE','%'.$query.'%')
			->groupby('dv.idarticulo','dv.tipo')
            ->get();
			//dd($entrada);
  //     
			$salida=DB::table('kardex as dv')            
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  		 
            -> select(DB::raw('sum(dv.cantidad) as cantidad'),DB::raw('AVG(dv.costo) as costop'),'a.idarticulo','dv.tipo')
            ->where('dv.tipo','=',2)
			->where('dv.fecha','LIKE','%'.$query.'%')
            ->groupby('dv.idarticulo','dv.tipo')
            ->get();
		//dd($salida);	
        return view('reportes.impuestos.valorizado.index',["year"=>$year,"tasa"=>$tc,"anteriorout"=>$anteriorout,"anteriorin"=>$anteriorin,"articulo"=>$articulo,"entrada"=>$entrada,"salida"=>$salida,"empresa"=>$empresa,"searchText"=>$mes]);
            
    }
		public function licores(Request $request)
    {
		//dd($request);
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			//$query2 = date_create($query2);
           // date_add($query2, date_interval_create_from_date_string('1 day'));
          //  $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('ingreso as in')          
			->join('proveedor as p','p.idproveedor','=','in.idproveedor')
			->join('detalle_ingreso as di','di.idingreso','=','in.idingreso')
             ->join ('articulo as art', 'art.idarticulo','=','di.idarticulo')      
            -> select('in.emision','in.serie_comprobante','in.fecha_hora','p.nombre','art.origen','art.nombre as articulo','art.clase','art.grados','art.volumen','di.cantidad')
            ->whereBetween('in.emision', [$query, $query2])
			->where('art.idcategoria','=',1)
			->where('in.tipo_comprobante','=','FAC')
			-> orderby('in.idingreso','asc')
			//->OrderBy('v.idventa','asc')
            ->get();
			//dd($datos);
			
			$datosb=DB::table('ventaf as ve')          
			->join('formalibre as fl','fl.idventa','=','ve.idventa')
			->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			->join('municipios as mn','mn.id_municipio','=','cl.idmunicipio')
			->join('detalle_ventaf as dv','dv.idventa','=','ve.idventa')
             ->join ('articulo as art', 'art.idarticulo','=','dv.idarticulo')      
            -> select('ve.fecha_fac','fl.idForma as venta','fl.nrocontrol','cl.nombre','mn.municipio as direccion','art.origen','art.nombre as articulo','art.clase','art.grados','art.volumen','dv.cantidad')
            ->whereBetween('ve.fecha_fac', [$query, $query2])
			->where('art.idcategoria','=',1)
			->where('ve.devolu','=',0)
			-> orderby('ve.idventa','asc')
            ->get();
//dd($datosb);
			//$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.impuestos.librol.index',["datosb"=>$datosb,"datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
}
