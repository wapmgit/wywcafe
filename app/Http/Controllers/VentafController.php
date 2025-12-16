<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Recibo;
use sisventas\Ventaf;
use sisventas\Venta;
use sisventas\Relacionnc;
use sisventas\devolucion;
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
use sisventas\DetalleVentaf;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;
use Auth;

class VentafController extends Controller
{
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {
			$rol=DB::table('roles')-> select('crearfl','importarfl','anularfl')->where('iduser','=',$request->user()->id)->first();
			   $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $ventas=DB::table('ventaf as v')
            -> join ('formalibre as fl','fl.idventa','=','v.idventa')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
            -> join ('detalle_ventaf as dv','v.idventa','=','dv.idventa')
            -> select ('v.idventa','v.fecha_fac as fecha_hora','p.nombre','v.forma','v.formato','v.tipo_comprobante','fl.nrocontrol as control','v.serie_comprobante','v.num_comprobante','v.impuesto','v.devolu','v.estado','v.total_venta','v.user','ve.nombre as vendedor')
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orwhere ('v.serie_comprobante','LIKE','%'.$query.'%')
            -> orderBy('v.fecha_fac','desc')
            -> groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
                ->paginate(20);
     
	 //dd($ventas);
     return view ('ventas.ventaf.index',["rol"=>$rol,"ventas"=>$ventas,"searchText"=>$query,"empresa"=>$empresa]);
        }
    } 
    public function create(){
		$monedas=DB::table('monedas')->get();
		$rutas=DB::table('rutas')->get();
		$vendedor=DB::table('vendedores')->where('estatus','=',1)->get();
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
		->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.diascre','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.id_vendedor as nombrev','clientes.licencia')
		-> where('clientes.status','=','A')
		->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')->join('categoria','categoria.idcategoria','=','art.idcategoria')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2','art.iva','categoria.licor')
        -> where('art.estado','=','Activo')
        ->groupby('articulo','art.idarticulo')
        -> get();
		//dd($personas);
     if ($contador==""){$contador=0;}
      return view("ventas.ventaf.create",["rutas"=>$rutas,"personas"=>$personas,"articulos"=>$articulos,"monedas"=>$monedas,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
    }
    public function store(ventaFormRequest $request){
	//	dd($request);
	 $modo=DB::table('empresa')->select('modop')-> where('idempresa','=','1')->first();
		$user=Auth::user()->name;
 //  try{
  // DB::beginTransaction();
   $contador=DB::table('ventaf')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
   if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}

//registra la venta
    $venta=new Ventaf;
	$idcliente=explode("_",$request->get('id_cliente'));
    $venta->idcliente=$idcliente[0];
    $venta->tipo_comprobante=$request->get('tipo_comprobante');
    $venta->serie_comprobante=$request->get('serie_comprobante');
    $venta->num_comprobante=($numero+1);
    $venta->total_venta=$request->get('total_venta');
	$venta->total_iva=$request->get('total_iva');
    $mytime=Carbon::now('America/Caracas');
    $venta->fecha_hora=$mytime->toDateTimeString();
	$venta->fecha_emi=$request->get('fecha_emi');
	$venta->fecha_fac=$request->get('fecha_emi');
    $venta->impuesto='16';
	$venta->forma=1;
			if($request->get('formato')=="on"){
			$venta->formato=1;}else{	$venta->formato=0;}	
	$venta->tasa=$request->get('tc');
	$venta->mcosto=$request->get('totalc');
	$venta->mivaf=$request->get('total_ivaf');
	$venta->texe=$request->get('totalexe');
	$venta->saldo=$request->get('total_venta');
	$venta->saldo=0;
	$venta->estado='Contado';
    $venta->devolu='0';
	$venta->idvendedor=$request->get('nvendedor');
    $venta->diascre=$request->get('diascre');
    $venta->comision=$request->get('comision');
	$venta->montocomision=($request->get('total_venta')*($request->get('comision')/100));
	$venta->user=$user;
   $venta-> save();
			$pnro=DB::table('formalibre')
			->select(DB::raw('MAX(idforma) as pnum'))
			->first();				
			$fl=new Formalibre;
			$fl->idventa=$venta->idventa;
			$fl->nrocontrol=($pnro->pnum+7001);
			$fl->save();
			
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $descuento = $request -> get('descuento');
        $precio_venta = $request -> get('precio_venta');
        $costoarticulo = $request -> get('costoarticulo');
        $eslicor = $request -> get('eslicor');

        $cont = 0;  $mcomi=0; $mcomiv=0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleVentaf();
            $detalle->idventa=$venta->idventa;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->costoarticulo=$costoarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
			 $detalle->fecha_emi=$request->get('fecha_emi');	
            $detalle->save();
            $cont=$cont+1;
            }	
