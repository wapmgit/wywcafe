<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Proovedor;
use sisventas\comprobante;
use sisventas\empresa;
use sisventas\ingreso;
use sisventas\Retenciones;
use sisventas\Gastos;
use sisventas\Movbanco;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\PacientesFormRequest;
use DB;
use Carbon\Carbon;
use Auth;
class CxpagarController extends Controller
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
			$proveedores=DB::table('ingreso as i')
			->join('proveedor as p','p.idproveedor','=','i.idproveedor')
			->select(DB::raw('SUM(i.saldo) as acumulado'),'p.nombre','p.rif','p.telefono','p.idproveedor')
			->where('p.nombre','LIKE','%'.$query.'%')
			->groupby('p.idproveedor')
			->where('i.saldo','>',0)
			->paginate(10);
			//
			$gastos=DB::table('gasto as g')
			->join('proveedor as p','p.idproveedor','=','g.idpersona')
			->select(DB::raw('SUM(g.saldo) as tpendiente'),'p.idproveedor','p.nombre','p.rif','p.telefono')
			->where('p.nombre','LIKE','%'.$query.'%')
			->groupby('p.idproveedor')
			->where('g.saldo','>',0)
			->where('g.estatus','=',0)
			->paginate(20);
			//dd($gastos);
			return view('proveedores.pagar.index',["proveedores"=>$proveedores,"gastos"=>$gastos,"searchText"=>$query]);
		}
	}
	public function show($historia)
	
	{
		$monedas=DB::table('monedas')->get();
				$retenc=DB::table('retenc')->get();
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$proveedor=Proovedor::findOrFail($historia);
			$datos=DB::table('ingreso as i')
			->join('proveedor as p','p.idproveedor','=','i.idproveedor')
			->select('i.total','p.idproveedor','i.retenido','i.tipo_comprobante','i.num_comprobante','i.serie_comprobante','i.fecha_hora','i.saldo','i.idingreso','i.base','i.miva','i.exento','i.tasa')
			->where('i.idproveedor','=',$historia)
			->where('i.saldo','>',0)
		   ->paginate(10);
		   	$gastos=DB::table('gasto as g')
			->join('proveedor as p','p.idproveedor','=','g.idpersona')
			->select('g.monto','p.idproveedor','g.documento','g.fecha','g.saldo','g.idgasto','')
			->where('g.idpersona','=',$historia)
			->where('g.saldo','>',0)
			->where('g.estatus','=',0)
		   ->paginate(10);
     return view('proveedores.pagar.show',["retenc"=>$retenc,"monedas"=>$monedas,"datos"=>$datos,"proveedor"=>$proveedor,"gastos"=>$gastos,"empresa"=>$empresa]);	
	}
	    public function store (Request $request)
    {
//dd($request);
// inserta el recibo-
$user=Auth::user()->name;
	$idcliente=explode("_",$request->get('proveedor'));
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
              while($contp < count($idpago)){
				$recibo=new comprobante;
			  if($request->get('tipop')==0){
				$recibo->idcompra=$request->get('venta');
			  }else{
				 $recibo->idgasto=$request->get('venta'); 
			  }
				$recibo->monto=$request->get('total_venta');
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
				$recibo->fecha_comp=$mytime->toDateTimeString();						
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
			if($request->get('tipop')==0){
				$mov->tipodoc="COMP";
			  }else{
				$mov->tipodoc="GAST";
			  }
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/D";
        $mov->numero=$pago[0]."-".$request->get('venta'); 
        $mov->concepto="Egreso ".$mov->tipodoc;
		$mov->tipo_per="P";
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
 if($request->get('tipop')==0){
	$ventaup=ingreso::findOrFail($request->get('venta'));
    $ventaup->saldo=($recibo->aux);
 $ventaup->update();}else{
	 	$ventaup=Gastos::findOrFail($request->get('venta'));
    $ventaup->saldo=($recibo->aux);
 $ventaup->update();
 }
return Redirect::to('proveedores/pagar');
    }
		public function edit($id){

	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $pago=DB::table('comprobante')
        -> where('idcompra','=',$id)->get();
		
    $ingreso=DB::table('ingreso as i')
            -> join ('proveedor as p','i.idproveedor','=','p.idproveedor')
            -> select ('i.idingreso','i.idproveedor','i.fecha_hora','i.total','p.nombre','rif','p.telefono','direccion','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.base','i.miva','i.exento','i.estatus')
            ->where ('i.idingreso','=',$id)
            -> first();

            $detalles=DB::table('detalle_ingreso as d')
            -> join('articulo as a','d.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.subtotal')
            -> where ('d.idingreso','=',$id)
            ->get();

            return view("proveedores.pagar.edit",["ingreso"=>$ingreso,"empresa"=>$empresa,"detalles"=>$detalles,"pago"=>$pago]);

	}
	public function cuentaspagar(Request $request)
	
	{
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();		
			$pacientes=DB::table('ingreso as i')
			->join('proveedor as p','p.idproveedor','=','i.idproveedor')
			->select('i.saldo as acumulado','i.tipo_comprobante','i.num_comprobante','i.fecha_hora','i.user','p.nombre','p.rif','p.telefono','p.direccion','p.contacto')
			->where('i.saldo','>',0)
			->where('i.estatus','<>',"Anulada")
			->orderby('p.nombre','ASC')
			->get();
			$gastos=DB::table('gasto as g')
			->join('proveedor as p','p.idproveedor','=','g.idpersona')
			->select('g.documento','g.saldo','g.usuario','g.fecha','g.usuario','p.idproveedor','p.nombre','p.rif','p.telefono','p.direccion','p.contacto')
			->groupby('p.idproveedor')
			->where('g.saldo','>',0)
			->where('g.estatus','=',0)
			->get(20);
			//dd($pacientes);
			return view('reportes.pagar.index',["pacientes"=>$pacientes,"gastos"=>$gastos,"empresa"=>$empresa]);
		}
		public function destroy(Request $request, $id){
					 $recibo=Comprobante::findOrFail($id);
					 if($request->get('tiporecibo')==0){
					$compra=$recibo->idcompra;}else{
					$compra=$recibo->idgasto;	
					 }
					 $monton=$recibo->monto;
					 $recibo->referencia='Anulado';
					 $recibo->monto='0,0';
					 $recibo->recibido='0,0';
					 $recibo->update();
			 if($request->get('tiporecibo')==0){
					 $ingreso=ingreso::findOrFail($compra);
					  $ingreso->saldo=($ingreso->saldo+$monton);
					 $ingreso->update();
				 $movimiento=DB::table('mov_ban')-> where('tipodoc','=','COMP')->where('iddocumento','=',$id)->first();
				$mov=Movbanco::findOrFail($movimiento->id_mov); 	
				$mov->estatus='1';
				$mov->update();
			 }else{
					 $ingreso=Gastos::findOrFail($compra);
					  $ingreso->saldo=($ingreso->saldo+$monton);
					 $ingreso->update(); 
				$movimiento=DB::table('mov_ban')-> where('tipodoc','=','GAST')->where('iddocumento','=',$id)->first();
				$mov=Movbanco::findOrFail($movimiento->id_mov); 	
				$mov->estatus='1';
				$mov->update();
			 }
	
					 return Redirect::to('reportes/pagos');
		}
				 public function pago(Request $request)
    {	
		$fac=$request->get('factura');
		$saldo=$request->get('saldo'); 
		$cont = 0;
        while($cont < count($fac)){
			$venta=Ingreso::findOrFail($fac[$cont]);
			$venta->saldo=0;	
			$venta->update();
				
				$recibo=new Comprobante;
				$recibo->idcompra=$fac[$cont];
				$recibo->monto=$saldo[$cont];
				$recibo->idpago=0;
				$recibo->idbanco="Dolares";
				$recibo->recibido=$saldo[$cont];;			 
				$recibo->referencia="";
				$recibo->tasap="";
				$recibo->tasab="";
				$recibo->aux=0;
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha_comp=$mytime->toDateTimeString();
				$recibo->save();
			$cont=$cont+1;
            } 
   return Redirect::to('proveedores/pagar');
 }
 
 public function retencion(Request $request)
    {	
	//
		$idret=explode("_",$request->get('idretenc'));
		$fac=$request->get('factura');
		$emp=empresa::findOrFail(1);
		if($idret[2]==1){$emp->corre_iva=$emp->corre_iva+1; $corre=$emp->corre_iva; }else{ $emp->corre_islr=$emp->corre_islr+1; $corre=$emp->corre_iva;}
		$emp->update();
		//dd($corre);
				$recibo=new Retenciones;
				$recibo->idingreso=$fac;
				$recibo->idproveedor=$request->get('idp');
				$recibo->documento=$request->get('docu');
				$recibo->retenc=$idret[0];
				$recibo->correlativo=$corre;
				$recibo->mfac=$request->get('mfac');
				$recibo->mbase=$request->get('mbase');
				$recibo->miva=$request->get('miva');
				$recibo->mexento=$request->get('mexen');
				$recibo->mret=$request->get('mret');
				$recibo->mretd=$request->get('mretd');
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->save();
		
			$venta=Ingreso::findOrFail($fac);
			$venta->saldo=($venta->saldo-$request->get('mretd'));
			$venta->retenido=($venta->retenido+$request->get('mretd'));
			//
			$venta->update();
			
   return Redirect::to('proveedores/pagar/'.$request->get('idp'));
 }
  public function retenciongas(Request $request)
    {	
	//
		$idret=explode("_",$request->get('idretencg'));
		$fac=$request->get('facturag');
	$emp=empresa::findOrFail(1);
		if($idret[2]==1){$emp->corre_iva=$emp->corre_iva+1; $corre=$emp->corre_iva; }else{ $emp->corre_islr=$emp->corre_islr+1; $corre=$emp->corre_islr;}
		$emp->update();
				$recibo=new Retenciones;
				$recibo->idgasto=$fac;
				$recibo->idproveedor=$request->get('idpg');
				$recibo->documento=$request->get('docug');
				$recibo->retenc=$idret[0];
				$recibo->correlativo=$corre;
				$recibo->mfac=$request->get('mfacg');
				$recibo->mbase=$request->get('mbaseg');
				$recibo->miva=$request->get('mivag');
				$recibo->mexento=$request->get('mexeng');
				$recibo->mret=$request->get('mretg');
				$recibo->mretd=$request->get('mretdg');
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->save();
		
			$venta=Gastos::findOrFail($fac);
			$venta->saldo=($venta->saldo-$request->get('mretdg'));
			$venta->retenido=($venta->retenido+$request->get('mretdg'));
			//dd($venta);
			$venta->update();
			dd($request->get('idpg'));
   return Redirect::to('proveedores/pagar/'.$request->get('idpg'));
 }
 	public function listaretenciones(Request $request)
	{
		if ($request)
		{			
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$query=trim($request->get('searchText'));
			$proveedores=DB::table('retenciones as i')
			->join('retenc','retenc.codigo','=','i.retenc')
			->join('proveedor as p','p.idproveedor','=','i.idproveedor')
			->where('p.nombre','LIKE','%'.$query.'%')
			->paginate(20);
			//dd($proveedores);
			return view('proveedores.retenciones.index',["empresa"=>$empresa,"proveedores"=>$proveedores,"searchText"=>$query]);
		}
	}
	 	public function verretencion($id)
	{	
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$data=explode("_",$id);
		if($data[1]==0){	
			$retencion=DB::table('retenciones as i')
			->join('retenc as rt','rt.codigo','=','i.retenc')
			->join('proveedor as p','p.idproveedor','=','i.idproveedor')
			->join('ingreso as in','in.idingreso','=','i.idingreso')
			->where('i.idretencion','=',$data[0])
			->first();}else{
			$retencion=DB::table('retenciones as i')
			->join('retenc as rt','rt.codigo','=','i.retenc')
			->join('proveedor as p','p.idproveedor','=','i.idproveedor')
			->join('gasto as in','in.idgasto','=','i.idgasto')
			->select('i.*','in.fecha as fecha_hora','p.nombre','p.rif','in.documento as num_comprobante','in.control as serie_comprobante','rt.ret','rt.afiva','rt.codtrib','rt.descrip','rt.sustraend')
			->where('i.idretencion','=',$data[0])
			->first();
			}

			return view('proveedores.retenciones.retencion',["empresa"=>$empresa,"retencion"=>$retencion]);
		
	}
	public function destroyretencion(Request $request){
				//dd($request);
		$idret=explode("_",$request->get('idret'));
		$emp=empresa::findOrFail(1);
		if($idret[1]==1){$emp->corre_iva=$emp->corre_iva-1; }else{ $emp->corre_islr=$emp->corre_islr-1; }
		$emp->update();
			$compra=Retenciones::findOrFail($idret[0]);
			$compra->anulada=1;
			$compra->update(); 
			//dd($compra->idingreso."abajo");
		$auxg=$compra->idgasto;
		$auxi=$compra->idingreso;
		if($auxg>0){			
			$venta=Gastos::findOrFail($auxg);
			$venta->saldo=($venta->saldo+$request->get('mretdg'));
			$venta->retenido=($venta->retenido-$compra->mretd);
			$venta->update();
		}
		if($auxi > 0){	
			$venta=ingreso::findOrFail($auxi);
			$venta->saldo=($venta->saldo+$compra->mretd);
			$venta->retenido=($venta->retenido-$compra->mretd);
			$venta->update();
		}			
		
					 return Redirect::to('cxp/listaretenciones');
		}
	public function ajustecorre(Request $request){
				
		$idret=explode("_",$request->get('idret'));
		$compra=Retenciones::findOrFail($idret[0]);
		$compra->correlativo=$request->get('ncorre');
		$compra->update(); 
			
		if($request->get('ajuste')=="on"){		
	$emp=empresa::findOrFail(1);
	//dd($request->get('ncorre'));
		if($idret[1]==1){$emp->corre_iva=$request->get('ncorre'); }else{ $emp->corre_islr=$request->get('ncorre'); }
		$emp->update();
		}				
					 return Redirect::to('cxp/listaretenciones');
		}
}
