<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Pacientes;
use sisventas\Recibo;
use sisventas\Articulo;
use sisventas\Venta;
use sisventas\Notasadm;
use sisventas\Relacionnc;
use sisventas\Mov_notas;
use sisventas\Movbanco;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\PacientesFormRequest;
use DB;
use Carbon\Carbon;
use Auth;
class CxcobrarController extends Controller
{
    public function __construct()
	{
$this->middleware('auth');
	}

	public function index(Request $request)
	{

		if ($request)
		{
			$query=trim($request->get('searchText'));
			$pacientes=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','c.vendedor')
			->select(DB::raw('SUM(v.saldo) as acumulado'),'c.nombre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('c.nombre','LIKE','%'.$query.'%')
			->where('v.tipo_comprobante','=','FAC')
			->where('v.saldo','>',0)
			->groupby('c.id_cliente')
			->paginate(20);
			//dd($pacientes);
			$notas=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'not.tipo','c.id_cliente')
			->where('c.nombre','LIKE','%'.$query.'%')
			->groupby('c.id_cliente','not.tipo')
			->where('not.pendiente','>',0)
			->paginate(20);
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			//->join('venta as v','v.idcliente','=','c.id_cliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'not.tipo','c.id_cliente','c.nombre','c.cedula','c.telefono')
			//->where('v.saldo','=',0)
			->where('not.tipo','=',1)
			->where('not.pendiente','>',0)
			->where('c.nombre','LIKE','%'.$query.'%')			
			->groupby('c.id_cliente')
			->paginate(20);
			//dd($notasnd);
			return view('pacientes.cobrar.index',["pacientes"=>$pacientes,"notas"=>$notas,"notasnd"=>$notasnd,"searchText"=>$query]);
		}
	}
	 public function detallesxcobrar($historia)
	{
         
           
       //     ->get();
      //  return view('reportes.compras.index',["datos"=>$datos,"searchText"=>$query);
			
	}

	public function show($historia)
	
	{
			$monedas=DB::table('monedas')->get();
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$cliente=Pacientes::findOrFail($historia);
			$datos=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->select('v.total_venta','c.id_cliente','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.fecha_hora','v.fecha_emi','v.saldo','v.idventa')
			->where('v.idcliente','=',$historia)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.saldo','>',0)
		   ->get();
		   	$notas=DB::table('notasadm as not')
			->select('not.pendiente','not.descripcion','not.monto','not.fecha','not.idnota','not.referencia')
			->where('not.idcliente','=',$historia)
			->where('not.pendiente','>',0)
			->where('not.tipo','=',1)
			->get();
			$notasc=DB::table('notasadm as not')
			->select(DB::raw('sum(not.pendiente) as montonc'))
			->where('not.idcliente','=',$historia)
			->where('not.pendiente','>',0)
			->where('not.tipo','=',2)
			->first();
		//	dd($notas);
     return view('pacientes.cobrar.show',["datos"=>$datos,"notas"=>$notas,"notasc"=>$notasc,"cliente"=>$cliente,"monedas"=>$monedas,"empresa"=>$empresa]);	
	}
    public function store (Request $request)
    {
		//dd($request);
		$tipodoc=$request->get('tipodoc');
		$user=Auth::user()->name;
		$idcliente=explode("_",$request->get('cliente'));
		//dd($tipodoc);
		if($tipodoc==1){
 // inserta el recibo
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $fpago=$request->get('fpago');
           $tref=$request->get('tref');		 
           $contp=0;
             while($contp < count($idpago)){
				$recibo=new Recibo;
				$recibo->idventa=$request->get('venta');
				if($request->get('tdeuda')>0){
				$recibo->tiporecibo='A'; }else{$recibo->tiporecibo='A'; }
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$pago[0];
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$recibo->fecha=$fpago[$contp]; 
				$recibo->usuario=$user;				
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/C";
		$mov->tipodoc="VENT";
        $mov->numero=$pago[0]."-C".$request->get('venta');
        $mov->concepto="Cobranza Ventas";
		$mov->tipo_per="C";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[1];
        $mov->nombre=$idcliente[2];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=0;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=$user;
        $mov->save();
				$contp=$contp+1;
			  } 
				$ventaup=venta::findOrFail($request->get('venta'));
				$ventaup->saldo=($recibo->aux);
				$ventaup->update();
		}
				if($tipodoc==2){
			// inserta el recibo
			//dd($request->get('venta'));
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
             while($contp < count($idpago)){
				$recibo=new Recibo;
				$recibo->idventa=0;
				$recibo->idnota=$request->get('venta');
				if($request->get('tdeuda')>0){
				$recibo->tiporecibo='A'; }else{$recibo->tiporecibo='A'; }
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$pago[0];
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$mytime=Carbon::now('America/Caracas');
				$recibo->fecha=$mytime->toDateTimeString();	
				$recibo->usuario=$user;					
				$recibo->save();
				
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/C";
		$mov->tipodoc="N/DA";
        $mov->numero=$pago[0]."-C".$request->get('venta');
        $mov->concepto="Cobranza N/D";
		$mov->tipo_per="C";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[1];
        $mov->nombre=$idcliente[2];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=0;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=$user;
        $mov->save();
		
		$contp=$contp+1;
			  } 
				$ventaup=notasadm::findOrFail($request->get('venta'));
				$ventaup->pendiente=$request->get('tdeuda');
				$ventaup->update();
		}
return Redirect::to('pacientes/cobrar/'.$request->get('cliente'));
    }
	