/*	DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}*/
 return Redirect::to('ventasf/formalibre/'.$venta->idventa.'_'.$venta->formato);
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
            -> select ('p.id_cliente','v.pedido','v.idventa','fl.idforma','v.tasa','v.mivaf','v.fecha_fac as fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
            ->where ('v.idventa','=',$id)
            //->where ('fl.anulado','=',0)
            -> first();
		//dd($venta);
            $detalles=DB::table('detalle_ventaf as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.origen','a.volumen','a.grados','a.nombre as articulo','a.codigo','dv.costoarticulo as costo','a.iva','a.unidad','dv.cantidad','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
			->orderBy('a.nombre','asc')
            ->get();
			//dd($detalles);
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
			->orderby('idrecibo','des')
            ->first();


			//dd($vacios);
			if($tipo==1){
				//	dd($tipo);
            return view("ventas.ventaf.formalibre1",["venta"=>$venta,"recibo"=>$recibo,"empresa"=>$empresa,"detalles"=>$detalles]);
			}else{
			return view("ventas.ventaf.formalibre",["venta"=>$venta,"recibo"=>$recibo,"empresa"=>$empresa,"detalles"=>$detalles]);
			}
			}
public function indimportar(Request $request)
    {
		$mesact= date("Y-m-d");
		$inimes=$mesact;
$nuevafecha = strtotime('-15 days', strtotime($inimes));
$nuevafecha = date('Y-m-d' , $nuevafecha);
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
			->where ('v.fecha_emi','>=',$nuevafecha)
            -> orderBy('v.total_venta','desc')
            -> groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado')
             ->get();
     //dd($ventas);
     return view ('ventas.ventaf.indeximportar',["ventas"=>$ventas,"empresa"=>$empresa,"personas"=>$personas]);
        
    }  
public function pnota(Request $request)
    {	
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		//	dd($request);
			$licor=0;
	$user=Auth::user()->name;
	$idnota=$request -> get('notas');
	$cont = 0;
		while($cont < count($idnota)){			
		$venta=Venta::findOrFail($idnota[$cont]);
		if($venta->licor==1){$licor=1;}
	
				$detalles=DB::table('detalle_venta as da')
				-> select('da.idarticulo as cod','da.cantidad as cant','da.costoarticulo as costo','da.precio_venta as precio')
				-> where ('da.idventa','=',$idnota[$cont])
				->get();
			
				$longitud = count($detalles);		
			//dd();
					for ($i=0;$i<$longitud;$i++){
						$detalle=new Detalleimportar();
						$detalle->idarticulo=$detalles[$i]->cod;
						$detalle->cantidad=$detalles[$i]->cant;
						$detalle->costoarticulo=$detalles[$i]->costo;
						$detalle->descuento=1;
						$detalle->precio_venta=$detalles[$i]->precio;
						$detalle->save();											
				}
			 $cont=$cont+1;				
		}							
				$contador=DB::table('ventaf')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
				if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}

				$venta=new Ventaf;
				$idcliente=explode("_",$request->get('id_cliente'));
				$venta->idcliente=$idcliente[0];
				$venta->tipo_comprobante="FAC";
				$venta->pedido=0;
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
					$fl->nrocontrol=($pnro->pnum+7101);
					$fl->save();
					
				$deta=DB::table('detalleimportar as dd')
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
							$detalle=new DetalleVentaf();
							$detalle->idventa=$venta->idventa;
							$detalle->idarticulo=$arraycod[$j];
							$detalle->costoarticulo=($arraycto[$j]);
							$detalle->cantidad=$arraycan[$j];
							$detalle->descuento=0;
							$detalle->precio_venta=($arrayinpv[$j]);
							 $detalle->fecha_emi=$request->get('fecha_emi');	
							$detalle->save();
									
							$cont=$cont+1;
						}
				$devo=DB::table('detalleimportar as dd')
				-> select('dd.iddetalle as id')
				-> where ('dd.descuento','=',1)
				->get();
				$ld = count($devo);
				$array = array();
					foreach($devo as $t){
					$arrayid[] = $t->id;
					}
					for ($k=0;$k<$ld;$k++){							
						$devs=Detalleimportar::findOrFail($arrayid[$k]);
						$devs->descuento=0;
						$devs->update();
					}
	
			  return Redirect::to('ventasf/formalibre/'.$venta->idventa.'_1');
			
	}
