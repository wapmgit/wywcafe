<?php
 
namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\IngresoFormRequest;
use DB;
use sisventas\Articulo;
use sisventas\ingreso;
use sisventas\Proovedor;
use sisventas\Movbanco;
use sisventas\Kardex;
use sisventas\comprobante;
use sisventas\devolucionCompras;
use sisventas\detalledevolucionCompras;
use sisventas\DetalleIngreso;
use Auth;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
{
    
    public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {
            $query=trim($request->get('searchText'));
            $ingresos=DB::table('ingreso as i')
            -> join ('proveedor as p','i.idproveedor','=','p.idproveedor')
            -> join ('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            -> select ('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.estatus',DB::raw('sum(di.subtotal)as total'))
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orwhere('i.num_comprobante','LIKE','%'.$query.'%')
            -> orderBy('i.idingreso','desc')
            -> groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado')
                ->paginate(20);
     
     return view ('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query]);
        }
    } 
    public function create(){ 
	$monedas=DB::table('monedas')->get();
	//dd($monedas);
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
	   $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        $personas=DB::table('proveedor')
        -> where('estatus','=','A')->get();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",stock," - ",costo,"-",iva) as articulo'),'art.idarticulo','art.costo')
        -> where('art.estado','=','Activo')
        -> get();
        return view("compras.ingreso.create",["monedas"=>$monedas,"personas"=>$personas,"articulos"=>$articulos,"categorias"=>$categorias,"empresa"=>$empresa]);
    }
     public function edit($idproveedor){
		 $monedas=DB::table('monedas')->get();
	 $categorias=DB::table('categoria')->where('condicion','=','1')->get();
	 	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $personas=DB::table('proveedor')
        -> where ('idproveedor','=',$idproveedor)
        -> where('estatus','=','A')->get();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",stock," - ",costo,"-",iva) as articulo'),'art.idarticulo','art.costo')
        -> where('art.estado','=','Activo')
        -> get();
        return view("compras.ingreso.create",["monedas"=>$monedas,"personas"=>$personas,"articulos"=>$articulos,"categorias"=>$categorias,"empresa"=>$empresa]);
    }
    public function store(IngresoFormRequest $request){
		//dd($request);
	$user=Auth::user()->name;
	try{
    DB::beginTransaction(); 	
	
	$idcliente=explode("_",$request->get('idproveedor'));
    $ingreso=new ingreso;
    $ingreso->idproveedor=$idcliente[0];
    $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
    $ingreso->serie_comprobante=$request->get('serie_comprobante');
    $ingreso->num_comprobante=$request->get('num_comprobante');
    $mytime=Carbon::now('America/Caracas');
    $ingreso->fecha_hora=$mytime->toDateTimeString();
    $ingreso->impuesto='16';
    $ingreso->total=$request->get('total_venta');
    $ingreso->base=$request->get('base');
    $ingreso->miva=$request->get('iva');
    $ingreso->exento=$request->get('exento');
	if(empty($request->get('tdeuda'))){   $ingreso->saldo=$request->get('total_venta');}
	else { $ingreso->saldo=$request->get('tdeuda');}
    if ($ingreso->saldo > 0){
    $ingreso->estado='Credito';} else { $ingreso->estado='Contado';}
    $ingreso->tasa=$request->get('vtasa');
    $ingreso->user=$user;
	//dd($ingreso);
    $ingreso-> save();
	if($request->get('totala')>0){
  // inserta el recibo
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
              while($contp < count($idpago)){
				$recibo=new comprobante;
				$recibo->idcompra= $ingreso->idingreso;
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$idpago[$contp];
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
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/D";
		$mov->tipodoc="COMP";
        $mov->numero=$pago[0]."-".$request->get('serie_comprobante');
        $mov->concepto="Egreso Compras";
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
	}
// carga detalles de compra
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $precio_compra = $request -> get('precio_compra');
        $precio_cambio = $request -> get('ptasa');
        $precio_venta = $request -> get('precio_venta');
        $subtotal = $request -> get('stotal');
        
        $impuesto=0; $utilidad=0; $costo=0; $util2=0;
        $cont = 0; $cont2 = 0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleIngreso();
            $detalle->idingreso=$ingreso->idingreso;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->precio_compra=$precio_compra[$cont];
            $detalle->precio_tasa=$precio_cambio[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
            $detalle->subtotal=$subtotal[$cont];
			$mytime=Carbon::now('America/Caracas');
			$detalle->fecha=$mytime->toDateTimeString();
            $detalle->save();
			       		 
        //actualizo costo   
        $articulo=Articulo::findOrFail($idarticulo[$cont]);
        $articulo->costo=$precio_compra[$cont];
        $articulo->costo_t=$precio_cambio[$cont];
        $costo= $precio_compra[$cont];
        $costot= $precio_cambio[$cont];
        $articulo->stock=$articulo->stock+$cantidad[$cont];
        $impuesto= $articulo->iva;
        $utilidad= $articulo->utilidad;
        $util2= $articulo->util2;

           $pt=($costo + (($utilidad/100)*$costo))+($costo + (($utilidad/100)*$costo))*($impuesto/100);
            $pt2=($costo + (($util2/100)*$costo))+($costo + (($util2/100)*$costo))*($impuesto/100);
//dd($costot);
        $articulo->precio1=$pt;
        $articulo->precio2=$pt2;
        $articulo->precio_t=($costot + (($utilidad/100)*$costot))+($costot + (($utilidad/100)*$costot))*($impuesto/100);
       $articulo->update();
	   //kardex
	   	$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="COMP-".$request->get('num_comprobante');
		$kar->idarticulo=$idarticulo[$cont];
		$kar->cantidad=$cantidad[$cont];
		$kar->exis_ant=$articulo->stock;
		$kar->costo=$precio_compra[$cont];
		$kar->tipo=1; 
		$kar->user=$user;
		 $kar->save();
                    $cont=$cont+1;
                    }
                            
                DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
} 
return Redirect::to('compras/ingreso');

}
public function show($id){

    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $pago=DB::table('comprobante')
        -> where('idcompra','=',$id)->get();
   $ingreso=DB::table('ingreso as i')
            -> join ('proveedor as p','i.idproveedor','=','p.idproveedor')
            -> select ('i.idingreso','i.fecha_hora','i.total','p.nombre','p.telefono','rif','direccion','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.base','i.miva','i.exento','i.estatus')
            ->where ('i.idingreso','=',$id)
            -> first();

            $detalles=DB::table('detalle_ingreso as d')
            -> join('articulo as a','d.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.subtotal')
            -> where ('d.idingreso','=',$id)
            ->get();

            return view("compras.ingreso.show",["ingreso"=>$ingreso,"empresa"=>$empresa,"detalles"=>$detalles,"pago"=>$pago]);
}
public function etiquetas($id){

    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();

            $detalles=DB::table('detalle_ingreso as d')
            -> join('articulo as a','d.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','a.precio1','a.codigo')
            -> where ('d.idingreso','=',$id)
            ->get();
//dd($detalles);
            return view("compras.ingreso.etiquetas",["empresa"=>$empresa,"detalles"=>$detalles]);
}
		    public function historico($id)
    {
		//dd($id);
			$pacientes=DB::table('clientes')
			->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')
			->select('clientes.nombre','clientes.telefono','clientes.cedula','clientes.direccion','vendedores.nombre as vendedor')
			->where('clientes.id_cliente','=',$id)
			->first();
			$ventas=DB::table('venta')
			->join('detalle_venta as det','det.idventa','=','venta.idventa')
			->select('venta.tipo_comprobante','venta.num_comprobante','venta.serie_comprobante','venta.total_venta','venta.total_pagar','venta.fecha_emi','venta.comision','venta.descuento','venta.saldo','venta.devolu')
				->where('venta.idcliente','=',$id)
				->orderBy('venta.idventa','desc')
				->groupBy('venta.idventa')
				->get();
        return view("pacientes.paciente.show",["cliente"=>$pacientes,"ventas"=>$ventas]);
    }
public function destroy($id){
	$user=Auth::user()->name;
    $ingreso=new devolucionCompras;
    $ingreso->idcompra=$id;
    $mytime=Carbon::now('America/Lima');
    $ingreso->fecha_hora=$mytime->toDateTimeString();
	$ingreso->usuario=$user;
    $ingreso-> save();
			$detalles=DB::table('detalle_ingreso as da')
            -> select('da.idarticulo as cod','da.cantidad')
            -> where ('da.idingreso','=',$id)
            ->get();
		$longitud = count($detalles);
	$array = array();
			foreach($detalles as $t){
			$arraycod[] = $t->cod;
			$arraycan[] = $t->cantidad;
			}
for ($i=0;$i<$longitud;$i++){
	   $ingresod=new detalledevolucioncompras;
		$ingresod->iddevolucion=$ingreso->iddevolucion;
		$ingresod->codarticulo=$arraycod[$i];
		$ingresod->cantidad=$arraycan[$i];
		$ingresod->fecha=$mytime->toDateTimeString();
		$ingresod-> save();
	
	$articulo=Articulo::findOrFail($arraycod[$i]);
	$articulo->stock=($articulo->stock-$arraycan[$i]);
    $articulo->update();
			$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="DEV:C-".$id;
		$kar->idarticulo=$arraycod[$i];
		$kar->cantidad=$arraycan[$i];
		$kar->costo=0;
		$kar->tipo=2; 
		$kar->user=$user;
		 $kar->save();
}
			 $ingreso=ingreso::findOrFail($id);
			 $ingreso->estatus='Anulada';
			  $ingreso->saldo='0,0';
			 $ingreso->update();
			 return Redirect::to('compras/ingreso');
}

 public function almacena(Request $request)
    {	
           if($request->ajax()){	
		$paciente=new Proovedor;
        $paciente->nombre=$request->get('cnombre');
        $paciente->rif=$request->get('rif');
        $paciente->telefono=$request->get('ctelefono');
        $paciente->estatus='A';
        $paciente->direccion=$request->get('cdireccion');
        $paciente->contacto=$request->get('contacto');
        $paciente->save();
	
 $personas=DB::table('proveedor')-> where('rif','=',$request->get('rif'))->get();
           return response()->json($personas);
 }
    }
}




























