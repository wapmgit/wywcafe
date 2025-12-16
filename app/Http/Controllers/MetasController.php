<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Metas;
use sisventas\ArticuloMetas;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Carbon\Carbon;
use Auth;

class MetasController extends Controller
{
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {
			$rol=DB::table('roles')-> select('metae')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $metas=DB::table('metas as v')
            -> where ('v.descripcion','LIKE','%'.$query.'%')        
            ->paginate(20);
    // dd($metas);
    	 if($rol->metae){
     return view ('metas.metas.index',["metas"=>$metas,"searchText"=>$query,"empresa"=>$empresa]);
		}else{
			return view('reportes.mensajes.noautorizado');	
		 }
        }
    }
    public function create(){
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",art.stock," - ",art.precio1,"-",art.iva) as articulo'),'art.idarticulo','art.precio1')
        -> where('art.estado','=','Activo')
        -> get();
        return view("metas.metas.create",["articulos"=>$articulos,"empresa"=>$empresa]);
    } 
		    public function show($id)  
    { 
        $meta=Metas::findOrFail($id);
        $articulos=DB::table('articulometas as am')
            -> join('articulo as art','art.idarticulo','=','am.idarticulo')
            ->where ('am.idmeta','=',$id)
            ->orderBy('art.nombre','asc')
            ->get();
			$datos=DB::table('articulometas as am') 
			 ->join('detalle_venta as dv','dv.idarticulo','=','am.idarticulo')			    
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'am.idarticulo')
            ->where('am.idmeta','=',$id)
			->whereBetween('dv.fecha_emi', [$meta->inicio, $meta->fin])
			->groupby('am.idarticulo')
            ->get();	
		//dd($datos);
      return view("metas.metas.show",["articulos"=>$articulos,"meta"=>$meta,"datos"=>$datos]);
    }
	    public function edit($id)
    {
			$dat=explode("-",$id);
    $id=$dat[0];
    $meta=$dat[1];
        $categoria=Metas::findOrFail($id);
        $categoria->cumplimiento=$meta;
        $categoria->estatus=1;
        $categoria->update();
    return Redirect::to('metas/metas');
    }
	    public function store (Request $request)
    {
	//	dd($request);
        $categoria=new Metas;
        $categoria->descripcion=$request->get('descripcion');
        $categoria->inicio=$request->get('inicio');
        $categoria->fin=$request->get('fin');
        $categoria->estatus=0;
        $categoria->cumplimiento=0;
        $categoria->cntarticulos=$request->get('cnt');
        $categoria->valormeta=$request->get('totalo');
		$mytime=Carbon::now('America/Caracas');
		$categoria->creado=$mytime->toDateTimeString();
        $categoria->save();
		
		$idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $costo = $request -> get('precio_compra');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new ArticuloMetas();
            $detalle->idmeta=$categoria->idmeta;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->valor=($costo[$cont]);
            $detalle->save();    
            $cont=$cont+1;
		}
        return Redirect::to('metas/metas');

    }
	    public function destroy($id)
    {
        $meta=Metas::findOrFail($id);
        $meta->estatus='2';
        $meta->update();
        return Redirect::to('metas/metas');
    }

}
