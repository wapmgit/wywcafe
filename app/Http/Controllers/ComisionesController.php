<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use DB;
use sisventas\Venta;
use sisventas\Comisiones;
use sisventas\Movbanco;
use sisventas\recibo_comision;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Redirect;
class ComisionesController extends Controller
{
	public function __construct()
	{
$this->middleware('auth');
	}
	 public function index(Request $request)
    {
        if ($request)
        {
	
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> select (DB::raw('sum(v.total_venta) as monto'),DB::raw('sum(v.montocomision) as montocomision'),'ve.id_vendedor','ve.nombre','ve.telefono')
			->where('v.idempresa','=',$ide)
			-> where ('v.devolu','=',0)
			 -> where ('v.saldo','=',0)
			  -> where ('v.idcomision','=',0)
            -> where ('ve.nombre','LIKE','%'.$query.'%')
            -> groupBy('v.idvendedor')
			->paginate(50);
     //dd($ventas);
     return view ('comisiones.comision.index',["ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
	public function show(Request $request, $id){
			$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$rol=DB::table('roles')-> select('comision')->where('iduser','=',$request->user()->id)->first();
	$vendedor=DB::table('vendedores')-> where('id_vendedor','=',$id)->first();

			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> select ('v.idventa','v.fecha_hora','v.fecha_emi','v.diascre','p.nombre','p.cedula','v.comision','v.montocomision','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
			->where('v.idempresa','=',$ide)           	
			-> where ('v.devolu','=',0)
			 -> where ('v.saldo','=',0)
			 -> where ('v.idcomision','=',0)
		   ->where ('v.idvendedor','=',$id)
            ->get();
			
			$recibos=DB::table('venta as v')
			->join('recibos as r','r.idventa','=','v.idventa')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
			-> where ('v.idcomision','=',0)
			-> where ('v.saldo','=',0)
			-> where ('v.devolu','=',0)
			-> where ('r.aux','=',0)			
			->where ('v.idvendedor','=',$id)
			->where('r.idempresa','=',$ide)
            -> select ('r.idventa','r.fecha')  
			->orderby('r.fecha','asc')
		  // ->groupby('r.idventa')
            ->get();
			//dd($recibos);
			$regla=DB::table('reglacomision')->get();
            return view("comisiones.comision.show",["rol"=>$rol,"regla"=>$regla,"recibos"=>$recibos,"venta"=>$venta,"vendedor"=>$vendedor,"empresa"=>$empresa]);
}
  public function update(Request $request){
	
	$user=Auth::user()->name;      
	$venta=new Comisiones;
    $venta->id_vendedor=$request->get('vendedor');
    $venta->montoventas=$request->get('mventas');
    $venta->montocomision=$request->get('mcomision');
	$venta->pendiente=$request->get('mcomision');
    $mytime=Carbon::now('America/Caracas');
    $venta->fecha=$mytime->toDateTimeString();
	$venta->usuario=$user;
   $venta-> save();
	        $idventa=$request->get('idventa');         
		   $contp=0;
              while($contp < count($idventa)){
		$paciente=Venta::findOrFail($idventa[$contp]);
		 $paciente->idcomision=$venta->id_comision;
		$paciente->update();
				 $contp=$contp+1;
			  }  
	return Redirect::to('/comisiones/comision/mostrar/'.$venta->id_comision);
  }
  	public function mostrar($id){
	$vendedor=DB::table('comision')-> join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('id_comision','=',$id)->first();
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> select ('v.idventa','v.fecha_hora','v.fecha_emi','p.nombre','p.cedula','ve.id_vendedor','v.comision','v.montocomision','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
           	 -> where ('v.idcomision','=',$id)
            ->get();
            return view("comisiones.comision.mostrar",["venta"=>$venta,"vendedor"=>$vendedor,"empresa"=>$empresa]);
}
  	public function comixpagar(request $request){
		$ide=Auth::user()->idempresa;
	$monedas=DB::table('monedas')-> where('idempresa','=',$ide)->get();
		$rol=DB::table('roles')-> select('pcomision')->where('iduser','=',$request->user()->id)->first();
	$vendedor=DB::table('comision')-> join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('comision.pendiente','>',0)->get();
	//dd($vendedor);
	$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            return view("comisiones.comision.xpagar",["rol"=>$rol,"monedas"=>$monedas,"vendedor"=>$vendedor,"empresa"=>$empresa]);
}
 	public function pagadas(Request $request){
		$ide=Auth::user()->idempresa;
		$query=trim($request->get('searchText'));
	$vendedor=DB::table('comision')-> join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('comision.pendiente','=',0)-> where ('vendedores.nombre','LIKE','%'.$query.'%')->orderBy('comision.fecha','DESC')->get();
	//dd($vendedor);
	$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            return view("comisiones.comision.pagadas",["vendedor"=>$vendedor,"empresa"=>$empresa,"searchText"=>$query]);
}
 	public function pagar(Request $request){
		//dd($request);
		$ide=Auth::user()->idempresa;
		$idcliente=explode("_",$request->get('vendedor'));
	$user=Auth::user()->name;      

			$idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
              while($contp < count($idpago)){
				$recibo=new recibo_comision;
				$recibo->id_comision=$request->get('comision');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idempresa=$ide;
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->aux=$request->get('tdeuda');
				$recibo->observacion=$request->get('observacion');
				$mytime=Carbon::now('America/Caracas');
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->user=$user;				
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
		$mov->tipodoc="COMI";	
		$mov->idempresa=$ide;	
		$mov->iddocumento=$recibo->id_recibo;
        $mov->tipo_mov="N/D";
        $mov->numero=$pago[0]."-".$request->get('comision'); 
        $mov->concepto="Egreso ".$mov->tipodoc;
		$mov->tipo_per="V";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[1];
        $mov->nombre=$idcliente[2];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=0;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=Auth::user()->name;
        $mov->save();
				$contp=$contp+1;
			  } 
	$venta=Comisiones::findOrFail($request->get('comision'));
    $venta->pendiente=($venta->pendiente-$request->get('totala'));
    $venta->update();
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		return Redirect::to('/comisiones/comision/recibo/'.$request->get('comision'));
}
  	public function ver_recibo(Request $request, $id){
		
		$ide=Auth::user()->idempresa;
		$fechahoy = date("Y-m-d");
	$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$datos=DB::table('recibo_comision as r')
            -> join ('comision as p','r.id_comision','=','p.id_comision')
			 -> join ('vendedores as ve','p.id_vendedor','=','ve.id_vendedor')
			  ->join('monedas as m','m.idmoneda','=','r.idbanco')
          -> select ('m.simbolo','ve.nombre','ve.cedula','p.montoventas','p.montocomision','p.fecha as fechacomision','p.id_comision','r.recibido','r.monto','r.referencia','r.fecha','r.user')
           	 -> where ('r.fecha','=',$fechahoy)
           	 -> where ('r.id_comision','=',$id)
            ->get();
			//dd($datos);
            return view("comisiones.comision.recibo",["datos"=>$datos,"empresa"=>$empresa]);
}
  	public function lista(Request $request, $id){
		$ide=Auth::user()->idempresa;
	$dato=explode("_",$id);
    $comision=$dato[0];
	$link=$dato[1];
	$comi=DB::table('comision')->join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('comision.id_comision','=',$comision)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$lista=DB::table('recibo_comision as r')
            -> join ('comision as p','r.id_comision','=','p.id_comision')
			 ->join('monedas as m','m.idmoneda','=','r.idbanco')
           	 -> where ('r.id_comision','=',$comision)
            ->get();
			
            return view("comisiones.comision.listarecibos",["comision"=>$comi,"lista"=>$lista,"empresa"=>$empresa,"link"=>$link]);
}
  	public function detallecomision($id){
		//dd($id);
	$vendedor=DB::table('comision')-> join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('id_comision','=',$id)->first();
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> select ('v.idventa','v.fecha_hora','v.fecha_emi','p.nombre','p.cedula','v.comision','v.montocomision','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu','v.diascre')
           	 -> where ('v.idcomision','=',$id)
            ->get();
			$recibos=DB::table('venta as v')
			->join('recibos as r','r.idventa','=','v.idventa')
            -> select ('r.idventa','r.fecha')  			
		   ->where ('v.idcomision','=',$id)
		   ->orderby('r.fecha','asc')
            ->get();
//dd($recibos);
			$regla=DB::table('reglacomision')->get();
            return view("comisiones.comision.detallecomision",["recibos"=>$recibos,"regla"=>$regla,"venta"=>$venta,"vendedor"=>$vendedor,"empresa"=>$empresa]);
}
}
