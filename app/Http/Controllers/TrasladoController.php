<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;

use sisventas\Traslado;
use sisventas\Existencia;
use sisventas\Movimientos;
use sisventas\Articulo;
use sisventas\DetalleTraslado;
use Carbon\Carbon;
use DB;
use Auth;

class TrasladoController extends Controller
{
  	  public function __construct()
    {
     
    }
     public function index(Request $request)
    {      $ide=Auth::user()->idempresa;
            $query=trim($request->get('searchText'));
            $ventas=DB::table('traslado as p')
            -> join ('depvendedor as ori','p.origen','=','ori.id_deposito')
			-> join ('depvendedor as des','p.destino','=','des.id_deposito')
            -> select ('p.idtraslado','p.fecha','p.concepto','p.responsable','p.user','ori.nombre as origen','des.nombre as destino','p.total_traslado')		
            -> where ('ori.nombre','LIKE','%'.$query.'%')
            -> where ('p.idempresa','=',$ide)
			-> OrderBY ('idtraslado','DESC')			
            ->paginate(50);	//dd($ventas);
    //dd($ventas);
     return view ('depositos.traslados.index',["ventas"=>$ventas,"searchText"=>$query]);
    } 
	   public function create(Request $request){
		   	$ide=Auth::user()->idempresa;
        $deposito=DB::table('depvendedor')->where('idempresa','=',$ide)->get();
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," - ",art.nombre," - ",stock) as articulo'),'art.idarticulo','art.stock','art.costo')
        -> where('art.estado','=','Activo')
        -> get();
        return view("depositos.traslados.create",["articulos"=>$articulos,"empresa"=>$empresa,"deposito"=>$deposito]);
    }  	
		public function listar (Request $request){
           $ide=Auth::user()->idempresa;
            if($request->ajax()){
				$articulos=DB::table('articulo')
				->join('existencia as ex','ex.idarticulo','=','articulo.idarticulo')
				->where('ex.existencia','>',0)->where('articulo.estado','=',"Activo")
				->where('ex.id_almacen','=',$request->get('origen'))
				->where('ex.idempresa','=',$ide)
				->select(DB::raw('CONCAT(articulo.codigo," - ",articulo.nombre," - ",ex.existencia) as articulo'),'articulo.idarticulo','ex.existencia as stock','articulo.costo')
				-> get(); 
         return response()->json($articulos);
     }     
      }
	    public function store (Request $request)
    {
		//dd($request);
		             //   try{
   // DB::beginTransaction();
		$ide=Auth::user()->idempresa;
		$user=Auth::user()->name;
        $categoria=new Traslado;
        $categoria->idempresa=$ide;
        $categoria->origen=$request->get('origen');
        $categoria->destino=$request->get('destino');
        $categoria->concepto=$request->get('concepto');
        $categoria->responsable=$request->get('responsable');
        $categoria->total_traslado=$request->get('totalo');
        $mytime=Carbon::now('America/Caracas');
		$categoria->fecha=$mytime->toDateTimeString();
        $categoria->user=$user;
        $categoria->save();

		 $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $costo = $request -> get('precio_compra');
		//	
		    $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleTraslado();
            $detalle->idtraslado=$categoria->idtraslado;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->precio=$costo[$cont];
            $detalle->save(); 
			
			$mov=DB::table('existencia')
			->where('id_almacen','=',$request->get('destino'))
			->where('idarticulo','=',$idarticulo[$cont])->first();
		//dd($mov);
			if($mov==NULL){
				  $exis=new Existencia();
				  $exis->idempresa=$ide;
				  $exis->id_almacen=$request->get('destino');
				  $exis->idarticulo=$idarticulo[$cont];
				  $exis->existencia=$cantidad[$cont];
				  $exisact=$exis->existencia;
				  $exis->save(); 
				  //dd($exis);
				  $mov=new Movimientos();
				  $mov->tipo="TRAS+";
				  $mov->deposito=$request->get('destino');
				  $mov->articulo=$idarticulo[$cont];
				  $mov->exisant= $exisact;
				  $mov->cnt= $cantidad[$cont];
				  $mov->existmov=$exis->existencia;
				  $mov->fecha=$mytime->toDateTimeString();
				  $mov->usuario=$user;
				  $mov->save(); 
				  $movd=DB::table('existencia')->where('id_almacen','=',$request->get('origen'))->where('idarticulo','=',$idarticulo[$cont])->first();
			    $idmovd=$movd->id;
				$venta=Existencia::findOrFail($idmovd);
				$exisact=$venta->existencia;
				$venta->existencia=($venta->existencia-$cantidad[$cont]);
				$venta->update(); 	
				
				$mov=new Movimientos();
				  $mov->tipo="TRAS-";
				  $mov->deposito=$request->get('origen');
				  $mov->articulo=$idarticulo[$cont];
				  $mov->exisant= $exisact;
				   $mov->cnt= $cantidad[$cont];
				  $mov->existmov=$venta->existencia;
				  $mov->fecha=$mytime->toDateTimeString();
				  $mov->usuario=$user;
				  $mov->save();
			}else{	
				$idmov=$mov->id;
				$compra=Existencia::findOrFail($idmov);
				$exisact=$compra->existencia;
				$compra->existencia=($compra->existencia+$cantidad[$cont]);
				$compra->update(); 
					
					$mov=new Movimientos();
				  $mov->tipo="TRAS+";
				  $mov->deposito=$request->get('destino');
				  $mov->articulo=$idarticulo[$cont];
				  $mov->exisant= $exisact;
				   $mov->cnt= $cantidad[$cont];
				  $mov->existmov=($compra->existencia);
				  $mov->fecha=$mytime->toDateTimeString();
				  $mov->usuario=$user;
				  $mov->save(); 
				  
			  $movd=DB::table('existencia')->where('id_almacen','=',$request->get('origen'))->where('idarticulo','=',$idarticulo[$cont])->first();
			    $idmovd=$movd->id;
				$venta=Existencia::findOrFail($idmovd);
				$exisact=$venta->existencia;
				$venta->existencia=($venta->existencia-$cantidad[$cont]);
			$venta->update(); 
			
			$mov=new Movimientos();
				  $mov->tipo="TRAS-";
				  $mov->deposito=$request->get('origen');
				  $mov->articulo=$idarticulo[$cont];
				  $mov->exisant= $exisact;
				   $mov->cnt= $cantidad[$cont];
				  $mov->existmov=($venta->existencia);
				  $mov->fecha=$mytime->toDateTimeString();
				  $mov->usuario=$user;
				  $mov->save();
			}
		    $cont=$cont+1;		
			}
	/*		DB::commit();
	}
	catch(\Exception $e)
	{
		DB::rollback();
	} */
        return Redirect::to('deposito/traslado');

    }
		  public function show($id){
  
    $pedido=DB::table('traslado as p')
            -> join ('depvendedor as d1','p.origen','=','d1.id_deposito')
			-> join ('depvendedor as d2','p.destino','=','d2.id_deposito')			
            -> select ('p.idempresa','p.idtraslado','d1.nombre as origen','d2.nombre as destino','p.concepto','p.responsable','p.total_traslado','p.fecha','p.user')
            ->where ('p.idtraslado','=',$id)		
            -> first();
	//dd($pedido);  
	$empresa=DB::table('empresa')-> where('idempresa','=',$pedido->idempresa)->first();
            $detalles=DB::table('detalle_traslado as da')
            -> join('articulo as a','a.idarticulo','=','da.idarticulo')
            -> select('a.nombre as articulo','da.cantidad','da.precio')
            -> where ('da.idtraslado','=',$id)
            ->get();
            return view("depositos.traslados.show",["venta"=>$pedido,"detalles"=>$detalles,"empresa"=>$empresa]);
}
}
