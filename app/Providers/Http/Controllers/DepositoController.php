<?php

namespace sisventas\Http\Controllers;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Deposito;
use sisventas\Detalledeposito;
use sisventas\Almacenvacios;
use sisventas\Regdeposito;
use sisventas\Http\Requests\DepositoFormRequest;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;
use Carbon\Carbon;

class DepositoController extends Controller
{
  public function __construct()
    {
     
    }
	  public function index(Request $request)
    {

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

	 $nivel=Auth::user()->nivel;

            $query=trim($request->get('searchText'));
            $categorias=DB::table('deposito')->where('nombre','LIKE','%'.$query.'%')
            ->orderBy('id_deposito','asc')
            ->paginate(30);		
			$articulo=DB::table('articulo')-> where('vacio','=',1)->get();
			$cntvacios=DB::table('almacenvacios')
			->select(DB::raw('sum(entrada) as ingresos'),DB::raw('sum(salida) as egresos'))
			->first();
            return view('almacen.deposito.index',["cntvacios"=>$cntvacios,"articulo"=>$articulo,"categorias"=>$categorias,"searchText"=>$query]);
     
    }
	   public function create()
    {
		$q1=DB::table('clientes')->select('id_cliente as id','nombre','cedula as cedula','idbanco as tipoc');
        $q2=DB::table('proveedor')->select('idproveedor as id','nombre','rif as cedula','idbanco as tipoc');
		$clientes= $q1->union($q2)->get();   
		return view('almacen.deposito.create',["clientes"=>$clientes]);

    }

