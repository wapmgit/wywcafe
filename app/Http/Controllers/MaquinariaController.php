<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use sisventas\Maquinaria;
use sisventas\comprobante;
use sisventas\Movbanco;
use Carbon\Carbon;
use DB;
use Auth;

class MaquinariaController extends Controller
{
    public function __construct()
    {
     
    }
	public function index(Request $request)
    {
		$ide=Auth::user()->idempresa;
		   $query=trim($request->get('searchText'));
		$data=DB::table('depmaquina')->where('nombre','LIKE','%'.$query.'%')
			-> where('idempresa','=',$ide)
            ->orderBy('nombre','asc')
            ->paginate(10);
		return view("produccion.maquina.index",["data"=>$data,"searchText"=>$query]);
		
	}
	public function create()
    {
        return view("produccion.maquina.create");
    }
	public function store (Request $request)
    {
		//dd($request);
		$ide=Auth::user()->idempresa;
        $categoria=new Maquinaria;
        $categoria->nombre=$request->get('nombre');
        $categoria->idempresa=$ide;
        $categoria->marca=$request->get('marca');
		$categoria->serie=$request->get('serie');
		$categoria->tipo=$request->get('tipo');
		$categoria->capacidad=$request->get('capacidad');
        $categoria->save();
        return Redirect::to('produccion/maquina');

	}
	public function edit($id)
    {
        return view("produccion.maquina.edit",["categoria"=>Maquinaria::findOrFail($id)]);
    }
	public function update(Request $request,$id)
    {		
        $categoria=Maquinaria::findOrFail($id);
		$categoria->nombre=$request->get('nombre');
        $categoria->marca=$request->get('marca');
		$categoria->serie=$request->get('serie');
		$categoria->tipo=$request->get('tipo');
		$categoria->capacidad=$request->get('capacidad');
        $categoria->update();
        return Redirect::to('produccion/maquina');
    }
	public function show($id)    
    { 
        $tosta=Maquinaria::findOrFail($id);
		$empresa=DB::table('empresa')-> where('idempresa','=',$tosta->idempresa)->first();
		$monedas=DB::table('monedas')->where('idempresa','=',$tosta->idempresa)->get();
        $produccion=DB::table('ptostado as a')
            -> join('articulo as art','art.idarticulo','=','a.idmprima')
            -> select ('a.*','art.nombre')
            ->where ('a.idmaquina','=',$id)
            ->orderBy('a.idt','desc')
            ->get();
    $pago=DB::table('comprobante')
        -> where('idmaquina','=',$id)->get();
      return view("produccion.maquina.show",["pago"=>$pago,"monedas"=>$monedas,"tosta"=>$tosta,"produccion"=>$produccion,"empresa"=>$empresa]);
    }
		public function pagar (Request $request)
    {

	$tost=Maquinaria::findOrFail($request->get('proveedor'));
    $tost->pendiente=($request->get('tdeuda')/$request->get('tipop'));
	$tost->update();
// inserta el recibo-
	$ide=Auth::user()->idempresa;
	$user=Auth::user()->name;
			$idcliente=$request->get('proveedor');
			$idpago=$request->get('tidpago');
			$idbanco=$request->get('tidbanco');
			$denomina=$request->get('denominacion');
			$tmonto=$request->get('tmonto');
		    $fpago=$request->get('fpago');
           $tref=$request->get('tref');		 
           $contp=0;
              while($contp < count($idpago)){
				$recibo=new comprobante;
				$recibo->idmaquina=$request->get('proveedor'); 
				$recibo->idempresa=$ide;
				$recibo->idpago=$idpago[$contp];
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$mytime=Carbon::now('America/Caracas');
				$recibo->fecha_comp=$fpago[$contp]; 						
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
		$mov->tipodoc=0;	
		$mov->iddocumento=0;
        $mov->idempresa=$ide;
        $mov->tipo_mov="N/D";
        $mov->numero=$pago[0]."-".$recibo->idrecibo; 
        $mov->concepto="Egre. Produccion";
		$mov->tipo_per="T";
        $mov->idbeneficiario="";
		$mov->identificacion="";
        $mov->nombre=$tost->nombre;
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=$tmonto[$contp]; 
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$fpago[$contp]; 
        $mov->user=Auth::user()->name;
        $mov->save();
				$contp=$contp+1;
			  } 
return Redirect::to('produccion/maquina/'.$tost->iddep);
    }
}
