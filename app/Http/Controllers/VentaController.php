<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Recibo;
use sisventas\Venta;
use sisventas\Ventaf;
use sisventas\Relacionnc;
use sisventas\devolucion;
use sisventas\Existencia;
use sisventas\Detalledevolucion;
use sisventas\Detalleimportar;
use sisventas\Articulo;
use sisventas\Formalibre;
use sisventas\Mov_notas;
use sisventas\Kardex;
use sisventas\Notasadm;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ventaFormRequest;
use DB;
use sisventas\Pacientes;
use sisventas\Movbanco;
use sisventas\DetalleVenta;
use sisventas\DetalleVentaf;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;
use Auth;

class VentaController extends Controller
{
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
		$ide=Auth::user()->idempresa;
        if ($request)
        {
			$rol=DB::table('roles')-> select('crearventa','anularventa')->where('iduser','=',$request->user()->id)->first();
			   $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
			if ($request->get('busca')){
				$busca=$request->get('busca');				
			}else{
				$busca="p.nombre";
			}
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> join ('detalle_venta as dv','v.idventa','=','dv.idventa')
            -> select ('v.forma','v.idventa','v.fecha_hora','p.nombre','v.forma','v.formato','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.devolu','v.estado','v.total_venta','v.user','ve.nombre as vendedor')
            ->where('v.idempresa','=',$ide)	
			-> where ($busca,'LIKE','%'.$query.'%')
            -> orderBy('v.idventa','desc')
            -> groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
                ->paginate(50);
     
     return view ('ventas.venta.index',["rol"=>$rol,"ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
    public function create(Request $request){
		
		$ide=Auth::user()->idempresa;
		$nivel=Auth::user()->nivel;
		  $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		if($nivel=="A"){
		$monedas=DB::table('monedas')->where('idempresa','=',$ide)->get();
		$rutas=DB::table('rutas')->where('idempresa','=',$ide)->get();
		$vendedor=DB::table('vendedores')->where('idempresa','=',$ide)->where('estatus','=',1)->get();      
        $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev','clientes.licencia')
		->where('clientes.idempresa','=',$ide)
		-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select(DB::raw('count(num_comprobante) as idventa'))->where('idempresa','=',$ide)->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')->join('categoria','categoria.idcategoria','=','art.idcategoria')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2','art.iva','categoria.licor','art.fraccion')
        ->where('art.idempresa','=',$ide)
		-> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
		//dd($articulos);
     if ($contador==""){$contador=0;}
		}else{
			$idvende=Auth::user()->vendedor;
		$rutas=DB::table('rutas')->where('idempresa','=',$ide)->get();
		$monedas=DB::table('monedas')-> where('idempresa','=',$ide)->get();
		$personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev','clientes.licencia')-> where('clientes.idempresa','=',$ide)-> where('clientes.vendedor','=',$idvende)-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
		 $vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->where('id_vendedor','=',$idvende)->where('estatus','=',1)->get(); 
			//dd($contador);
       $articulos =DB::table('articulo as art')->join('categoria','categoria.idcategoria','=','art.idcategoria')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2','art.iva','categoria.licor','art.fraccion')
        ->where('art.idempresa','=',$ide)
		-> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
        //dd($articulos);
		if ($contador==""){$contador=0;}
		}
      return view("ventas.venta.create",["nivel"=>$nivel,"rutas"=>$rutas,"personas"=>$personas,"articulos"=>$articulos,"monedas"=>$monedas,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
    }
    public function store(Request $request){
		$ide=Auth::user()->idempresa;
	 $modo=DB::table('empresa')->select('modop')-> where('idempresa','=',$ide)->first();
	
		$user=Auth::user()->name;
		$nivel=Auth::user()->nivel;
 /* try{
  DB::beginTransaction();*/
   $contador=DB::table('venta')->select(DB::raw('count(num_comprobante) as idventa'))-> where('idempresa','=',$ide)->limit('1')->orderby('idventa','desc')->first();
   if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}
//dd($request);
//registra la venta
    $venta=new Venta;
	$idcliente=explode("_",$request->get('id_cliente'));
    $venta->idcliente=$idcliente[0];
    $venta->idempresa=$ide;
    $venta->tipo_comprobante=$request->get('tipo_comprobante');
    $venta->serie_comprobante=$request->get('serie_comprobante');
    $venta->num_comprobante=($numero+1);
    $venta->total_venta=$request->get('total_venta');
	$venta->total_iva=$request->get('total_iva');
    $mytime=Carbon::now('America/Caracas');
    $venta->fecha_hora=$mytime->toDateTimeString();
	$venta->fecha_emi=$request->get('fecha_emi');
	$venta->fecha_fac=$request->get('fecha_emi');
	$venta->lastrecargo=$request->get('fecha_emi');
	$venta->fechahora=$mytime->toDateTimeString();
    $venta->impuesto='16';
		if(($request->get('tdeuda')==0)and($request->get('convertir')=="on")){
			$venta->forma=1;
			if($request->get('formato')=="on"){
			$venta->formato=1;}else{	$venta->formato=0;}
			}
		
	$venta->tasa=$request->get('tc');
	$venta->mcosto=$request->get('totalc');
	$venta->mivaf=$request->get('total_ivaf');
	$venta->texe=$request->get('totalexe');
	if(empty($request->get('tdeuda'))){   $venta->saldo=$request->get('total_venta');}
	else { $venta->saldo=$request->get('tdeuda');}	
    if ($venta->saldo > 0){
    $venta->estado='Credito';} else { $venta->estado='Contado';}
    $venta->devolu='0';
	 $venta->idvendedor=$request->get('nvendedor');
    $venta->diascre=$request->get('diascre');
    $venta->comision=$request->get('comision');
	$venta->montocomision=($request->get('total_venta')*($request->get('comision')/100));
	$venta->user=$user;	
   $venta-> save();
  // dd($venta);
  $dep=DB::table('depvendedor')->select('id_deposito','idvendedor')
            ->where('idvendedor','=',$request->get('nvendedor'))
            ->where('idempresa','=',$ide)		
            ->first();
		if(($request->get('tdeuda')==0)and($request->get('convertir')=="on")){
			//inserto la forma libre
			   $contador=DB::table('ventaf')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
				if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}
			
			$ventaf=new Ventaf;
			$idcliente=explode("_",$request->get('id_cliente'));
			$ventaf->idcliente=$idcliente[0];
			$ventaf->tipo_comprobante=$request->get('tipo_comprobante');
			$ventaf->serie_comprobante=$request->get('serie_comprobante');
			$ventaf->pedido=$venta->idventa;
			$ventaf->num_comprobante=($numero+1);
			$ventaf->total_venta=$request->get('total_venta');
			$ventaf->total_iva=$request->get('total_iva');
			$mytime=Carbon::now('America/Caracas');
			$ventaf->fecha_hora=$mytime->toDateTimeString();
			$ventaf->fecha_emi=$request->get('fecha_emi');
			$ventaf->fecha_fac=$request->get('fecha_emi');
			$ventaf->impuesto='16';
			$ventaf->forma=1;
			if($request->get('formato')=="on"){
			$ventaf->formato=1;}else{	$venta->formato=0;}	
			$ventaf->tasa=$request->get('tc');
			$ventaf->mcosto=$request->get('totalc');
			$ventaf->mivaf=$request->get('total_ivaf');
			$ventaf->texe=$request->get('totalexe');
			$ventaf->saldo=$request->get('total_venta');
			//$ventaf->pedido=$venta->idventa;
			$ventaf->estado='Contado';
			$ventaf->devolu='0';
			$ventaf->idvendedor=$request->get('nvendedor');
			$ventaf->diascre=$request->get('diascre');
			$ventaf->comision=$request->get('comision');
			$ventaf->comision=$request->get('comision');
			$ventaf->montocomision=($request->get('total_venta')*($request->get('comision')/100));
			$ventaf->user=$user;
			$ventaf-> save();
			//
			$pnro=DB::table('formalibre')
			->select(DB::raw('MAX(idforma) as pnum'))
			->first();				
			$fl=new Formalibre;
			$fl->idventa=$ventaf->idventa;
			$fl->nrocontrol=($pnro->pnum+7101);
			$fl->save();
		}
    // inserta el recibo
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
		   $flicor=0;
		   if($request->get('totala')>0){
              while($contp < count($idpago)){
				$recibo=new Recibo;
				$recibo->idempresa=$ide;
				$recibo->idventa=$venta->idventa;
				if($request->get('tdeuda')>0){
				$recibo->tiporecibo='A'; }else{$recibo->tiporecibo='P'; }
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$pago[0];
				$recibo->idnota=0;
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$recibo->fecha=$mytime->toDateTimeString();		
				$recibo->usuario=$user;					
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
        $mov->idempresa=$ide;
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/C";
		$mov->tipodoc="VENT";
        $mov->numero=$pago[0]."-".$request->get('serie_comprobante');
        $mov->concepto="Ingreso Ventas";
		$mov->tipo_per="C";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[5];
        $mov->nombre=$idcliente[6];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=$tmonto[$contp];
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=Auth::user()->name;
        $mov->save();
				 $contp=$contp+1;
			  }  
		   }
		    
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $descuento = $request -> get('descuento');
        $precio = $request -> get('precio');
        $precio_venta = $request -> get('precio_venta');
        $costoarticulo = $request -> get('costoarticulo');
        $eslicor = $request -> get('eslicor');
			if($request->get('convertir')=="on"){
				$cont = 0; 
					while($cont < count($idarticulo)){
					$detalle=new DetalleVentaf();
					$detalle->idventa=$ventaf->idventa;
					$detalle->idarticulo=$idarticulo[$cont];
					$detalle->costoarticulo=$costoarticulo[$cont];
					$detalle->cantidad=$cantidad[$cont];
					$detalle->descuento=$descuento[$cont];
					$detalle->precio_venta=$precio_venta[$cont];
					 $detalle->fecha_emi=$request->get('fecha_emi');	
					$detalle->save();
					$cont=$cont+1;
					}	
				}
        $cont = 0;  $mcomi=0; $mcomiv=0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleVenta();
            $detalle->idventa=$venta->idventa;
            $detalle->idempresa=$ide;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->costoarticulo=$costoarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio=$precio[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
			 $detalle->fecha_emi=$request->get('fecha_emi');	
			 $detalle->fechahora=$mytime->toDateTimeString();	
            $detalle->save();
			$articulo=Articulo::findOrFail($idarticulo[$cont]);
			$stock=$articulo->stock;
			$articulo->stock=$articulo->stock-$cantidad[$cont];
			
		$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="VENT-".($numero+1);
		$kar->idarticulo=$idarticulo[$cont];
		$kar->cantidad=$cantidad[$cont];
		$kar->exis_ant=$stock;
		$kar->costo=$costoarticulo[$cont];
		$kar->tipo=2; 
		$kar->user=$user;
		 $kar->save();  
			 $deposito=DB::table('existencia')->select('id')
            ->where('idempresa','=',$ide)
            ->where('id_almacen','=',$dep->id_deposito)		
            ->where('idarticulo','=',$idarticulo[$cont])		
            ->first();
					$exis=Existencia::findOrFail($deposito->id);
					$exis->existencia=($exis->existencia-$cantidad[$cont]);
					$exis->update();
                      //actualizo stock   
		//cimision 
					
				$mcomi=$mcomi+(($cantidad[$cont]*$precio_venta[$cont])*($articulo->pcomision/100)); 
				$mcomiv=$mcomiv+(($cantidad[$cont]*$precio_venta[$cont])*($request->get('comision')/100));
//				
        $articulo->update();
		if($eslicor[$cont]==1){
			$flicor=1;
		}
            $cont=$cont+1;
            }
		
		$cli=Pacientes::findOrFail($idcliente[0]);
        $cli->ultventa=$mytime->toDateTimeString();
        $cli->update();
				$actv=Venta::findOrFail($venta->idventa);
					if($modo->modop==0){
						$actv->montocomision=$mcomiv;	
					}else{
						$actv->montocomision=$mcomi;	
					}      
				$actv->licor=$flicor;			
				$actv->update();
//de la nota de credito
	if($request->get('apcnc')=="on"){
			 	$mov=new Mov_notas;
				$mov->tipodoc="FAC";
				$mov->iddoc=$venta->idventa;
				$mov->monto=$request->get('montonc');
				$mov->referencia="Aplicada en Ventas";
				$mytime=Carbon::now('America/Caracas');
				$mov->fecha=$mytime->toDateTimeString();
				$mov->user=Auth::user()->name;
				$mov->save();	
				$nc=DB::table('notasadm as da')
				-> select('da.idnota as not','da.pendiente')
				-> where ('da.tipo','=',2)
				-> where ('da.idcliente','=',$venta->idcliente)
				-> where ('da.pendiente','>',0)
				->get();	
			$longitud = count($nc);
			$array = array();
			foreach($nc as $t){
			$arrayidnota[] = $t->not;
			}
			$abono=$request->get('montonc');
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
				DB::commit();
/* }
catch(\Exception $e)
{
    DB::rollback();
}*/
If ($request->get('convertir')=="on"){
  return Redirect::to('ventas/formalibre/'.$venta->idventa.'_'.$venta->formato);
	}
else{
	if($nivel=="A"){
	return Redirect::to('ventas/venta/'.$venta->idventa); }else{
	return Redirect::to('ventas/recibo/'.$venta->idventa);	
	}
}
}
public function formal($id){
//dd($id);
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$data=explode("_",$id);
			$id=$data[0];
			$tipo=$data[1];
			
			$venta=DB::table('ventaf as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join('formalibre as fl','fl.idventa','=','v.idventa')
            -> select ('v.pedido','v.pedido','p.id_cliente','v.idventa','fl.idforma','v.tasa','v.mivaf','v.fecha_fac as fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
			->where ('v.pedido','=',$id)
            ->where ('fl.anulado','=',0)
            -> first();
		//dd($id);
            $detalles=DB::table('detalle_ventaf as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.origen','a.volumen','a.grados','a.nombre as articulo','a.codigo','dv.costoarticulo as costo','a.iva','a.unidad','dv.cantidad','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$venta->idventa)
			->orderBy('a.nombre','asc')
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
			->orderby('idrecibo','des')
            ->first();


			//dd($vacios);
			if($tipo==1){
				//	dd($tipo);
            return view("ventas.venta.formalibre1",["venta"=>$venta,"recibo"=>$recibo,"empresa"=>$empresa,"detalles"=>$detalles]);
			}else{
			return view("ventas.venta.formalibre",["venta"=>$venta,"recibo"=>$recibo,"empresa"=>$empresa,"detalles"=>$detalles]);
			}
			}
public function indimportar(Request $request)
    {
		//dd($request);
		$mesact= date("Y-m");
		$inimes=$mesact."-01";
		//dd($inimes);
		$fecha='2021-05';
$nuevafecha = strtotime('-1 months', strtotime($inimes));
$nuevafecha = date('Y-m-d' , $nuevafecha);
//dd($nuevafecha);
		  $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev')
		  -> where('clientes.status','=','A')->where('clientes.licencia','!=',"")->groupby('clientes.id_cliente')->get();
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> join ('detalle_venta as dv','v.idventa','=','dv.idventa')
            -> select ('v.mcosto','v.mivaf','v.texe','v.idventa','v.fecha_hora','p.nombre','v.forma','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.devolu','v.estado','v.total_venta','v.user','ve.nombre as vendedor')
            -> where ('v.tipo_comprobante','=','FAC')
            -> where ('v.forma','=','0')
            -> where ('v.devolu','=','0')
            -> where ('v.idcomision','>','0')
			->where ('v.fecha_emi','>=',$nuevafecha)
            -> orderBy('v.total_venta','desc')
            -> groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
             ->get();
     //dd($ventas);
     return view ('ventas.venta.indeximportar',["ventas"=>$ventas,"empresa"=>$empresa,"personas"=>$personas]);
        
    }  
public function pnota(Request $request)
    {	
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			//dd($request);
			$licor=0;
	$user=Auth::user()->name;
	$idnota=$request -> get('notas');
	$cont = 0;
		while($cont < count($idnota)){
			
		$venta=Venta::findOrFail($idnota[$cont]);
		if($venta->licor==1){$licor=1;}
		$venta->devolu='1';
		$venta->saldo='0';
		$venta->update();
	
			$devolucion=new Devolucion;
			$devolucion->idventa=$idnota[$cont];
			$devolucion->comprobante=$venta->num_comprobante;
			$mytime=Carbon::now('America/Lima');
			$devolucion->fecha_hora=$mytime->toDateTimeString();
			$devolucion->user=$user;
			$devolucion-> save();
			
				$detalles=DB::table('detalle_venta as da')
				-> select('da.idarticulo as cod','da.cantidad as cant','da.costoarticulo as costo','da.precio_venta as precio')
				-> where ('da.idventa','=',$idnota[$cont])
				->get();
			
				$longitud = count($detalles);		
			//dd();
					for ($i=0;$i<$longitud;$i++){
						$detalle=new Detalledevolucion();
						$detalle->iddevolucion=$devolucion->iddevolucion;
						$detalle->idarticulo=$detalles[$i]->cod;
						$detalle->cantidad=$detalles[$i]->cant;
						$detalle->costoarticulo=$detalles[$i]->costo;
						$detalle->descuento=1;
						$detalle->precio_venta=$detalles[$i]->precio;
						$detalle->save();
				
							$articulo=Articulo::findOrFail($detalles[$i]->cod);
							$articulo->stock=($articulo->stock+$detalles[$i]->cant);
							$articulo->update();
								$kar=new Kardex;
								$kar->fecha=$mytime->toDateTimeString();
								$kar->documento="DEV:V-".$venta->num_comprobante;
								$kar->idarticulo=$detalles[$i]->cod;
								$kar->cantidad=$detalles[$i]->cant;
								$kar->costo=$detalles[$i]->costo;
								$kar->tipo=1; 
								$kar->user=$user;
								$kar->save();
								
				}
									
					//	for ($l=0;$l<$longitud;$l++){
					//			echo $arraycod[$l];
					//unset($arraycod[$l]);			
				//	unset($arraycan[$l]);			
				//	unset($arraycto[$l]);			
				//	unset($arraypv[$l]);			
				//	}
			//	dd($arraycod[0]);
			 $cont=$cont+1;
				
		}							
				$contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
				if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}

				$venta=new Venta;
				$idcliente=explode("_",$request->get('id_cliente'));
				$venta->idcliente=$idcliente[0];
				$venta->tipo_comprobante="FAC";
				$venta->serie_comprobante="NE00";
				$venta->num_comprobante=($numero+1);
				$venta->total_venta=($request->get('tdoc')/$request->get('tasa'));
				$venta->total_iva=$request->get('tiva');
				$mytime=Carbon::now('America/Caracas');
				$venta->fecha_hora=$mytime->toDateTimeString();
				$venta->fecha_emi=$request->get('fecha_emi');
				$venta->fecha_fac=$request->get('fecha_emi');
				$venta->impuesto='16';
				$venta->impuesto=$licor;
				$venta->forma=1;
				$venta->formato=1;
				$venta->tasa=$request->get('tasa');
				$venta->mcosto=(($request->get('tdoc')-($request->get('tiva')+$request->get('texe')))/$request->get('tasa'));
				$venta->mivaf=$request->get('tiva');
				$venta->texe=$request->get('texe');
				$venta->saldo=0;	
				$venta->estado='Contado';
				$venta->devolu='0';
				 $venta->idvendedor=1;
				$venta->diascre=0;
				$venta->comision=0;
				$venta->montocomision=0;
				$venta->user=$user;
		
			   $venta-> save();
					$pnro=DB::table('formalibre')
					->select(DB::raw('MAX(idforma) as pnum'))
					->first();				
					$fl=new Formalibre;
					$fl->idventa=$venta->idventa;
					$fl->nrocontrol=($pnro->pnum+7001);
					$fl->save();
					
				$deta=DB::table('detalle_devolucion as dd')
				->join('articulo as art','art.idarticulo','=','dd.idarticulo')
				-> select('art.iva','dd.idarticulo as cod',DB::raw('SUM(dd.cantidad) as tcnt'),DB::raw('AVG(dd.costoarticulo) as tcto'),DB::raw('AVG(dd.precio_venta) as tpv'))
				-> where ('dd.descuento','=',1)
				->groupby('dd.idarticulo')
				->get();
				
				$long= count($deta);
				$reg=$long;
				$array = array();
					foreach($deta as $t){
					$arraycod[] = $t->cod;
					$arraycan[] = $t->tcnt;
					$arraycto[] = $t->tcto;
					$arraypv[] = $t->tpv;				
					if($t->iva > 0){
					$arrayinpv[]=( $t->tcto);
					}else{ $arrayinpv[]=($t->tpv);}
					}
						for ($j=0;$j<$long;$j++){
							$detalle=new DetalleVenta();
							$detalle->idventa=$venta->idventa;
							$detalle->idarticulo=$arraycod[$j];
							$detalle->costoarticulo=($arraycto[$j]);
							$detalle->cantidad=$arraycan[$j];
							$detalle->descuento=0;
							$detalle->precio_venta=($arrayinpv[$j]);
							 $detalle->fecha_emi=$request->get('fecha_emi');	
							$detalle->save();
								$kar=new Kardex;
							$kar->fecha=$mytime->toDateTimeString();
							$kar->documento="VENT-".($numero+1);
							$kar->idarticulo=$arraycod[$j];
							$kar->cantidad=$arraycan[$j];
							$kar->costo=($arraycto[$j]);
							$kar->tipo=2; 
							$kar->user=$user;
							$kar->save();  
									  //actualizo stock   
							$articulo=Articulo::findOrFail($arraycod[$j]);
							$articulo->stock=$articulo->stock-$arraycan[$j];
							$articulo->update();
									
							$cont=$cont+1;
						}
				$devo=DB::table('detalle_devolucion as dd')
				-> select('dd.iddetalle_devolucion as id')
				-> where ('dd.descuento','=',1)
				->get();
				$ld = count($devo);
				$array = array();
					foreach($devo as $t){
					$arrayid[] = $t->id;
					}
					for ($k=0;$k<$ld;$k++){							
						$devs=Detalledevolucion::findOrFail($arrayid[$k]);
						$devs->descuento=0;
						$devs->update();
					}

		
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$venta->idventa)
			->orderby('idrecibo','des')
            ->first();	
	
			  return Redirect::to('ventas/formalibre/'.$venta->idventa.'_1');
			
						// return view("ventas.venta.formalibre1",["venta"=>$venta,"recibo"=>$recibo,"empresa"=>$empresa,"detalles"=>$detalle]);
	}
public function show(Request $request,$id){
			$ide=Auth::user()->idempresa;
			$nivel=Auth::user()->nivel;
			if($nivel=="A"){ $ruta="/ventas/venta";}else{ $ruta="/ventas/ventacaja"; }
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('rutas as r','r.idruta','=','p.ruta')
            -> join ('vendedores as vend','vend.id_vendedor','=','v.idvendedor')
            -> select ('r.nombre as nruta','vend.nombre as vendedor','p.id_cliente','v.idventa','v.saldo','v.fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu','v.diascre','p.recargo')
            ->where ('v.idventa','=',$id)
            -> first();
		
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
              -> select('a.nombre as articulo','dv.precio','dv.cantidad','dv.descuento','dv.precio_venta','dv.idarticulo')
            -> where ('dv.idventa','=',$id)
			->orderBy('a.nombre','asc')
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$id)-> where ('mov.tipodoc','=',"FAC")
            ->get();
			//M
		$cxc=DB::table('venta as ve')
		 -> join ('clientes as p','ve.idcliente','=','p.id_cliente')
         -> select(DB::raw('sum(ve.saldo) as saldo'))
		 ->where('ve.devolu','=',0)
		 ->where('ve.tipo_comprobante','=',"FAC")
		 ->where('ve.idcliente','=',$venta->id_cliente)
		-> groupby('ve.idcliente')->first();
		if($cxc==NULL){ $cxc=0;  }else { $cxc=$cxc->saldo;  }
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'))
			->where('not.tipo','=',1)
			->where('not.pendiente','>',0)
			->where('not.idcliente','=',$venta->id_cliente)			
			->groupby('not.idcliente')
			->first();
		if($notasnd==NULL){ $notasnd=0;  }else { $notasnd=$notasnd->tnotas;  }
			//dd($notasnd);
				$notasnc=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'))
			->where('not.tipo','=',2)
			->where('not.pendiente','>',0)
			->where('not.idcliente','=',$venta->id_cliente)
			->groupby('not.idcliente')
			->first();
				if($notasnc==NULL){ $notasnc=0;  }else { $notasnc=$notasnc->tnotas;  }
//dd($notasnc);

           $vacios=DB::table('deposito')->where('id_persona','=',$venta->id_cliente)
		   ->select('debe')
            ->first();	
			//dd($vacios);
            return view("ventas.venta.show",["ruta"=>$ruta,"vacios"=>$vacios,"notasnc"=>$notasnc,"notasnd"=>$notasnd,"cxc"=>$cxc,"venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);
}
public function ver(Request $request, $id){
	$ide=Auth::user()->idempresa;
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('v.idventa','v.fecha_emi','p.nombre','p.cedula','p.direccion','p.licencia','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu','v.descuento')
            ->where ('v.idventa','=',$id)
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$id)-> where ('mov.tipodoc','=',"FAC")
            ->get();

            return view("ventas.venta.recibo",["venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);
}
 public function edit(Request $request, $idcliente){
	// dd($request);
	 $ide=Auth::user()->idempresa;
	     $monedas=DB::table('monedas')-> where('idempresa','=',$ide)->get();
		 $rutas=DB::table('rutas')-> where('idempresa','=',$ide)->get();
	     $vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->get();
	     $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
		->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev','clientes.licencia')
		-> where ('clientes.id_cliente','=',$idcliente)
		->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select(DB::raw('count(num_comprobante) as idventa'))-> where('idempresa','=',$ide)->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
         $articulos =DB::table('articulo as art')->join('categoria','categoria.idcategoria','=','art.idcategoria')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2','art.iva','categoria.licor','art.fraccion')
        -> where('art.estado','=','Activo')
		-> where('art.idempresa','=',$ide)
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
     return view("ventas.venta.create",["rutas"=>$rutas,"personas"=>$personas,"monedas"=>$monedas,"articulos"=>$articulos,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
 }

public function destroy($id){

    $venta=Venta::findOrFail($id);
    $venta->estado='C';
    $venta->update();
    return Redirect::to('ventas/venta');
}
public function devolucion(){
   $id=2;
   // $id=$request->get('id');
//dd($id);
    $venta=Venta::findOrFail($id);
    $venta->impuesto='16';
    $venta->update();
  return Redirect::to('ventas/venta');
}
 public function almacena(Request $request)
    {
		$ide=Auth::user()->idempresa;
     if($request->ajax()){
	
		 $paciente=new Pacientes;
        $paciente->idempresa=$ide;
        $paciente->nombre=$request->get('cnombre');
        $paciente->cedula=$request->get('ccedula');
        $paciente->codpais=$request->get('ccodpais');
        $paciente->telefono=$request->get('ctelefono');
        $paciente->status='A';
	 if($request->get('cdireccion')==""){
		 $paciente->direccion="Sin especificfar";
		}else{
		$paciente->direccion=$request->get('cdireccion');}
        $paciente->tipo_cliente=$request->get('ctipo_cliente');
        $paciente->tipo_precio=$request->get('cprecio');
        $paciente->licencia=$request->get('licencia');
        $paciente->diascre=$request->get('diascre');
		$paciente->recargo=$request->get('recargo');
		 $paciente->vendedor=$request->get('idvendedor');
		 $paciente->ruta=$request->get('ruta');
		  $mytime=Carbon::now('America/Caracas');
		$paciente->creado=$mytime->toDateTimeString();
        $paciente->save();
	// dd($paciente);
 $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.nombre','clientes.diascre','clientes.cedula','clientes.tipo_cliente','vendedores.comision','vendedores.id_vendedor as nombrev')->where('clientes.idempresa','=',$ide)->where('clientes.cedula','=',$request->get('ccedula'))->get();
           return response()->json($personas);
 }
    }
	 public function ventacaja(Request $request)
    {
		
		$ide=Auth::user()->idempresa;
		$monedas=DB::table('monedas')->where('idempresa','=',$ide)->get();
	
        if ($request)
        {
			$corteHoy = date("Y-m-d");
			$user=Auth::user()->name;
			   $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('detalle_venta as dv','v.idventa','=','dv.idventa')
            -> select ('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.devolu','v.estado','v.total_venta')		
			->where('v.user','=',$user)
			 ->where('v.fecha_emi','like',$corteHoy)
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orderBy('v.idventa','desc')
            -> groupBy('v.idventa')
                ->paginate(50);
     return view ('ventas.venta.ventacaja',["ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
	 public function refrescar(Request $request)
    {
		if($request->ajax()){
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
           return response()->json($articulos);
		}
    }
	    public function ventasf(Request $request)
    {
        if ($request)
        {
		//	dd($request);
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
            //$query2 = date_create($query2);  
	
          //  date_add($query2, date_interval_create_from_date_string('1 day'));
         //   $query2=date_format($query2, 'Y-m-d');
         //datos venta	

            $datos=DB::table('venta as v')
			->join('formalibre as fl','fl.idventa','=','v.idventa')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.idventa','c.direccion','c.telefono','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.tasa','v.fecha_fac as fecha_hora','v.fecha_emi','v.saldo','v.devolu','v.formato','v.user','fl.nrocontrol','fl.anulado','fl.idForma','v.formato','v.mivaf','v.texe','v.mcosto','v.total_iva')
			-> whereBetween('v.fecha_fac', [$query, $query2])
			-> groupby('fl.nrocontrol')
            ->get(); 
	  //$query2=date("Y-m-d",strtotime($query2."- 1 days"));
        return view('reportes.ventasf.index',["datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
       
  }
  
}
	    public function recargos(Request $request)
    {
        if ($request)
        {
			 $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$fechadia = date("Y-m-d");
			
			$corteHoy = date("2025-06-30");
            $datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select(DB::raw('DATEDIFF(curdate(),v.lastrecargo) as dias'),'v.diascre','v.idventa','c.id_cliente','c.nombre','v.tipo_comprobante','v.num_comprobante','v.total_venta','v.lastrecargo','v.fecha_emi','v.saldo','v.user')			
			->where('c.recargo','=',1)
			->where('v.tipo_comprobante','=',"FAC")
			->where('v.saldo','>',0)
			->where('v.devolu','=',0)
			->where('v.fecha_emi','>',$corteHoy)
			->get();
			//dd($datos);
			 $longitudc = count($datos);
					for ($i=0;$i<$longitudc;$i++){				
						if ($datos[$i]->dias <= $datos[$i]->diascre){
							unset($datos[$i]);				
						}
					}
		//	dd($datos); 
        return view('ventas.venta.recargos',["datos"=>$datos,"empresa"=>$empresa]);
       
  }
  
}
	    public function addrecargos(Request $request)
    {
        if ($request)
        {
			$user=Auth::user()->name;
			$doc=$request->get('documento');
			$iddoc=$request->get('iddoc');
			$cliente=$request->get('cliente');
			$tventa=$request->get('tventa');
			$tnota=$request->get('tnota');
			$cont=0;
			while($cont < count($cliente)){ 
				$paciente=new Notasadm;
				$paciente->tipo=1;
				$paciente->idcliente=$cliente[$cont];
				$paciente->descripcion="Recargo ".$doc[$cont];
				$paciente->referencia="R:".$iddoc[$cont]."(".$tventa[$cont].")";
				$paciente->monto=$tnota[$cont];
				$mytime=Carbon::now('America/Caracas');
				$paciente->fecha=$mytime->toDateTimeString();
				$paciente->pendiente=$tnota[$cont];
				$paciente->usuario=Auth::user()->name;
				$paciente->save();
	$venta=Venta::findOrFail($iddoc[$cont]);
    $venta->lastrecargo=$mytime->toDateTimeString();;
    $venta->update();
	
				$cont=$cont+1;
			}
        return Redirect::to('ventas/recargo');       
	}
  }

}