	    public function store (DepositoFormRequest $request)
    {

		 $idcliente=explode("_",$request->get('nombre'));
        $categoria=new Deposito;
        $categoria->nombre=$idcliente[1];
        $categoria->identificacion=$idcliente[0];
        $categoria->tipo_p=$idcliente[2];
        $categoria->id_persona=$idcliente[3];
        $categoria->save();
        return Redirect::to('almacen/deposito');

    }
	   public function edit($id)
    {
        return view("almacen.deposito.edit",["categoria"=>deposito::findOrFail($id)]);
    }
	  public function update(DepositoFormRequest $request,$id)
    {
        $categoria=Deposito::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('almacen/deposito');
    }
			   public function show($id)
    {
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$deposito=DB::table('deposito')-> where('id_deposito','=',$id)->first();
		$movimiento=DB::table('detalledeposito')
		->join('deposito','deposito.id_deposito','=','detalledeposito.idregistro')
		->join('articulo','articulo.idarticulo','=','detalledeposito.idarticulo')
		->where('idregistro','=',$id)
		->orderBy('iddetalle','asc')
		->get();

		return view('almacen.deposito.show',["movimiento"=>$movimiento,"empresa"=>$empresa,"deposito"=>$deposito]);
		
	}
				   public function gestion($id)
    {
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$deposito=DB::table('deposito')-> where('id_deposito','=',$id)->first();
		$movimientoin=DB::table('detalledeposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
         -> select(DB::raw('sum(de.cantidad) as cntagg'),'de.tipo','de.tiporeg','de.idarticulo','de.idregistro','articulo.nombre')
			->where('de.idregistro','=',$id)
			->where('de.tipo','=',1)
			->where('de.tiporeg','=',1)
			-> groupby('de.tiporeg','de.idarticulo','de.idregistro')
            ->get();
		$movimientoout=DB::table('detalledeposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
         -> select(DB::raw('sum(de.cantidad) as cntagg'),'de.tipo','de.tiporeg','de.idarticulo','de.idregistro','articulo.nombre')
			->where('de.idregistro','=',$id)
			->where('de.tipo','=',1)
			->where('de.tiporeg','=',2)
			-> groupby('de.tiporeg','de.idarticulo','de.idregistro')
            ->get();
					$deboin=DB::table('detalledeposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
         -> select(DB::raw('sum(de.cantidad) as cntagg'),'de.tipo','de.tiporeg','de.idarticulo','de.idregistro','articulo.nombre')
			->where('de.idregistro','=',$id)
			->where('de.tipo','=',2)
			->where('de.tiporeg','=',1)
			-> groupby('de.tiporeg','de.idarticulo','de.idregistro')
            ->get();
		$deboout=DB::table('detalledeposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
         -> select(DB::raw('sum(de.cantidad) as cntagg'),'de.tipo','de.tiporeg','de.idarticulo','de.idregistro','articulo.nombre')
			->where('de.idregistro','=',$id)
			->where('de.tipo','=',2)
			->where('de.tiporeg','=',2)
			-> groupby('de.tiporeg','de.idarticulo','de.idregistro')
            ->get();
			$articulo=DB::table('detalledeposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')->where('idregistro','=',$id)
		->where('de.tipo','=',1)
		-> groupby('de.idarticulo')
            ->get();
		$articulout=DB::table('detalledeposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')->where('idregistro','=',$id)
		->where('de.tipo','=',2)
		-> groupby('de.idarticulo')
            ->get();
			$articulov=DB::table('articulo')-> where('vacio','=',1)->get();

		return view('almacen.deposito.gestion',["articulout"=>$articulout,"deboin"=>$deboin,"deboout"=>$deboout,"articulov"=>$articulov,"articulo"=>$articulo,"movimientoout"=>$movimientoout,"movimientoin"=>$movimientoin,"empresa"=>$empresa,"deposito"=>$deposito]);
		
	}
		    public function aggdebe(Request $request)
    { 
	    $categoria=Deposito::findOrFail($request->get('idreg'));
        $categoria->debe=$categoria->debe+$request->get('cantidad');
        $categoria->update();
	$user=Auth::user()->name;
	$registro=new Detalledeposito;
    $registro->idregistro=$request->get('idreg');
    $registro->tipo=1;
	$registro->tiporeg=1;
	 $registro->idarticulo=$request->get('idarticulo');
	$registro->cantidad=$request->get('cantidad');
	$mytime=Carbon::now('America/Caracas');
    $registro->fecha=$mytime->toDateTimeString();
	$registro->usuario=$user;
	$registro->save();
	$mov=DB::table('reg_deposito')->where('deposito','=',$request->get('idreg'))
	->where('idarticulo','=',$request->get('idarticulo'))
	->first();
				if($mov==NULL){
					$reg=new Regdeposito;
					$reg->deposito=$request->get('idreg');
					$reg->idarticulo=$request->get('idarticulo');
					$reg->debe=$request->get('cantidad');
					$reg->save();
					 }
					else { 
					$idmov=$mov->idreg; 
					$compra=Regdeposito::findOrFail($idmov);
					$compra->debe=($compra->debe+$request->get('cantidad'));
					$compra->update();
					}
					$ing=new Almacenvacios;
					$ing->entrada=0;
					$ing->salida=$request->get('cantidad');
					$ing->idarticulo=$request->get('idarticulo');
					$ing->concepto="Entrega ".$request->get('idreg');
					$ing->responsable=$user;
					$mytime=Carbon::now('America/Caracas');
					$ing->fecha=$mytime->toDateTimeString();	
					$ing->save();
	 return Redirect::to('almacen/deposito/gestion/'.$request->get('idreg'));
	}
			    public function aggdebo(Request $request)
    { 
	     $categoria=Deposito::findOrFail($request->get('idreg'));
        $categoria->debo=$categoria->debo+$request->get('cantidad');
        $categoria->update();
	$user=Auth::user()->name;
	$registro=new Detalledeposito;
    $registro->idregistro=$request->get('idreg');
    $registro->tipo=2;
	$registro->tiporeg=1;
	 $registro->idarticulo=$request->get('idarticulo');
	$registro->cantidad=$request->get('cantidad');
	$mytime=Carbon::now('America/Caracas');
    $registro->fecha=$mytime->toDateTimeString();
	$registro->usuario=$user;
	$registro->save();
		$mov=DB::table('reg_deposito')->where('deposito','=',$request->get('idreg'))
		->where('idarticulo','=',$request->get('idarticulo'))
		->first();
				if($mov==NULL){
					$reg=new Regdeposito;
					$reg->deposito=$request->get('idreg');
					$reg->idarticulo=$request->get('idarticulo');
					$reg->debo=$request->get('cantidad');
					$reg->save();
					 } else { 
					$idmov=$mov->idreg; 
					$compra=Regdeposito::findOrFail($idmov);
					$compra->debo=($compra->debo+$request->get('cantidad'));
					$compra->update();
					}
					$ing=new Almacenvacios;
					$ing->entrada=$request->get('cantidad');
					$ing->salida=0;
					$ing->idarticulo=$request->get('idarticulo');
					$ing->concepto="Recepcion ".$request->get('idreg');
					$ing->responsable=$user;
					$mytime=Carbon::now('America/Caracas');
					$ing->fecha=$mytime->toDateTimeString();	
					$ing->save();
	 return Redirect::to('almacen/deposito/gestion/'.$request->get('idreg'));
	}
			    public function recepdebe(Request $request)
    { 

	     $categoria=Deposito::findOrFail($request->get('idreg'));
        $categoria->debe=$categoria->debe-$request->get('cantidad');
        $categoria->update();
	$user=Auth::user()->name;
	$registro=new Detalledeposito;
    $registro->idregistro=$request->get('idreg');
    $registro->tipo=1;
	$registro->tiporeg=2; 
	$registro->idarticulo=$request->get('idarticulo');
	$registro->cantidad=$request->get('cantidad');
	$mytime=Carbon::now('America/Caracas');
    $registro->fecha=$mytime->toDateTimeString();
	$registro->usuario=$user;
	$registro->save();

	$mov=DB::table('reg_deposito')->where('deposito','=',$request->get('idreg'))->where('idarticulo','=',$request->get('idarticulo'))->first();
					$idmov=$mov->idreg; 
					$compra=Regdeposito::findOrFail($idmov);
					$compra->debe=($compra->debe-$request->get('cantidad'));
					$compra->update();
						$ing=new Almacenvacios;
						$ing->entrada=$request->get('cantidad');
						$ing->salida=0;
						$ing->idarticulo=$request->get('idarticulo');
						$ing->concepto="Recepcion ".$request->get('idreg');
						$ing->responsable=$user;
						$mytime=Carbon::now('America/Caracas');
						$ing->fecha=$mytime->toDateTimeString();	
						$ing->save();			
	 return Redirect::to('almacen/deposito/gestion/'.$request->get('idreg'));
	}
				    public function recepdebo(Request $request)
    { 
	     $categoria=Deposito::findOrFail($request->get('idreg'));
        $categoria->debo=$categoria->debo-$request->get('cantidad');
        $categoria->update();
	$user=Auth::user()->name;
	$registro=new Detalledeposito;
    $registro->idregistro=$request->get('idreg');
    $registro->tipo=2;
	$registro->tiporeg=2;
	 $registro->idarticulo=$request->get('idarticulo');
	$registro->cantidad=$request->get('cantidad');
	$mytime=Carbon::now('America/Caracas');
    $registro->fecha=$mytime->toDateTimeString();
	$registro->usuario=$user;
	$registro->save();
		$mov=DB::table('reg_deposito')->where('deposito','=',$request->get('idreg'))->where('idarticulo','=',$request->get('idarticulo'))->first();
					$idmov=$mov->idreg; 
					$compra=Regdeposito::findOrFail($idmov);
					$compra->debo=($compra->debo-$request->get('cantidad'));
					$compra->update();
					$ing=new Almacenvacios;
					$ing->entrada=0;
					$ing->salida=$request->get('cantidad');
					$ing->idarticulo=$request->get('idarticulo');
					$ing->concepto="Entrega ".$request->get('idreg');
					$ing->responsable=$user;
					$mytime=Carbon::now('America/Caracas');
					$ing->fecha=$mytime->toDateTimeString();	
					$ing->save();
	 return Redirect::to('almacen/deposito/gestion/'.$request->get('idreg'));
	}
	public function regalmacen (Request $request){
	$user=Auth::user()->name;
	$registro=new Almacenvacios;
	if($request->get('tipo')==1){
	    $registro->entrada=$request->get('cantidad');	
	}else{
		$registro->salida=$request->get('cantidad');		
	}
	 $registro->idarticulo=$request->get('idarticulo');
	$registro->concepto=$request->get('concepto');
	$mytime=Carbon::now('America/Caracas');
    $registro->fecha=$mytime->toDateTimeString();
	$registro->responsable=$user;
	$registro->save();
	return Redirect::to('deposito/deposito');
	} 

	   public function deposito()
    {
		$articulo=DB::table('articulo')-> where('vacio','=',1)->get();
		$movvacios=DB::table('almacenvacios as alm')->join('articulo as art','art.idarticulo','=','alm.idarticulo')
		->orderby('alm.idregistro','DESC')
		->get();
		$cntvacios=DB::table('almacenvacios as alm')->join('articulo as art','art.idarticulo','=','alm.idarticulo')
		->select(DB::raw('sum(alm.entrada) as ingresos'),DB::raw('sum(alm.salida) as egresos'),'art.nombre')
		->groupby('alm.idarticulo')
		->get();
	//	dd($cntvacios);
		return view('almacen.deposito.deposito',["cntvacios"=>$cntvacios,"articulo"=>$articulo,"movvacios"=>$movvacios]);

    }

}