public function show($id){

			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('p.id_cliente','v.idventa','v.saldo','v.fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
            ->where ('v.idventa','=',$id)
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta','dv.idarticulo')
            -> where ('dv.idventa','=',$id)
			->orderBy('a.nombre','asc')
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$id)-> where ('mov.tipodoc','=',"FAC")
            ->get();
			//MARIEL ROCIO MÈNDEZ CONTRERAS (INVERSIONES Q) -dd($recibonc);
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
            return view("ventas.venta.show",["vacios"=>$vacios,"notasnc"=>$notasnc,"notasnd"=>$notasnd,"cxc"=>$cxc,"venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);
}
public function ver($id){
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('v.idventa','v.fecha_emi','p.nombre','p.cedula','p.direccion','p.licencia','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
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
 public function edit($idcliente){
	     $monedas=DB::table('monedas')->get();
	     $vendedor=DB::table('vendedores')->get();
	     $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
         $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.nombre','clientes.cedula','clientes.diascre','clientes.tipo_cliente','vendedores.comision','vendedores.nombre as nombrev')
         -> where('status','=','A')
		 ->groupby('clientes.id_cliente')
         -> where ('id_cliente','=',$idcliente)
         ->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')
         -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
         -> where('art.estado','=','Activo')
         -> where ('art.stock','>','0')
         ->groupby('articulo','art.idarticulo','art.stock')
         -> get();
     return view("ventas.venta.create",["personas"=>$personas,"monedas"=>$monedas,"articulos"=>$articulos,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedor]);
 }

public function anular($id){

//dd($id);
    $venta=Ventaf::findOrFail($id);
   $venta->devolu=1;
    $venta->update();
	
	$pnro=DB::table('formalibre')
		->select('idForma as n')->where('idventa','=',$venta->idventa)
		->first();
	//dd($pnro->n);
	$fl=Formalibre::findOrFail($pnro->n);
    $fl->anulado=1;
    $fl->update();	

    return Redirect::to('ventas/ventaf');
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
		
     if($request->ajax()){
	
		 $paciente=new Pacientes;
        $paciente->nombre=$request->get('cnombre');
        $paciente->cedula=$request->get('ccedula');
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
		 $paciente->vendedor=$request->get('idvendedor');
		 $paciente->ruta=$request->get('ruta');
		  $mytime=Carbon::now('America/Caracas');
		$paciente->creado=$mytime->toDateTimeString();
        $paciente->save();
	// dd($paciente);
 $personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.nombre','clientes.diascre','clientes.cedula','clientes.tipo_cliente','vendedores.comision','vendedores.id_vendedor as nombrev')-> where('clientes.cedula','=',$request->get('ccedula'))->get();
           return response()->json($personas);
 }
    }
	 public function ventacaja(Request $request)
    {
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

            $datos=DB::table('ventaf as v')
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

}
