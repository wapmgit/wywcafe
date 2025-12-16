<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Bloques;
use sisventas\DetalleBloques;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Carbon\Carbon;
use Auth;

class BloquesController extends Controller
{
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {	
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $bloques=DB::table('bloques as v')
            -> where ('v.descripcion','LIKE','%'.$query.'%')        
            ->paginate(20);
    // dd($metas);

     return view ('metas.bloques.index',["bloques"=>$bloques,"searchText"=>$query,"empresa"=>$empresa]);
		
        }
    }
	    public function create(){
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",art.stock," - ",art.costo,"-",art.iva) as articulo'),'art.idarticulo','art.stock','art.costo')
        -> where('art.estado','=','Activo')
        -> get();
        return view("metas.bloques.create",["articulos"=>$articulos,"empresa"=>$empresa]);
    }
	  public function store(Request $request){
		
$user=Auth::user()->name;
try{
    DB::beginTransaction();
    $ajuste=new Bloques;
    $ajuste->descripcion=$request->get('concepto');
    $ajuste->responsable=$request->get('responsable');
    $ajuste->articulos=$request->get('totalo');
    $mytime=Carbon::now('America/Caracas');
    $ajuste->fecha=$mytime->toDateTimeString();
    $ajuste-> save();

        $idarticulo = $request -> get('idarticulo');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleBloques();
            $detalle->idbloque=$ajuste->idbloque;
            $detalle->idarticulo=$idarticulo[$cont];          
            $detalle->save();  
            $cont=$cont+1;
            }
        DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}

return Redirect::to('metas/bloques');
}
public function show($id){
//	dd($id);
    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $bloque=DB::table('bloques as a')
            ->where ('a.idbloque','=',$id)
            -> first();

            $detalles=DB::table('detalle_bloque as da')
            -> join('articulo as a','da.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','a.codigo')
            -> where ('da.idbloque','=',$id)
            ->get();

            return view("metas.bloques.show",["bloque"=>$bloque,"detalles"=>$detalles,"empresa"=>$empresa]);
}
    public function edit($id)
    {
		$detalles=DB::table('detalle_bloque as da')
            -> join('articulo as a','da.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','a.codigo','a.idarticulo','da.iddetallebloque')
            -> where ('da.idbloque','=',$id)
            ->get();
			$articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre) as articulo'),'art.idarticulo')
        -> where('art.estado','=','Activo')
        -> get();
        return view("metas.bloques.edit",["bloque"=>Bloques::findOrFail($id),"detalles"=>$detalles,"articulos"=>$articulos]);
    }
	 public function update(Request $request,$id)
    {		
        $categoria=Bloques::findOrFail($id);
        $categoria->descripcion=$request->get('nombre');
        $categoria->responsable=$request->get('responsable');
        $categoria->update();
        return Redirect::to('metas/bloques');
    }
	public function addart(Request $request){	
	//dd($request);
		$dp=Bloques::findOrFail($request -> get('idbloque'));
		$dp->articulos=($dp->articulos+1);	
		$dp->update();
		
		$kar=new DetalleBloques;
		$kar->idbloque=$request -> get('idbloque');
		$kar->idarticulo=$request -> get('pidarticulo');		
		$kar->save();

  return Redirect::to('metas/bloques/'.$request -> get('idbloque').'/edit');
}
    public function destroy(Request $request,$id)
    {
		//dd($request);
		$dp=Bloques::findOrFail($request -> get('bloque'));
		$dp->articulos=($dp->articulos-1);	
		$dp->update();
		
		$note = DetalleBloques::findOrFail($request -> get('detalle'));
		$note->delete();
		
    return Redirect::to('metas/bloques/'.$request -> get('bloque').'/edit');
    }
}