	public function edit($id){
	
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            ->where ('v.idventa','=',$id)
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.idarticulo','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            ->get();
            $articulos=DB::table('articulo')-> where('estado','=','Activo')->get();
			$abonos=DB::table('recibos')-> where('idventa','=',$id)->get();
          //  dd($articulos);
  return view("pacientes.cobrar.edit",["venta"=>$venta,"empresa"=>$empresa,"detalles"=>$detalles,"articulos"=>$articulos,"abonos"=>$abonos]);

	}
	
	public function update(PacientesFormRequest $request, $historia)
	{
      $paciente=Pacientes::findOrFail($historia);
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('cedula');
        $paciente->telefono=$request->get('telefono');
    	$paciente->direccion=$request->get('direccion');
    	$paciente->tipo_cliente=$request->get('tipo_cliente');
        $paciente->tipo_precio=$request->get('precio');
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
	public function destroy()
	{
        $paciente=Pacientes::findOrFail($id_cliente);
        $paciente->status='I';
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
	public function cuentascobrar(Request $request)	
	{	
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();		
		$vendedores=DB::table('vendedores')->get();  
			if($request->get('vendedor')==NULL){
				$aux=0;
			$pacientes=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			-> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
			->select('v.saldo as acumulado','v.idventa as tipo_comprobante','serie_comprobante','num_comprobante','v.fecha_emi as fecha_hora','v.user','c.nombre','c.diascre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('v.saldo','>',0)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->orderby('c.nombre','ASC');

			$q2=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select('n.pendiente as acumulado',DB::raw('CONCAT("N/D","-",n.tipo ) as serie_comprobante'),'idnota as num_comprobante','n.referencia as num_comprobante','n.fecha as fecha_hora','n.usuario as user','c.nombre','n.usuario as vendedor','c.diascre','c.cedula','c.telefono','c.id_cliente')->where('n.tipo','=',1)->where('n.pendiente','>',0);
			$clientes= $pacientes->union($q2)->get(); 
			//dd($clientes);
			$cuenta=DB::table('vendedores as v')->get();
			$notasnd=DB::table('vendedores as v')->get();
		

			
			}else{
			$aux=0;
				$clientes=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','c.vendedor')
			->select('v.saldo as acumulado','v.idventa as tipo_comprobante','serie_comprobante','v.num_comprobante','v.fecha_emi as fecha_hora','v.user','c.nombre','c.diascre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('v.idvendedor','=',$request->get('vendedor'))
			->where('v.saldo','>',0)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->orderby('c.nombre','ASC')	
			->get();
			$cuenta=DB::table('vendedores as v')->get();
			$notasnd=DB::table('vendedores as v')->get();
		
			if($request->get('resumen')=="on"){
			$aux=1;
			$cuenta=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','c.vendedor')
			->select(DB::raw('sum(v.saldo) as acumulado'),'c.nombre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('v.idvendedor','=',$request->get('vendedor'))
			->where('v.saldo','>',0)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->groupby('v.idcliente')
			->orderby('c.nombre','ASC')	
			->get();
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'c.id_cliente')
			->where('not.tipo','=',1)
			->where('not.pendiente','>',0)			
			->groupby('c.id_cliente')
			->get();
			}
			}
			
			return view('reportes.cobrar.index',["cuenta"=>$cuenta,"notasnd"=>$notasnd,"auxiliar"=>$aux,"pacientes"=>$clientes,"vendedores"=>$vendedores,"empresa"=>$empresa]);
		}
	public function aplicanc(Request $request)
	{
		if($request->get('tipo')=="N/D"){
			 $notas=Notasadm::findOrFail($request->get('iddoc'));
			 $notas->pendiente=($notas->pendiente-$request->get('total_abn'));
			 $notas->update();
			 	$mov=new Mov_notas;
				$mov->tipodoc="N/D";
				$mov->iddoc=$request->get('iddoc');
				$mov->monto=$request->get('total_abn');
				$mytime=Carbon::now('America/Caracas');
				$mov->fecha=$mytime->toDateTimeString();
				$mov->user=Auth::user()->name;
				$mov->save();
				$nc=DB::table('notasadm as da')
				-> select('da.idnota as not','da.pendiente')
				-> where ('da.tipo','=',2)
				-> where ('da.idcliente','=',$request->get('idcliente'))
				-> where ('da.pendiente','>',0)
				->get();	
			$longitud = count($nc);
			$array = array();
			foreach($nc as $t){
			$arrayidnota[] = $t->not;
			}
			$abono=$request->get('total_abn');
				for ($i=0;$i<$longitud;$i++){
					$bajanota=Notasadm::findOrFail($arrayidnota[$i]);
					$montonc=$bajanota->pendiente;
						if($montonc>$abono){
						$bajanota->pendiente=($bajanota->pendiente-$abono);}else{
						$bajanota->pendiente=0; $abono=($abono-$montonc);
						}
					$bajanota->update();
					$rnc=new Relacionnc;
				$rnc->idmov=$mov->id_mov;
				$rnc->idnota=$arrayidnota[$i];
				$rnc->save();	
				}	
				}
			if($request->get('tipo')=="FAC"){
			 $notas=Venta::findOrFail($request->get('iddoc'));
			 $notas->saldo=($notas->saldo-$request->get('total_abn'));
			 $notas->update();
			 	$mov=new Mov_notas;
				$mov->tipodoc="FAC";
				$mov->iddoc=$request->get('iddoc');
				$mov->monto=$request->get('total_abn');
				$mytime=Carbon::now('America/Caracas');
				$mov->fecha=$mytime->toDateTimeString();
				$mov->user=Auth::user()->name;
				$mov->save();	
				$nc=DB::table('notasadm as da')
				-> select('da.idnota as not','da.pendiente')
				-> where ('da.tipo','=',2)
				-> where ('da.idcliente','=',$request->get('idcliente'))
				-> where ('da.pendiente','>',0)
				->get();	
			$longitud = count($nc);
			$array = array();
			foreach($nc as $t){
			$arrayidnota[] = $t->not;
			}
			$abono=$request->get('total_abn');
				for ($i=0;$i<$longitud;$i++){
					$bajanota=Notasadm::findOrFail($arrayidnota[$i]);
					$montonc=$bajanota->pendiente;
						if($montonc>$abono){
						$bajanota->pendiente=round(($bajanota->pendiente-$abono),2);}else{
						$bajanota->pendiente=0; $abono=($abono-$montonc);
						}
					$bajanota->update();
				$rnc=new Relacionnc;
				$rnc->idmov=$mov->id_mov;
				$rnc->idnota=$arrayidnota[$i];
				$rnc->save();	
				}	
				}
				 return Redirect::to('pacientes/cobrar/');
	}
		 public function pago(Request $request)
    {	
		$moneda=explode("_",$request->get('pidpagomodal'));
		$fac=$request->get('factura');
		$saldo=$request->get('saldo'); 
		$cont = 0;
        while($cont < count($fac)){
			$venta=Venta::findOrFail($fac[$cont]);
			$venta->saldo=0;	
			$venta->update();
				
				$recibo=new Recibo;
				$recibo->idventa=$fac[$cont];
				$recibo->tiporecibo="A";
				$recibo->idnota=0;
				$recibo->monto=$saldo[$cont];
				$recibo->idpago=$moneda[0];
				$recibo->idbanco=$moneda[1];
				$recibo->recibido=$saldo[$cont];			 
				$recibo->referencia="";
				$recibo->tasap="";
				$recibo->tasab="";
				$recibo->aux=0;
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->save();
			$cont=$cont+1;
            } 
   return Redirect::to('pacientes/cobrar');
 }
 		 public function pagond(Request $request)
    {	
		$moneda=explode("_",$request->get('pidpagomodaln'));
		$fac=$request->get('nota');
		$saldo=$request->get('pendiente'); 
		$cont = 0;
        while($cont < count($fac)){
			$venta=Notasadm::findOrFail($fac[$cont]);
			$venta->pendiente=0;	
			$venta->update();
				
				$recibo=new Recibo;
				$recibo->idventa=0;
				$recibo->tiporecibo="A";
				$recibo->idnota=$fac[$cont];
				$recibo->monto=$saldo[$cont];
				$recibo->idpago=$moneda[0];
				$recibo->idbanco=$moneda[1];
				$recibo->recibido=$saldo[$cont];;			 
				$recibo->referencia="";
				$recibo->tasap="";
				$recibo->tasab="";
				$recibo->aux=0;
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->save();
			$cont=$cont+1;
            } 
   return Redirect::to('pacientes/cobrar');
 }
}
