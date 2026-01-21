<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use DB;
use sisventas\Devolucion;
use sisventas\Detalledevolucion;
use sisventas\Venta;
use sisventas\Articulo;
use sisventas\Ingreso;
use sisventas\Recibo;
use sisventas\Movbanco;
use sisventas\Existencia;
use sisventas\Mov_notas;
use sisventas\Notasadm;
use sisventas\Kardex;
use sisventas\User;
use sisventas\Vendedores;
use Carbon\Carbon;
use sisventas\Http\Requests\DevolucionFormRequest;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\reportesRequest;
use response;
use Illuminate\Support\Collection;
use Auth;
use Khill\Lavacharts\Lavacharts;

class ReportesController extends Controller
{
    public function __construct()
    {
     
    }
    public function index(Request $request)
    {
	
	$rol=DB::table('roles')-> select('rventas')->where('iduser','=',$request->user()->id)->first();
	$ide=Auth::user()->idempresa;
        if ($request)
        {
			if($request->get('opcfecha')){$opcfecha=$request->get('opcfecha');	
			}else{ $opcfecha="v.fechahora";}
			$vendedores=DB::table('vendedores')->where('idempresa','=',$ide)->where('estatus','=',1)->get();    
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
            $query2 = date_create($query2);  
	
            date_add($query2, date_interval_create_from_date_string('0 day'));
            $query2=date_format($query2, 'Y-m-d');
         //datos venta
	if($request->get('dev')){$c="=";$v=0;	}else{ $c=">=";$v=0;}	
	if($request->get('ped')){$cp="=";$vp="FAC";	}else{ $cp="!=";$vp="";}
         if(($request->get('vendedor')==0)and($request->get('ruta')==0)){
			 $vende="Todos Los Vendedores";
            $datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.mret','v.idventa','c.direccion','c.telefono','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')			
			->where('v.idempresa','=',$ide)
			->where('v.devolu',$c,$v)
			->where('v.tipo_comprobante',$cp,$vp)
			-> whereBetween($opcfecha, [$query, $query2])
			-> groupby('v.idventa')
            ->get();

			// pagos
			  $pagos=DB::table('recibos as re')
			  -> join('venta as v','v.idventa','=','re.idventa')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago','re.tiporecibo')
			->where('re.idempresa','=',$ide)
			->where('re.monto','>',0)
            -> whereBetween($opcfecha, [$query, $query2])
			-> groupby('re.idpago','re.tiporecibo')
            ->get();
			//dd($pagos);
        //datos devolucion     
             $devolucion=DB::table('notasadm as d')
            -> select(DB::raw('sum(d.monto) as totaldev'))
			->where('d.descripcion','=',"N/C por Devolucion")
			->where('d.idempresa','=',$ide)
            ->whereBetween('d.fecha', [$query, $query2])
            ->get();	
		 }    
		 if(($request->get('vendedor')>0)and($request->get('ruta')>0)){
			 		 $ruta=$request->get('ruta');
			 $buscav=DB::table('vendedores')->where('id_vendedor','=',$request->get('vendedor'))->first();  
			 $vende=$buscav->nombre." Ruta ".$ruta;
			$datos=DB::table('venta as v')
      -> join('clientes as c','v.idcliente','=','c.id_cliente')
	  -> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
		->select('v.forma','v.mret','v.idventa','c.nombre','c.direccion','c.telefono','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
		->where('v.idempresa','=',$ide)
		->where('v.devolu',$c,$v)
		->where('v.tipo_comprobante',$cp,$vp)
		-> where('ven.id_vendedor','=',$request->get('vendedor'))	  
	  	  -> where('c.ruta','=',$request->get('ruta'))
			-> whereBetween($opcfecha, [$query, $query2])
			-> groupby('v.idventa')
            ->get(); 
	
				  $pagos=DB::table('recibos as re')
				  ->join('venta as v','v.idventa','=','re.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
				  ->join('vendedores as ve','ve.id_vendedor','=','cli.vendedor')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago','re.tiporecibo')
		 ->where('re.idempresa','=',$ide)
		 -> where('ve.id_vendedor','=',$request->get('vendedor'))
		 	  -> where('cli.ruta','=',$request->get('ruta'))
		 ->where('re.monto','>',0)
           -> whereBetween($opcfecha, [$query, $query2])
		-> groupby('re.idpago','re.tiporecibo')
            ->get(); 		
			
			$devolucion=DB::table('notasadm as d')
            -> select(DB::raw('sum(d.monto) as totaldev'))
			->where('d.descripcion','=',"N/C por Devolucion")
            ->where('d.idempresa','=',$ide)
			->whereBetween('d.fecha', [$query, $query2])
            ->get();
		 }
		if(($request->get('vendedor')==0)and($request->get('ruta')>0)){
			  $vende="Todos Los Vendedores Ruta".$request->get('ruta');
            $datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.mret','v.idventa','c.direccion','c.telefono','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
			->where('v.idempresa','=',$ide)
			->where('v.devolu',$c,$v)
			->where('v.tipo_comprobante',$cp,$vp)
			-> whereBetween($opcfecha, [$query, $query2])
				-> where('c.ruta','=',$request->get('ruta'))
			-> groupby('v.idventa')
            ->get();
				// dd($datos);
			// pagos
			$pagos=DB::table('recibos as re')
			->join('venta as v','v.idventa','=','re.idventa')
			->join('clientes as cli','cli.id_cliente','=','v.idcliente')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago','re.tiporecibo')
			->where('re.idempresa','=',$ide)
			->where('re.monto','>',0)
            -> whereBetween('v.fecha_emi', [$query, $query2])
			-> where('cli.ruta','=',$request->get('ruta'))
			-> groupby('re.idpago','re.tiporecibo')
            ->get();
        //datos devolucion     
			$devolucion=DB::table('notasadm as d')
            -> select(DB::raw('sum(d.monto) as totaldev'))
			->where('d.descripcion','=',"N/C por Devolucion")
			->where('d.idempresa','=',$ide)
            ->whereBetween('d.fecha', [$query, $query2])
            ->get();
		 //dd($devolucion);   
		 }
		 		if(($request->get('vendedor')>0)and($request->get('ruta')==0)){
		$buscav=DB::table('vendedores')->where('id_vendedor','=',$request->get('vendedor'))->first();  
			  $vende=$buscav->nombre." Todas las Rutas";
            $datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.mret','v.idventa','c.direccion','c.telefono','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
			->where('v.idempresa','=',$ide)
			->where('v.devolu',$c,$v)
			->where('v.tipo_comprobante',$cp,$vp)
			-> whereBetween($opcfecha, [$query, $query2])
			-> where('v.idvendedor','=',$request->get('vendedor'))
			-> groupby('v.idventa')
            ->get();
				// dd($datos);
			// pagos
			$pagos=DB::table('recibos as re')
			->join('venta as v','v.idventa','=','re.idventa')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago','re.tiporecibo')
			->where('re.idempresa','=',$ide)
			->where('re.monto','>',0)
			-> whereBetween($opcfecha, [$query, $query2])
			-> where('v.idvendedor','=',$request->get('vendedor'))
			-> groupby('re.idpago','re.tiporecibo')
            ->get();
        //datos devolucion     
   $devolucion=DB::table('notasadm as d')
            -> select(DB::raw('sum(d.monto) as totaldev'))
			->where('d.descripcion','=',"N/C por Devolucion")
			->where('d.idempresa','=',$ide)
            ->whereBetween('d.fecha', [$query, $query2])
            ->get();
		 //dd($devolucion);   
		 }
		if($request->get('ruta')==1000){			 
			$opt=$request->get('opt');
			 $i=count($opt);
			//dd($opt);
			 $vende=" Tdos los Vendedores, Ruta".$opt[0]."-".$opt[1];	
			switch ($i) {
		case 2:
			$a=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.mret','v.idventa','c.direccion','c.telefono','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
			->where('v.idempresa','=',$ide)
			->where('v.devolu',$c,$v)
			->where('v.tipo_comprobante','=',"FAC")
			//-> where('v.idvendedor','=',$request->get('vendedor'))			
			-> where('c.ruta','=',$opt[0])
			-> whereBetween($opcfecha, [$query, $query2])
			-> groupby('v.idventa');
			$b=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.mret','v.idventa','c.direccion','c.telefono','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
			->where('v.idempresa','=',$ide)
			->where('v.devolu',$c,$v)
			->where('v.tipo_comprobante','=',"FAC")
			//-> where('v.idvendedor','=',$request->get('vendedor'))			
			-> where('c.ruta','=',$opt[1])
			-> whereBetween($opcfecha, [$query, $query2])
			-> groupby('v.idventa');		
		$datos= $a->union($b)->get();
		 
				  $pa=DB::table('recibos as re')
				  ->join('venta as v','v.idventa','=','re.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
				  ->join('vendedores as ve','ve.id_vendedor','=','cli.vendedor')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago','re.tiporecibo')
			->where('re.idempresa','=',$ide)
			-> where('cli.ruta','=',$opt[0])
			->where('re.monto','>',0)
			-> whereBetween($opcfecha, [$query, $query2])
			-> groupby('re.idpago','re.tiporecibo');
			$pb=DB::table('recibos as re')
				  ->join('venta as v','v.idventa','=','re.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
				  ->join('vendedores as ve','ve.id_vendedor','=','cli.vendedor')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago','re.tiporecibo')
			->where('re.idempresa','=',$ide)
			-> where('cli.ruta','=',$opt[0])
			->where('re.monto','>',0)
			-> whereBetween($opcfecha, [$query, $query2])
			-> groupby('re.idpago','re.tiporecibo');
           $pagos= $pa->union($pb)->get();
        break;
}
   $devolucion=DB::table('notasadm as d')
            -> select(DB::raw('sum(d.monto) as totaldev'))
			->where('d.descripcion','=',"N/C por Devolucion")
			->where('d.idempresa','=',$ide)
            ->whereBetween('d.fecha', [$query, $query2])
            ->get();
		 } 
		// dd($vendedores);
		 $rutas=DB::table('rutas')->where('idempresa','=',$ide)->get();
			 if($rol->rventas==1){
        return view('reportes.ventas.index',["rutas"=>$rutas,"fechafiltro"=>$opcfecha,"vende"=>$vende,"datos"=>$datos,"devolucion"=>$devolucion,"empresa"=>$empresa,"pagos"=>$pagos,"vendedores"=>$vendedores,"searchText"=>$query,"searchText2"=>$query2]);
		 }else{
			return view('reportes.mensajes.noautorizado');	
		 }
  }
  
}

    public function show($id)
    {   
	     $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('v.tasa','v.idventa','v.fecha_hora','v.comision','v.montocomision','p.nombre','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.saldo','v.devolu','v.total_venta')
            ->where ('v.idventa','=',$id)
            -> first();
//dd($venta);
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.idarticulo','dv.cantidad','dv.iddetalle_venta','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
			$recibonc=DB::table('mov_notas as mn')->where('mn.tipodoc','=',"FAC")-> where ('mn.iddoc','=',$id)
            ->get();
            return view("reportes.devolucion.index",["recibonc"=>$recibonc,"venta"=>$venta,"detalles"=>$detalles,"recibo"=>$recibo,"empresa"=>$empresa]);
      
    }
    public function store(DevolucionFormRequest $request){
//dd($request);
	$ide=Auth::user()->idempresa;
	$user=Auth::user()->name;
    $devolucion=new Devolucion;
    $devolucion->idempresa=$ide;
    $devolucion->idventa=$request->get('idventa');
    $devolucion->comprobante=$request->get('comprobante');
    $mytime=Carbon::now('America/Caracas');
    $devolucion->fecha_hora=$mytime->toDateTimeString();
    $devolucion->user=$user;
	$devolucion-> save();
	$dep=DB::table('venta')
	->join('depvendedor','depvendedor.idvendedor','=','venta.idvendedor')->select('depvendedor.id_deposito')
            ->where('venta.idventa','=',$request->get('idventa'))		
            ->first();
    $venta=Venta::findOrFail( $devolucion->idventa);
    $venta->devolu='1';
	$venta->saldo='0';
    $venta->update();
				if($request->get('nc')){
		$paciente=new Notasadm;
        $paciente->tipo=2;
        $paciente->idempresa=$ide;
        $paciente->idcliente=$venta->idcliente;
        $paciente->descripcion="N/C por Devolucion";
        $paciente->referencia="FAC ".$venta->idventa;
        $paciente->monto=$request->get('monnc');
		$mytime=Carbon::now('America/Caracas');
		$paciente->fecha=$mytime->toDateTimeString();
        $paciente->pendiente=$request->get('monnc');
		$paciente->usuario=Auth::user()->name;
        $paciente->save();
		//dd($paciente);
				}
//dd($devolucion);
//registra el detalle de la devolucion
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $descuento = $request -> get('descuento');
        $precio_venta = $request -> get('precio_venta');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new Detalledevolucion();
            $detalle->iddevolucion=$devolucion->iddevolucion;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
			$detalle->save();
            $articulo=Articulo::findOrFail($idarticulo[$cont]);
            $articulo->stock=($articulo->stock+$cantidad[$cont]);
			$articulo->update();
			$deposito=DB::table('existencia')->select('id')
            ->where('idempresa','=',$ide)
            ->where('id_almacen','=',$dep->id_deposito)		
            ->where('idarticulo','=',$idarticulo[$cont])		
            ->first();
					$exis=Existencia::findOrFail($deposito->id);
					$exis->existencia=($exis->existencia+$cantidad[$cont]);
					$exis->update();
		$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="DEV:V-".$request->get('comprobante');
		$kar->idarticulo=$idarticulo[$cont];
		$kar->cantidad=$cantidad[$cont];
		$kar->costo=$precio_venta[$cont];
		$kar->tipo=1; 
		$kar->user=$user;
		$kar->save(); 
            $cont=$cont+1;
            }
			$contr=0;
	$recibos=DB::table('recibos')-> where('idventa','=',$request->get('idventa'))->get();
	//dd($recibos);
		$ld = count($recibos);
		if($ld>0){
				$array = array();
					foreach($recibos as $t){
					$arrayid[] = $t->idrecibo;
					}
		    	for ($k=0;$k<$ld;$k++){	
		    	$recibo=Recibo::findOrFail($arrayid[$k]);
		    	$recibo->referencia='Anulado';
			 $recibo->monto='0,0';
			 $recibo->recibido='0,0';
			 $recibo->update();
				$movimiento=DB::table('mov_ban')-> where('tipodoc','=','VENT')->where('iddocumento','=',$recibo->idrecibo)->first();					
					if($movimiento <> NULL){
					$mov=Movbanco::findOrFail($movimiento->id_mov); 	
					$mov->estatus='1';
					$mov->update();	
					} 
				$contr=$contr+1;
				}  			
			}  			
				//de las nc aplicadas
$notas=DB::table('mov_notas')
-> where('iddoc','=',$request->get('idventa'))
-> where('tipodoc','=',"FAC")
->get();

	$ldn = count($notas);
	if($ldn>0){
		$array = array();
		foreach($notas as $t){
		$arrayidn[] = $t->id_mov;
		$arraymn[] = $t->monto;
		}
		for ($x=0;$x<$ldn;$x++){
			//dd($arrayidn[$x]);
			$rnc=DB::table('relacionnc')-> where('idmov','=',$arrayidn[$x])->first();
			//dd($rnc);
				$upnota=Notasadm::findOrFail($rnc->idnota);
				$upnota->pendiente=$upnota->pendiente+$arraymn[$x];		
				$upnota->update();	
				$upmnota=Mov_notas::findOrFail($rnc->idmov);
				$upmnota->estatus=1;		
				$upmnota->update();	
		}			
	}			
		
return Redirect::to('ventas/venta');
}
    
     public function caja(Request $request)
    {
		$ide=Auth::user()->idempresa;
	$rol=DB::table('roles')-> select('rcompras')->where('iduser','=',$request->user()->id)->first();
		$corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$tipo=$request->get('tipodoc');
        $query=trim($request->get('searchText'));
        $query2=trim($request->get('searchText2'));
			if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('ingreso as c')
            ->join ('proveedor as p', 'c.idproveedor','=','p.idproveedor')
			->select ('c.idingreso','c.base','c.miva','c.exento','c.serie_comprobante','c.estado','c.total','c.saldo','c.fecha_hora','p.nombre','p.rif','tipo_comprobante')
			->where('c.idempresa','=',$ide)
			->where('tipo_comprobante','=',$tipo)
            ->whereBetween('c.fecha_hora', [$query, $query2])
            ->groupby('c.idingreso')
            ->get();
        // dd($datos);
			$pagos=DB::table('comprobante as re')->join('ingreso','ingreso.idingreso','=','re.idcompra')
			->where('re.idempresa','=',$ide)
			-> where('ingreso.tipo_comprobante','=',$tipo)
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
            -> whereBetween('re.fecha_comp', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
		$query2=date("Y-m-d",strtotime($query2."- 1 days"));
       	if($rol->rcompras){
        return view('reportes.compras.index',["datos"=>$datos,"pagos"=>$pagos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);    
		          		 }else{
			return view('reportes.mensajes.noautorizado');	
		 } 
    }
	     public function gastos(Request $request)
    {
		$ide=Auth::user()->idempresa;
		$corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$tipo=$request->get('tipodoc');
        $query=trim($request->get('searchText'));
        $query2=trim($request->get('searchText2'));
			if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('gasto as c')
            ->join ('proveedor as p', 'c.idpersona','=','p.idproveedor')
			->select ('c.*','p.nombre','p.rif')
			->where('c.idempresa','=',$ide)
            ->whereBetween('c.fecha', [$query, $query2])
            ->groupby('c.idgasto')
            ->get();
			$pagos=DB::table('comprobante as re')->join('gasto','gasto.idgasto','=','re.idgasto')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
            ->where('re.idempresa','=',$ide)
			-> whereBetween('re.fecha_comp', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
		$query2=date("Y-m-d",strtotime($query2."- 1 days"));
        return view('reportes.gastos.index',["datos"=>$datos,"pagos"=>$pagos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);    
    }
     public function lista(Request $request)
    {   
            $lista=DB::table('articulo')
           ->get();
          

        return view('reportes.compras.show',["lista"=>$lista]);
            
    }
    public function valorizado(Request $request)
    {   
		$ide=Auth::user()->idempresa;
         $rol=DB::table('roles')-> select('valorizado')->where('iduser','=',$request->user()->id)->first();
		 $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $lista=DB::table('articulo')
			->where('idempresa','=',$ide)
			->where('articulo.stock','>',0)
			->where('articulo.estado','=',"Activo")
			->OrderBy('articulo.nombre')
           ->get();
		   if($rol->valorizado){
        return view('reportes.valorizado.index',["lista"=>$lista,"empresa"=>$empresa]);
             }else{
			return view('reportes.mensajes.noautorizado');	
		 }  
    }
     public function inventario(Request $request)
    {   
		$ide=Auth::user()->idempresa;
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        $lista=DB::table('articulo as art')->join('categoria as cat','cat.idcategoria','=','art.idcategoria')
		->select('art.idarticulo','art.nombre as nombre','art.stock','art.codigo','art.utilidad','art.util2','art.precio1','art.precio2','art.costo','art.iva')
		->where('art.estado','=',"Activo")
		->where('art.idempresa','=',$ide)	
		->where('cat.servicio','=',0)
		->OrderBy('art.nombre','asc')
        ->get();
			$kardin=DB::table('kardex as k')
			->join('articulo as art','k.idarticulo','=','art.idarticulo')
			->select(DB::raw('SUM(k.cantidad) as total'),'art.idarticulo','k.tipo')
			->where('k.tipo','=',1)
			->groupby('k.idarticulo')
			->get();
				$kardout=DB::table('kardex as k')
			->join('articulo as art','k.idarticulo','=','art.idarticulo')
			->select(DB::raw('SUM(k.cantidad) as total'),'art.idarticulo','k.tipo')
			->where('k.tipo','=',2)
			->groupby('k.idarticulo')
			->get();
	
        return view('reportes.inventario.index',["egreso"=>$kardout,"ingreso"=>$kardin,"lista"=>$lista,"empresa"=>$empresa]);          
    }
	 public function listaprecio(Request $request)
    {   
		$ide=Auth::user()->idempresa;
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        $lista=DB::table('articulo as art')->join('categoria as cat','cat.idcategoria','=','art.idcategoria')
		->select('art.nombre as nombre','art.codigo','art.stock','art.precio1','art.precio2','art.costo','art.iva','art.unidad')
		->where('art.idempresa','=',$ide)
		->where('art.stock','>',0)
		->where('art.estado','=',"Activo")
		->where('cat.servicio','=',0)
		->OrderBy('art.nombre')
        ->get();
        return view('reportes.inventario.listaprecio',["lista"=>$lista,"empresa"=>$empresa]);          
    }
	public function cero(Request $request)
    {   
		$ide=Auth::user()->idempresa;
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        $lista=DB::table('articulo as art')->join('categoria as cat','cat.idcategoria','=','art.idcategoria')
		->select('art.codigo','art.utilidad','art.util2','art.nombre as nombre','art.stock','art.precio1','art.precio2','art.costo','art.iva')
		->where('art.idempresa','=',$ide)
		->where('art.stock','<=',0)
		->where('art.estado','=',"Activo")
		->where('cat.servicio','=',0)
		->OrderBy('art.nombre')
        ->get();
        return view('reportes.inventario.cero',["lista"=>$lista,"empresa"=>$empresa]);
            
    }
	    public function utilidad(Request $request)
    {  
		$ide=Auth::user()->idempresa;	       
        if ($request)
        {
			if($request->get('opcfecha')){$opcfecha=$request->get('opcfecha');	
			}else{ $opcfecha="v.fechahora";}
			$corteHoy = date("Y-m-d");
           $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
            $query2 = date_create($query2);
			if (($query)==""){$query=$corteHoy; }
            date_add($query2, date_interval_create_from_date_string('0 day'));
            $query2=date_format($query2, 'Y-m-d');
         //datos venta
		    $resumen=($request->get('check'));    
			if ($resumen=="on"){    
			$datos=DB::table('venta as v')
			-> join('detalle_venta as dv','v.idventa','=','dv.idventa')
			-> join('articulo as a','dv.idarticulo','=','a.idarticulo')
			-> select('v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.total_venta','v.fecha_hora','a.idarticulo',DB::raw('dv.cantidad*0 as cantidad'),DB::raw('a.costo*0 as costo'),'a.iva',DB::raw('dv.precio_venta*0 as precio_venta'),DB::raw('sum(dv.cantidad * dv.costoarticulo) as costoneto'),DB::raw('sum(dv.cantidad*dv.precio_venta)as ventaneta'))	
			->where('v.idempresa','=',$ide)	
			->where('v.devolu','=',0)	
			-> whereBetween($opcfecha, [$query, $query2])
			-> Groupby('dv.idventa')      
			->get();
				}else{
			$datos=DB::table('venta as v')
			-> join('detalle_venta as dv','v.idventa','=','dv.idventa')
			-> join('articulo as a','dv.idarticulo','=','a.idarticulo')
			-> select('v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.total_venta','v.fecha_hora','a.idarticulo','dv.cantidad as cantidad','a.costo','a.iva','dv.precio_venta',DB::raw('(dv.cantidad * dv.costoarticulo) as costoneto'),DB::raw('(dv.cantidad*dv.precio_venta)as ventaneta'))
			->where('v.idempresa','=',$ide)	
			->where('v.devolu','=',0)
			-> whereBetween($opcfecha, [$query, $query2])
			->get();
			}
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.aux) as totaldev'))
			->where('d.idempresa','=',$ide)	
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
       //dd($devolucion);   
	  // $query2=date("Y-m-d",strtotime($query2."- 1 days"));
       return view('reportes.utilidad.index',["fechafiltro"=>$opcfecha,"datos"=>$datos,"devolucion"=>$devolucion,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
       
    }
            
    }
public function corte(Request $request)
    {
	$ide=Auth::user()->idempresa;		
	$rol=DB::table('roles')-> select('ccaja')->where('iduser','=',$request->user()->id)->first();
		$usuario=DB::table('users')-> where('idempresa','=',$ide)->get();
	 //dd($request->get('usuario'));
      if ($request)
        {
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
           $query2 = date_create($query2);  	
            date_add($query2, date_interval_create_from_date_string('1 day'));
           $query2=date_format($query2, 'Y-m-d');
		  $user=$request->get('usuario');
		 //datos v
		    if($request->get('usuario') == NULL){
            $datos=DB::table('venta as v')
			-> where('idempresa','=',$ide)
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> where('v.tipo_comprobante','=',"FAC")
			-> groupby('v.idventa')
            ->get();
				//dd($datos);
			//ventas impuestos
			$impuestos=DB::table('detalle_venta as dv')
			-> join('articulo as art','dv.idarticulo','=','art.idarticulo')
			-> join('venta as v','dv.idventa','=','v.idventa')
			-> select(DB::raw(('sum(((dv.precio_venta*dv.cantidad)/((art.iva/100)+1))) as gravado')),DB::raw('sum(dv.precio_venta*dv.cantidad) as montoventa'),'art.iva','v.fecha_hora')
			-> where('dv.idempresa','=',$ide)
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> where('v.tipo_comprobante','=',"FAC")
			-> groupby('art.iva')
			->get();
		//
        //datos devolucion     
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.monto) as totaldev'))
			-> where('d.idempresa','=',$ide)
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
			//dd($devolucion);
			//cobros directos
			$pagos=DB::table('recibos as re')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
			-> where('re.idempresa','=',$ide)
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"P")
			-> groupby('re.idpago')
            ->get();
      // dd($query);   
			$cobranza=DB::table('recibos as re')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
			-> where('re.idempresa','=',$ide)
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"A")
			-> groupby('re.idpago')
            ->get();
			$ingresos=DB::table('recibos as re')
			 -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
			 -> where('re.idempresa','=',$ide)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
			$comisiones=DB::table('recibo_comision as re')
			-> select(DB::raw('sum(re.monto) as monto'))
			-> where('re.idempresa','=',$ide)
            -> whereBetween('re.fecha', [$query, $query2])
            ->first();
			//dd($comisiones);
			
			$ingresosnd=DB::table('mov_notas as n')
			->join('venta','venta.idventa','=','n.iddoc')
            -> select(DB::raw('sum(n.monto) as recibido'))
			-> where('n.idempresa','=',$ide)
            -> whereBetween('n.fecha', [$query, $query2])
			-> groupby('n.tipodoc')
            ->first();
			$creditos=DB::table('notasadm as nc')
            -> select(DB::raw('sum(nc.monto) as recibido'))
			->where('nc.tipo','=',2)
			-> where('nc.idempresa','=',$ide)
            -> whereBetween('nc.fecha', [$query, $query2])
            ->first();
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
				  } else {
		    $datos=DB::table('venta as v')
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> where('v.idempresa','=',$ide)
			-> where ('user','=',$user)
			-> where('v.tipo_comprobante','=',"FAC")
			-> groupby('v.idventa')
            ->get();
			//dd($datos);
			//ventas impuestos
			$impuestos=DB::table('detalle_venta as dv')
			-> join('articulo as art','dv.idarticulo','=','art.idarticulo')
			-> join('venta as v','dv.idventa','=','v.idventa')
			-> select(DB::raw(('sum(((dv.precio_venta*dv.cantidad)/((art.iva/100)+1))) as gravado')),DB::raw('sum(dv.precio_venta*dv.cantidad) as montoventa'),'art.iva','v.fecha_hora')
			-> where('v.tipo_comprobante','=',"FAC")
			-> where('v.devolu','=',0)
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> groupby('art.iva')
			->get();
		//
        //datos devolucion     
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.monto) as totaldev'))
		    -> where ('user','=',$user)
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
			//dd($devolucion);
			//cobros directos
			$pagos=DB::table('recibos as re')
			-> join('venta as v','v.idventa','=','re.idventa')
            -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
			-> where ('v.user','=',$user)
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"P")
			-> groupby('re.idpago')
            ->get();
      // dd($query);   
			$cobranza=DB::table('recibos as re')
			-> join('venta as v','v.idventa','=','re.idventa')
            -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
			-> where ('re.usuario','=',$user)
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"A")
			-> groupby('re.idpago')
            ->get();
		    $ingresos=DB::table('recibos as re')
			-> join('venta as v','v.idventa','=','re.idventa')
            -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
			-> where ('v.user','=',$user)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idpago')
            ->get();

			$comisiones=DB::table('recibo_comision as re')
			-> select(DB::raw('sum(re.monto) as monto'))
			-> where ('re.user','=',$user)
            -> whereBetween('re.fecha', [$query, $query2])
            ->first();
			$ingresosnd=DB::table('mov_notas as n')
            -> select(DB::raw('sum(n.monto) as recibido'))
			->where('n.tipodoc','=',"FAC")
			-> where ('n.user','=',$user)
            -> whereBetween('n.fecha', [$query, $query2])
			-> groupby('n.tipodoc')
            ->first();
				$creditos=DB::table('notasadm as nc')
            -> select(DB::raw('sum(nc.monto) as recibido'))
			->where('nc.tipo','=',2)
			-> where ('nc.usuario','=',$user)
            -> whereBetween('nc.fecha', [$query, $query2])
            ->first();
			//dd($ingresosnd);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));			  
				  }
		}
		if($rol->ccaja==1){
        return view('reportes.corte.index',["creditos"=>$creditos,"datos"=>$datos,"devolucion"=>$devolucion,"impuestos"=>$impuestos,"comision"=>$comisiones,"empresa"=>$empresa,"ingresos"=>$ingresos,"cobranza"=>$cobranza,"pagos"=>$pagos,"searchText"=>$query,"searchText2"=>$query2,"usuario"=>$usuario,"ingresosnd"=>$ingresosnd]);
          		 }else{
			return view('reportes.mensajes.noautorizado');	
		 } 
  }
		public function cortecaja(Request $request)
    { $user=Auth::user()->name;
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
      if ($request)
        {
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
           $query2 = date_create($query2);  
	
            date_add($query2, date_interval_create_from_date_string('1 day'));
           $query2=date_format($query2, 'Y-m-d');
         //datos venta
            $datos=DB::table('venta as v')
			->where('v.user','=',$user)
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> groupby('v.idventa')
            ->get();
			//dd($datos);
			//ventas impuestos
			$impuestos=DB::table('detalle_venta as dv')
			-> join('articulo as art','dv.idarticulo','=','art.idarticulo')
			-> join('venta as v','dv.idventa','=','v.idventa')
			-> select(DB::raw(('sum(((dv.precio_venta*dv.cantidad)/((art.iva/100)+1))) as gravado')),DB::raw('sum(dv.precio_venta*dv.cantidad) as montoventa'),'art.iva','v.fecha_hora')
			->where('v.user','=',$user)
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> groupby('art.iva')
			->get();
		//
        //datos devolucion     
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.monto) as totaldev'))
			->where('d.user','=',$user)
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
			//dd($devolucion);
			//cobros directos
			$pagos=DB::table('recibos as re')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
		 ->join('venta','venta.idventa','=','re.idventa')
		 	->where('venta.user','=',$user)
			->where('venta.devolu','=',0)
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"P")
			-> groupby('re.idpago')
            ->get();
      // dd($query);   
			$cobranza=DB::table('recibos as re')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
		 	 ->join('venta','venta.idventa','=','re.idventa')
		 	->where('venta.user','=',$user)
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"A")
			-> groupby('re.idpago')
            ->get();
		$ingresos=DB::table('recibos as re')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
		 	 ->join('venta','venta.idventa','=','re.idventa')
		 	->where('venta.user','=',$user)
			->where('venta.devolu','=',0)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
			$comisiones=DB::table('recibo_comision as re')
			-> select(DB::raw('sum(re.monto) as monto'))
            -> whereBetween('re.fecha', [$query, $query2])
            ->first();
			//dd($comisiones);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
        return view('reportes.corte.cortecaja',["datos"=>$datos,"devolucion"=>$devolucion,"impuestos"=>$impuestos,"empresa"=>$empresa,"ingresos"=>$ingresos,"cobranza"=>$cobranza,"pagos"=>$pagos,"searchText"=>$query,"searchText2"=>$query2]);
       
  }
            
    }
       public function ventasarticulo(Request $request)
    {
		$ide=Auth::user()->idempresa;
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$vendedor=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();
		$rutas=DB::table('rutas')-> where('idempresa','=',$ide)->get();
		$clientes=DB::table('clientes')-> where('idempresa','=',$ide)->get();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             $fecha=trim($request->get('fecha'));
             if (($query)==""){$query=$corteHoy; $query2=$corteHoy; }
             if (($fecha)==""){$fecha="fecha"; }
			$query2 = date_create($query2);
           date_add($query2, date_interval_create_from_date_string('0 day'));
            $query2=date_format($query2, 'Y-m-d');
		
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')	
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			-> where('dv.idempresa','=',$ide)
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('a.idarticulo')
			->OrderBy('a.nombre')
            ->get();
		//dd($datos);
		$datoscli=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')	
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  
			->join ('categoria as ca','ca.idcategoria','=','a.idcategoria') 			 
            -> select('cli.nombre','dv.cantidad','dv.idarticulo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			-> where('dv.idempresa','=',$ide)
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->OrderBy('a.nombre')
            ->get();
			$busqueda=DB::table('vendedores')-> where('id_vendedor','=',$request->get('vendedor'))->select('nombre')->first();
			//  		
		//	dd($fecha);
		if($request->get('opcion')){

				if($request->get('opcion')==1){
					if($request->get('ruta')==0){
						$c=">";$v=0;	}else{ $c="=";$v=$request->get('ruta');}	
				
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
           -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('ve.idvendedor','=',$request->get('vendedor'))
			->where('cli.ruta',$c,$v)
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();	
				$datoscli=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')	
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  
			->join ('categoria as ca','ca.idcategoria','=','a.idcategoria') 			 
            -> select('cli.nombre','dv.cantidad','dv.idarticulo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('ve.idvendedor','=',$request->get('vendedor'))
			->where('cli.ruta','=',$request->get('ruta'))
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->OrderBy('a.nombre')
            ->get();
		if($request->get('ruta')==0){	
			$datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
           -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('ve.idvendedor','=',$request->get('vendedor'))			
			
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();	
			$datoscli=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')	
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  
			->join ('categoria as ca','ca.idcategoria','=','a.idcategoria') 			 
            -> select('cli.nombre','dv.cantidad','dv.idarticulo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('ve.idvendedor','=',$request->get('vendedor'))	
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->OrderBy('a.nombre')
            ->get();
		}					
			$busqueda=[];

			}	

		
		if($request->get('opcion')==2){
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')			
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('ve.idcliente','=',$request->get('cliente'))
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();			
			$datoscli=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')	
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  
			->join ('categoria as ca','ca.idcategoria','=','a.idcategoria') 			 
            -> select('cli.nombre','dv.cantidad','dv.idarticulo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('ve.idcliente','=',$request->get('cliente'))	
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->OrderBy('a.nombre')
            ->get();	
			$busqueda=DB::table('clientes')-> where('id_cliente','=',$request->get('cliente'))->select('nombre')->first();
		//dd($busqueda);			
		}
				if($request->get('opcion')==3){
				//dd($request);
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')						 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$request->get('rutafiltro'))
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();			
				$datoscli=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')	
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')			 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo')  
			->join ('categoria as ca','ca.idcategoria','=','a.idcategoria') 			 
            -> select('cli.nombre','dv.cantidad','dv.idarticulo','a.codigo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$request->get('rutafiltro'))
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->OrderBy('a.nombre')
            ->get();	
			$busqueda=DB::table('rutas')-> where('idruta','=',$request->get('rutafiltro'))->select('nombre')->first();
		//dd($busqueda);			
		}
		
		
	if($request->get('opcion')==4){			
			 $opt=$request->get('opt');
			 $i=count($opt);
			
			switch ($i) {
		case 2:
			$datosa=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')						 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$opt[0])
			->where('ve.devolu','=',0)
			->where('ca.servicio','=',0)
			->where('dv.cantidad','>',0)
			->groupby('dv.idarticulo')->get();
			$ru=DB::table('rutas')-> where('idruta','=',$opt[0])->select('nombre')->first();
			$rutasu=$ru->nombre;
			 $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')						 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$opt[1])
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->where('dv.cantidad','>',0)
			->groupby('dv.idarticulo')
			->get();
			$ru=DB::table('rutas')-> where('idruta','=',$opt[1])->select('nombre')->first();
			$rutasu=$rutasu." - ".$ru->nombre;
			
			$articulos=DB::table('detalle_venta as dv')   
			 ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')
            -> select('dv.idarticulo','a.nombre','a.codigo','a.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			-> where('dv.idempresa','=',$ide)
			->groupby('dv.idarticulo')
			->get();
			//dd($articulos);
			 $datosb=[];
        break;
		case 3:
			$datosa=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')						 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$opt[0])
			->where('ve.devolu','=',0)
			->where('ca.servicio','=',0)
			->where('dv.cantidad','>',0)
			->groupby('dv.idarticulo')->get();
		
			 $datosb=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')						 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$opt[1])
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->where('dv.cantidad','>',0)
			->groupby('dv.idarticulo')
			->get();
			
			 $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')
			->join('clientes as cli','cli.id_cliente','=','ve.idcliente')						 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			->where('cli.ruta','=',$opt[2])
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->where('dv.cantidad','>',0)
			->groupby('dv.idarticulo')
			->get();
			
			$articulos=DB::table('detalle_venta as dv')   
			 ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')
            -> select('dv.idarticulo','a.nombre','a.codigo','a.nombre as grupo')
            ->whereBetween('dv.'.$fecha, [$query, $query2])
			-> where('dv.idempresa','=',$ide)
			->groupby('dv.idarticulo')
			->get();
			//dd($articulos);
        break;
}

		}
				}
				if($request->get('opcion')==4){	
				
	$query2=date("Y-m-d",strtotime($query2."- 0 days"));
			return view('reportes.ventasarticulo.indexrutag',["rutasu"=>$rutasu,"datosb"=>$datosb,"opt"=>$opt,"articulos"=>$articulos,"rutas"=>$rutas,"datoscli"=>$datoscli,"fecha"=>$fecha,"busqueda"=>$busqueda,"clientes"=>$clientes,"vendedor"=>$vendedor,"datos"=>$datos,"datosa"=>$datosa,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
				}else{
//dd($empresa);
$rutasu="";
		//dd($fecha);
			$query2=date("Y-m-d",strtotime($query2."- 0 days"));
			return view('reportes.ventasarticulo.index',["rutasu"=>$rutasu,"rutas"=>$rutas,"datoscli"=>$datoscli,"fecha"=>$fecha,"busqueda"=>$busqueda,"clientes"=>$clientes,"vendedor"=>$vendedor,"datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            }  
    }
	    public function comprasarticulo(Request $request)
    {
		$ide=Auth::user()->idempresa;
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$proveedores=DB::table('proveedor')->get();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
			     if ($request->get('proveedor') != 0){
			$datos=DB::table('detalle_ingreso as dv')            
             ->join ('ingreso as in', 'in.idingreso','=','dv.idingreso') 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_compra) as vpromedio'),DB::raw('avg(dv.subtotal) as subtotal'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->where('dv.idempresa','=',$ide)	
			->whereBetween('dv.fecha', [$query, $query2])
			->where('in.idproveedor','=',$request->get('proveedor'))
			->where('in.estatus','=',0)
            ->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();
				$filtro=DB::table('proveedor')-> where('idproveedor','=',$request->get('proveedor'))->first();
				$filtro=$filtro->nombre;
				 }else{
					 $filtro=" Todos los Proveedores";
            $datos=DB::table('detalle_ingreso as dv')            
			 ->join ('ingreso as in', 'in.idingreso','=','dv.idingreso') 
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_compra) as vpromedio'),DB::raw('avg(dv.subtotal) as subtotal'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
             ->where('dv.idempresa','=',$ide)
			->whereBetween('dv.fecha', [$query, $query2])
			->where('in.estatus','=',0)
            ->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();
				 }
			//dd($datos);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.comprasarticulo.index',["filtro"=>$filtro,"proveedores"=>$proveedores,"datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
	public function info(Request $request)
    {
		$ide=Auth::user()->idempresa;
           $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        return view('reportes.mensajes.info',["empresa"=>$empresa]);
    }
	 public function resumen(Request $request)
    {
		$ide=Auth::user()->idempresa;
           $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		    $compras=DB::table('ingreso as c')
            ->join ('proveedor as p', 'c.idproveedor','=','p.idproveedor')
			->select (DB::raw('sum(c.total) as vtotal'),DB::raw('sum(c.saldo) as vsaldo'),'c.idingreso','c.base','c.serie_comprobante','c.estado','c.total','c.saldo','c.fecha_hora','p.nombre','p.rif','p.telefono')
			->where('c.idempresa','=',$ide)
			->where('c.saldo','>',0)
		    ->get();
		  $gastos=DB::table('gasto as g')
            ->join ('proveedor as p', 'g.idpersona','=','p.idproveedor')
			->select (DB::raw('sum(g.monto) as vtotal'),DB::raw('sum(g.saldo) as vsaldo'),'g.idgasto','g.saldo','g.monto','g.documento','g.fecha','p.nombre','p.rif','p.telefono')
			->where('g.idempresa','=',$ide)         
		 ->where('g.saldo','>',0)
          ->where('g.estatus','=',0)
            ->groupby('g.idgasto')
            ->get();
			$ventas=DB::table('venta as v')
            ->join ('clientes as c', 'c.id_cliente','=','v.idcliente')
			->select (DB::raw('sum(v.total_venta) as vtotal'),DB::raw('sum(v.saldo) as vsaldo'),'c.id_cliente','v.tipo_comprobante','v.num_comprobante','v.total_venta','v.saldo','c.nombre','c.telefono','c.cedula')
			->where('v.idempresa','=',$ide)         
		 ->where('v.saldo','>',0)
          ->where('v.devolu','=',0)
		  ->where('v.tipo_comprobante','=','FAC')
            ->groupby('v.idcliente')
            ->get();
			

		//	dd($ventas);
			$valor=DB::table('articulo as dv')
			-> select(DB::raw('sum(dv.stock*dv.costo) as val_costo'),DB::raw('sum(dv.stock*dv.precio1) as val_precio'))
			->where('dv.idempresa','=',$ide)   
			->first(); 
				$q2=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select(DB::raw('sum(n.pendiente) as saldo'),DB::raw('sum(n.monto) as monto'),'c.id_cliente','c.nombre')
			->where('n.tipo','=',1)->where('n.pendiente','>',0)
			->where('n.idempresa','=',$ide)   
			->groupby('n.idcliente')
			->get();
//dd($q2);			
			$clientes=DB::table('clientes')->where('idempresa','=',$ide)   ->get();			
			$proveedores=DB::table('proveedor')->where('idempresa','=',$ide)   ->get();			
			$articulos=DB::table('articulo')->where('idempresa','=',$ide)   ->get();			
        return view('reportes.resumen.index',["clientes"=>$clientes,"articulos"=>$articulos,"proveedores"=>$proveedores,"notas"=>$q2,"valor"=>$valor,"ventas"=>$ventas,"compras"=>$compras,"gastos"=>$gastos,"empresa"=>$empresa]);    

   }
	public function cobranza(Request $request)
    {   

	$ide=Auth::user()->idempresa;
	$rol=DB::table('roles')-> select('rdetallei')->where('iduser','=',$request->user()->id)->first();
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
      if ($request)
        {
			$corteHoy = date("Y-m-d");
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
           $query2 = date_create($query2);  
	
            date_add($query2, date_interval_create_from_date_string('1 day'));
           $query2=date_format($query2, 'Y-m-d');
		   $vendedores=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();         
		   if($request->get('vendedor')==0){
			$cobranza=DB::table('recibos as re')
			->join('venta','venta.idventa','=','re.idventa' )
			->join('clientes','clientes.id_cliente','=','venta.idcliente')
			->join('vendedores as vende','vende.id_vendedor','=','clientes.vendedor')
			-> select('clientes.nombre','re.referencia','re.tiporecibo','venta.tipo_comprobante','venta.num_comprobante','re.idbanco','re.idpago','re.idrecibo','re.monto','re.recibido','re.fecha','vende.nombre as vendedor')    
			-> where('venta.idempresa','=',$ide)
			-> where('venta.devolu','=',0)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idrecibo')
            ->get();
            $comprobante=DB::table('recibos')
            -> select(DB::raw('sum(recibido) as mrecibido'),DB::raw('sum(monto) as mmonto'),'idbanco','tiporecibo')        
            -> where('idempresa','=',$ide)
			-> whereBetween('fecha', [$query, $query2])
            ->groupby('idpago')
            ->get();
		  
			$ingresosnd=DB::table('recibos as re')
			-> join('notasadm as n','n.idnota','=','re.idnota')
			->join('clientes','clientes.id_cliente','=','n.idcliente')
            -> select('clientes.nombre','re.referencia','re.tiporecibo','n.idnota as tipo_comprobante','n.idnota as num_comprobante','re.idbanco','re.idrecibo','re.idpago','re.monto','re.recibido','re.fecha','n.usuario as vendedor')
            -> where('re.idempresa','=',$ide)
			-> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idrecibo')
            ->get();
			$recibonc=DB::table('mov_notas as mov')
			-> where('idempresa','=',$ide)
			->where ('mov.estatus','=',0)-> whereBetween('mov.fecha', [$query, $query2])
            ->get();
			   }else{
				   $cobranza=DB::table('recibos as re')
				->join('venta','venta.idventa','=','re.idventa' )
				->join('clientes','clientes.id_cliente','=','venta.idcliente')
				->join('vendedores as vende','vende.id_vendedor','=','clientes.vendedor')
			 -> select('clientes.nombre','re.referencia','re.tiporecibo','venta.tipo_comprobante','venta.num_comprobante','re.idbanco','re.idrecibo','re.idpago','re.monto','re.recibido','re.fecha','vende.nombre as vendedor')
				->where('clientes.vendedor','=',$request->get('vendedor'))  
				-> where('venta.devolu','=',0)
				-> whereBetween('re.fecha', [$query, $query2])
				-> groupby('re.idrecibo')
				->get();
				$comprobante=DB::table('recibos as re')
				->join('venta','venta.idventa','=','re.idventa' )
				->join('clientes','clientes.id_cliente','=','venta.idcliente')
				->join('vendedores as vende','vende.id_vendedor','=','clientes.vendedor')
				-> select(DB::raw('sum(recibido) as mrecibido'),DB::raw('sum(monto) as mmonto'),'re.idbanco','tiporecibo')
				->where('clientes.vendedor','=',$request->get('vendedor'))       	
				-> whereBetween('re.fecha', [$query, $query2])
				->groupby('re.idpago')
				->get();
				$ingresosnd=DB::table('recibos as re')
				-> join('notasadm as n','n.idnota','=','re.idnota')
				->join('clientes','clientes.id_cliente','=','n.idcliente')
				-> select('clientes.nombre','re.referencia','re.tiporecibo','n.idnota as tipo_comprobante','n.idnota as num_comprobante','re.idbanco','re.idrecibo','re.idpago','re.monto','re.recibido','re.fecha','n.usuario as vendedor')
				-> whereBetween('re.fecha', [$query, $query2])
				-> groupby('re.idrecibo')
				->get();
				$recibonc=DB::table('mov_notas as mov')-> where('idempresa','=',$ide)-> whereBetween('mov.fecha', [$query, $query2])
				->get();
			   }
		   $query2=date("Y-m-d",strtotime($query2."- 1 days"));
					 if($rol->rdetallei){
		   $query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.cobranza.index',["comprobante"=>$comprobante,"vendedores"=>$vendedores,"empresa"=>$empresa,"cobranza"=>$cobranza,"searchText"=>$query,"searchText2"=>$query2,"ingresosnd"=>$ingresosnd,"recibonc"=>$recibonc]);
                }else{
			return view('reportes.mensajes.noautorizado');	
		 } 
       
		}
	}
    public function pagos(Request $request)
    {   
		$ide=Auth::user()->idempresa;
		$rol=DB::table('roles')-> select('rdetallec')->where('iduser','=',$request->user()->id)->first();
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
      if ($request)
        {
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
           $query2 = date_create($query2);  
            date_add($query2, date_interval_create_from_date_string('1 day'));
           $query2=date_format($query2, 'Y-m-d');
   
			$pagos=DB::table('comprobante as co')
			->join('ingreso','ingreso.idingreso','=','co.idcompra' )
			->join('proveedor as p','p.idproveedor','=','ingreso.idproveedor')
           -> select('p.nombre','co.referencia','ingreso.tipo_comprobante','ingreso.num_comprobante','co.idbanco','co.idpago','co.idrecibo','co.monto','co.recibido','co.fecha_comp as fecha','ingreso.user as vendedor')
			->where('co.idempresa','=',$ide)	
			-> where('ingreso.estatus','=',0)
            -> whereBetween('co.fecha_comp', [$query, $query2])
			-> groupby('co.idrecibo')
            ->get();
			$gastos=DB::table('comprobante as co')
			->join('gasto','gasto.idgasto','=','co.idgasto' )
			->join('proveedor as p','p.idproveedor','=','gasto.idpersona')
           -> select('p.nombre','co.referencia','gasto.documento','co.idbanco','co.idpago','co.idrecibo','co.monto','co.recibido','co.fecha_comp as fecha','gasto.usuario as vendedor')
            ->where('co.idempresa','=',$ide)	
			-> whereBetween('co.fecha_comp', [$query, $query2])
			-> groupby('co.idrecibo')
            ->get();
			
            $desglose=DB::table('comprobante')->select(DB::raw('sum(recibido) as recibido'),DB::raw('sum(monto) as monto'),'idbanco')
            ->where('idempresa','=',$ide)	
			-> whereBetween('fecha_comp', [$query, $query2])
            ->groupby('idpago')
            ->get();
			//dd($desglose);
		   		 if($rol->rdetallec){
		   $query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.pagos.index',["comprobante"=>$desglose,"empresa"=>$empresa,"gastos"=>$gastos,"pagos"=>$pagos,"searchText"=>$query,"searchText2"=>$query2]);
		         }else{
			return view('reportes.mensajes.noautorizado');	
		 }
		}
	}
	public function destroy($id){
		//dd($id);
	$dato=explode("_",$id);
    $id=$dato[0];
    $tipo=$dato[1];
	if($tipo==1){
		$user=Auth::user()->name;
			 $recibo=Recibo::findOrFail($id);
			 $venta=$recibo->idventa;
			 $monton=$recibo->monto;
			 $recibo->referencia='Anulado';
			 $recibo->monto='0,0';
			 $recibo->recibido='0,0';
			 $recibo->update();
				$movimiento=DB::table('mov_ban')-> where('tipodoc','=','VENT')->where('iddocumento','=',$id)->first();
				$mov=Movbanco::findOrFail($movimiento->id_mov); 	
				$mov->estatus='1';
				$mov->update();
			$ingreso=Venta::findOrFail($venta);
			$ingreso->saldo=($ingreso->saldo+$monton);
			$ingreso->update(); 
	}else{
		$nota=Mov_notas::findOrFail($id);
				$nc=DB::table('relacionnc')-> where('idmov','=',$id)->first();
		$doc=$nota->tipodoc;
		
			if($doc=="N/D"){
				$mov=Notasadm::findOrFail($nota->iddoc); 	
				$mov->pendiente=$mov->pendiente+$nota->monto;
				$mov->update();
			}else{
				$mov=Venta::findOrFail($nota->iddoc); 	
				$mov->saldo=$mov->saldo+$nota->monto;
				$mov->update();
			}
				$movnc=Notasadm::findOrFail($nc->idnota); 	
				$movnc->pendiente=$movnc->pendiente+$nota->monto;
				$movnc->update();
		$nota->monto=0;
		$nota->referencia="Anulado";
		$nota->update();		
	}	
			 return Redirect::to('reportes/cobranza');
	}
public function ruta(Request $request)
{
		$ide=Auth::user()->idempresa;
		$mov=DB::table('reg_deposito as de')
		->join('deposito','deposito.id_deposito','=','de.deposito')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
		->where('deposito.tipo_p','=',"C")
        -> select('de.*','articulo.nombre','deposito.id_persona')
        ->get();
     $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
     $rutas=DB::table('rutas')-> where('idempresa','=',$ide)->get();
	 $vendedores=DB::table('vendedores')-> where('idempresa','=',$ide)->where('estatus','=',1)->get();
            $datos=DB::table('clientes')->select('id_cliente','nombre','cedula','licencia','telefono','direccion')
			-> where('idempresa','=',$ide)           
		   -> where('ruta','=',$request->get('ruta'))
            -> where('vendedor','=',$request->get('vendedor'))
            ->get();
return view('reportes.ruta.index',["rutas"=>$rutas,"mov"=>$mov,"datos"=>$datos,"empresa"=>$empresa,"ruta"=>$request->get('ruta'),"vendedores"=>$vendedores]);
	}
		public function rutasvacio(Request $request)
{
	//dd($request);
	
	 $rutas=DB::table('rutas')->get();
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$mov=DB::table('reg_deposito as de')
			->join('deposito','deposito.id_deposito','=','de.deposito')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
		->where('deposito.tipo_p','=',"C")
        -> select('de.*','articulo.nombre','deposito.id_persona')
        ->get();
     
            $datos=DB::table('clientes as c')
			->join('deposito as d','d.id_persona','=','c.id_cliente')
			->select('c.id_cliente','c.nombre','c.cedula','c.licencia','c.telefono','c.direccion')
			->where('d.debe','>',0)
            -> where('ruta','=',$request->get('ruta'))
            ->get();
return view('reportes.rutasvacio.index',["rutas"=>$rutas,"mov"=>$mov,"datos"=>$datos,"empresa"=>$empresa,"ruta"=>$request->get('ruta')]);
	}
	public function vacios(Request $request)
{
		$mov=DB::table('reg_deposito as de')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
        -> select(DB::raw('sum(debe) as debe'),DB::raw('sum(debo) as debo'),'articulo.nombre')
		->groupby('de.idarticulo')
        ->get();
     $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();

return view('reportes.ruta.cuentavacios',["mov"=>$mov,"empresa"=>$empresa]);
	}
	
	public function csectores(Request $request)
	{	
		$ide=Auth::user()->idempresa;
		$municipios=DB::table('municipios')->get();
		$notas=DB::table('notasadm')
		->select('idcliente',DB::raw('sum(pendiente) as deuda'))
		->where('idempresa','=',$ide)
		->where('pendiente','>',0)
		->where('tipo','=',1)
		->groupby('idcliente')
		->get();
		$sectores=DB::table('parroquias')->get();
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();

      if ($request->get('filtro'))
        {
			if($request->get('filtro')=="municipios"){
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('municipios as m','m.id_municipio','=','c.idmunicipio')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select('c.*','m.municipio as nsector','v.id_vendedor',DB::raw('sum(ve.saldo) as saldoc'))
			->where('c.idempresa','=',$ide)
			->where('c.idmunicipio','=',$request->get('idm'))
			->where('ve.devolu','=',0)
			->where('c.status','=',"A")
			->groupby('c.id_cliente')
			->get();	
			}		
			if($request->get('filtro')=="parroquias"){
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('parroquias as p','p.id_parroquia','=','c.idsector')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select('c.*','p.parroquia as nsector','v.id_vendedor',DB::raw('sum(ve.saldo) as saldoc'))
			->where('c.idempresa','=',$ide)
			->where('c.idsector','=',$request->get('ids'))
			->where('ve.devolu','=',0)
			->where('c.status','=',"A")
			->groupby('c.id_cliente')
			->get();	
			}
		}else{ 
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('municipios as m','m.id_municipio','=','c.idmunicipio')
			->join('parroquias as p','p.id_parroquia','=','c.idsector')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select(DB::raw('CONCAT(m.municipio," ",p.parroquia) as nsector'),'c.*','v.id_vendedor',DB::raw('sum(ve.saldo) as saldoc'))
			->where('c.idempresa','=',$ide)
			->where('c.status','=',"A")
			->groupby('c.id_cliente')
			->get();
		}
			//dd($clientes);
return view('reportes.clientesectores.index',["notas"=>$notas,"municipios"=>$municipios,"sectores"=>$sectores,"clientes"=>$clientes,"empresa"=>$empresa]);
	}
	public function seguimiento(Request $request)
		{  
			$ide=Auth::user()->idempresa;
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$dias=$request->get('dias');
			$rutas=DB::table('rutas')-> where('idempresa','=',$ide)->get();
			if (($dias)==""){$dias=365; }
			$corteHoy = date("Y-m-d"); 
           $query2 = date_create($corteHoy);  
           $query2=date_format($query2, 'Y-m-d');
		      $query2=date("Y-m-d",strtotime($query2."- ".$dias."days"));
	//
	//dd($query2);
		if($request->get('vendedor')==NULL){
            $datos=DB::table('venta as v')
			-> join('clientes as c','c.id_cliente','=','v.idcliente')
			->select('v.idventa','v.idcliente','c.ultventa','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','v.user')
			->where('v.idempresa','=',$ide)
			-> where('v.fecha_emi','>',$query2)
			->where('c.status','=',"A")
			-> groupby('v.idventa')
            ->get();
			$filtro="Todos los vendedores todas las rutas";
			$mov=DB::table('clientes')->where('idempresa','=',$ide)->where('status','=',"A")->get();
		}else{
			if($request->get('ruta')==0){
				$c=">";$v=0;	}else{ $c="=";$v=$request->get('ruta');}	
				
			$datos=DB::table('venta as v')
			-> join('clientes as c','c.id_cliente','=','v.idcliente')
			->select('v.idventa','v.idcliente','c.ultventa','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','v.user')
			-> where('v.idvendedor','=',$request->get('vendedor'))
			->where('v.idempresa','=',$ide)
			-> where ('c.ruta',$c,$v)
			-> where('v.fecha_emi','>',$query2)
			->where('c.status','=',"A")
			-> groupby('v.idventa')
            ->get(); //dd($datos);
			$vendedor=DB::table('vendedores')-> where('id_vendedor','=',$request->get('vendedor'))->first();
			
		if($request->get('ruta')==0){ $nombreruta="Todas las Rutas";}else{
			$ruta=DB::table('rutas')-> where('idruta','=',$request->get('ruta'))->first();
			$nombreruta=$ruta->nombre;
		}
			$filtro= "Vendedor:".$vendedor->nombre. " Ruta: ".$nombreruta;
		 //	dd($datos);
			$mov=DB::table('clientes as c')
			->where('status','=',"A")
			->where('vendedor','=',$request->get('vendedor'))
			->where('idempresa','=',$ide)
			-> where('ruta',$c,$v)			
			->get();		 
		}	

		$vendedores=DB::table('vendedores')->where('idempresa','=',$ide)->where('estatus','=',1)->get();
	//	->rightjoin('clientes','clientes.id_cliente','=','ve.idcliente')
		//->where ('ve.idcliente','=',null)
     //   -> select('clientes.*')
      //  ->get();
//dd($mov);
return view('reportes.seguimiento.index',["filtro"=>$filtro,"rutas"=>$rutas,"vendedores"=>$vendedores,"clientes"=>$mov,"ventas"=>$datos,"empresa"=>$empresa,"query"=>$dias]);
	}
	
	public function analisiscobros(Request $request)

	{		$ide=Auth::user()->idempresa;
            $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
	$corteHoy = date("Y-m-d");
				$query=trim($request->get('searchText'));
				if (($query)==""){$query=$corteHoy; }
				$query2=trim($request->get('searchText2'));
				$query2 = date_create($query2);  
				date_add($query2, date_interval_create_from_date_string('1 day'));
				$query2=date_format($query2, 'Y-m-d');
				
			$cxcante=DB::table('venta as ve')
			->select(DB::raw('sum(ve.total_venta) as tventa'),DB::raw('sum(ve.saldo) as saldoc'))
			-> where('ve.tipo_comprobante','=',"FAC")
			->where('ve.idempresa','=',$ide)	
			-> where('ve.devolu','=',0)
			-> where('ve.fecha_emi','<',$query)
            ->first();	
			//dd($cxcante);
			$cxcvende=DB::table('venta as ve')
			->join('vendedores as vnd','vnd.id_vendedor','=','ve.idvendedor')
			->select(DB::raw('sum(ve.saldo) as saldoc'),'vnd.nombre')
			-> where('ve.tipo_comprobante','=',"FAC")
			->where('ve.idempresa','=',$ide)
			-> where('ve.devolu','=',0)
			-> where('ve.fecha_emi','<',$query)
			->groupby('ve.idvendedor')
            ->get();
			$cxcperiodo=DB::table('venta as ve')
			->select(DB::raw('sum(ve.total_venta) as tventa'),DB::raw('sum(ve.saldo) as saldoc'))
			-> where('ve.tipo_comprobante','=',"FAC")
			->where('ve.idempresa','=',$ide)
			-> where('ve.devolu','=',0)
			-> whereBetween('ve.fecha_emi', [$query, $query2])
            ->first();
		
			$cxcpervend=DB::table('venta as ve')
				->join('vendedores as vnd','vnd.id_vendedor','=','ve.idvendedor')
				->select(DB::raw('sum(ve.total_venta) as tventa'),DB::raw('sum(ve.saldo) as saldoc'),'vnd.nombre')
			-> where('ve.tipo_comprobante','=',"FAC")
			->where('ve.idempresa','=',$ide)
			-> where('ve.devolu','=',0)
			-> whereBetween('ve.fecha_emi', [$query, $query2])
            ->groupby('ve.idvendedor')
            ->get();
			//dd($cxcvende);
			$cobranza=DB::table('recibos as re')
			 -> select('re.idbanco','re.tiporecibo',DB::raw('sum(re.monto) as rmonto'),DB::raw('sum(re.recibido) as rrecibido'))  
				-> where('re.idnota','=',0)
				->where('re.idempresa','=',$ide)
				-> whereBetween('re.fecha', [$query, $query2])
				-> groupby('re.idpago','re.tiporecibo')
				->get();
			$cobranzand=DB::table('recibos as re')
			 -> select('re.idbanco','re.tiporecibo',DB::raw('sum(re.monto) as rmonto'),DB::raw('sum(re.recibido) as rrecibido'))  
				-> where('re.idnota','>',0)
				->where('re.idempresa','=',$ide)
				-> whereBetween('re.fecha', [$query, $query2])
				-> groupby('re.idpago','re.tiporecibo')
				->get();
			//	dd($cobranza);
				$ingresosnc=DB::table('mov_notas as n')
            -> select(DB::raw('sum(n.monto) as recibido'))
			->where('n.idempresa','=',$ide)
            -> whereBetween('n.fecha', [$query, $query2])
			-> groupby('n.tipodoc')
            ->first();
			//dd($ingresosnd);
		$notas=DB::table('notasadm')
		->select(DB::raw('sum(monto) as mnota'),DB::raw('sum(pendiente) as deuda'))
		->where('pendiente','>',0)
		->where('tipo','=',1)
		->where('idempresa','=',$ide)
		-> where('fecha','<',$query2)
		->groupby('tipo')
		->first();
		//dd($query);
		$query2=trim($request->get('searchText2'));
return view('reportes.ventacobranza.index',["notas"=>$notas,"ingresosnc"=>$ingresosnc,"cobranzand"=>$cobranzand,"cobranza"=>$cobranza,"cxcpervend"=>$cxcpervend,"cxcvende"=>$cxcvende,"cxcante"=>$cxcante,"cxcperiodo"=>$cxcperiodo,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
	}
			public function detallecobranza(Request $request)
	{		
	//dd($request);
			$ide=Auth::user()->idempresa;
            $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$vendedores=DB::table('vendedores')->where('idempresa','=',$ide)->where('estatus','=',1)->get();
				$corteHoy = date("Y-m-d");
				$query=trim($request->get('searchText'));
				$query2=trim($request->get('searchText2'));
				$query3=trim($request->get('searchText2'));
				if (($query)==""){$query=$corteHoy; }
				if (($query2)==""){$query2=$corteHoy;$query3=$corteHoy; }
				
				$query2=trim($request->get('searchText2'));
				$query2 = date_create($query2);  
				$diez = $query2; $quince = $query2 ;$veinte = $query2; $treinta = $query2;
				
				date_add($query2, date_interval_create_from_date_string('1 day'));
				date_add($diez, date_interval_create_from_date_string('10 day'));
				date_add($quince, date_interval_create_from_date_string('15 day'));
				date_add($veinte, date_interval_create_from_date_string('22 day'));
				date_add($treinta, date_interval_create_from_date_string('30 day'));
				
				$query2=date_format($query2, 'Y-m-d');
				$diez=date_format($diez, 'Y-m-d');
				$quince=date_format($quince, 'Y-m-d');
				$veinte=date_format($veinte, 'Y-m-d');
				$treinta=date_format($treinta, 'Y-m-d');
				if($request->get('vendedor')){
				$vende=DB::table('vendedores')->where('id_vendedor','=',$request->get('vendedor'))->first();
				$nombre=$vende->nombre;
			$datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.idventa','c.nombre','v.num_comprobante','v.total_venta','v.fecha_emi','v.saldo','ven.nombre as vendedor')			
			->where('v.idempresa','=',$ide)		
			->where('v.devolu','=',0)
			->where('v.idvendedor','=',$request->get('vendedor'))
			-> whereBetween('v.fecha_emi', [$query, $query2])
            ->get();
				$recibosdiez=DB::table('recibos as re')
			->join('venta as ve','ve.idventa','=','re.idventa')
			-> select('re.idventa',DB::raw('sum(monto) as monto'),'re.fecha','ve.fecha_emi',DB::raw('DATEDIFF(DATE_FORMAT(re.fecha,"%Y-%m-%d"),DATE_FORMAT(ve.fecha_emi,"%Y-%m-%d")) as dias'))  
		//	->whereRaw('DATEDIFF(DATE_FORMAT(ve.fecha_emi,"%Y-%m-%d"),DATE_FORMAT(re.fecha,"%Y-%m-%d")) >= 0')
			->where('re.idempresa','=',$ide)		
			->where('ve.idvendedor','=',$request->get('vendedor'))
			-> where('ve.fecha_emi','>=',$query)			
			//-> whereBetween('re.fecha', [$query, $diez])	
			->groupby('re.idrecibo')
			->get();
				}else{
					$nombre="Todos los Vendedores";
		     $datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.forma','v.idventa','c.nombre','v.num_comprobante','v.total_venta','v.fecha_emi','v.saldo','ven.nombre as vendedor')			
			->where('v.devolu','=',0)
			->where('v.idempresa','=',$ide)		
			-> whereBetween('v.fecha_emi', [$query, $query2])
            ->get();		
			$recibosdiez=DB::table('recibos as re')
			->join('venta as ve','ve.idventa','=','re.idventa')
			-> select('re.idventa',DB::raw('sum(monto) as monto'),'re.fecha','ve.fecha_emi',DB::raw('DATEDIFF(DATE_FORMAT(re.fecha,"%Y-%m-%d"),DATE_FORMAT(ve.fecha_emi,"%Y-%m-%d")) as dias'))  
		//	->whereRaw('DATEDIFF(DATE_FORMAT(ve.fecha_emi,"%Y-%m-%d"),DATE_FORMAT(re.fecha,"%Y-%m-%d")) >= 0')
			->where('re.idempresa','=',$ide)		
			-> where('ve.fecha_emi','>=',$query)
			//-> whereBetween('re.fecha', [$query, $diez])	
			->groupby('re.idrecibo')
			->get();
			//dd($recibosdiez);
				}
		$query2=$query3;
return view('reportes.detallecobranza.index',["nombre"=>$nombre,"vendedor"=>$vendedores,"datos"=>$datos,"recibosdiez"=>$recibosdiez,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
	}
		public function novendido(Request $request)
    {
		//dd();
		$ide=Auth::user()->idempresa;
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
			
			$user_ids = DB::table('detalle_venta')
			->where('idempresa','=',$ide)	
			->whereBetween('fecha', [$query, $query2])	
			->select('idarticulo')
			->groupby('idarticulo');
					
			$datos = DB::table('articulo')
			->where('stock','>',0)
			->where('idempresa','=',$ide)	
			->whereNotIn('idarticulo', $user_ids)
			->get();
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.novendidos.index',["datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
	public function produccion(Request $request)
    {
		//dd($request);
		$ide=Auth::user()->idempresa;
		$corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$tipo=$request->get('tipodoc');
        $query=trim($request->get('searchText'));
        $query2=trim($request->get('searchText2'));
			if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datost=DB::table('ptostado as pt')
            ->join ('tostador as t', 't.id','=','pt.tostador')
			->select ('pt.*','t.nombre')
			->where('pt.idempresa','=',$ide)
            ->whereBetween('pt.fecha', [$query, $query2])
            ->groupby('pt.idt')
            ->get();
		
			$datosp=DB::table('produccion as p')
			->where('p.idempresa','=',$ide)
            ->whereBetween('p.fecha', [$query, $query2])
            ->groupby('p.idproduccion')
            ->get();
			
			 $detalle=DB::table('produccion as pt')
            ->join ('detalle_produccion as dp', 'dp.idproduccion','=','pt.idproduccion')
            ->join ('articulo as art', 'art.idarticulo','=','dp.idarticulo')
			->select ('dp.*','art.nombre')
			->where('pt.idempresa','=',$ide)
            ->whereBetween('pt.fecha', [$query, $query2])
            ->get(); //dd($detalle);
		$query2=date("Y-m-d",strtotime($query2."- 1 days"));
        return view('reportes.produccion.index',["detalle"=>$detalle,"datos"=>$datost,"datosp"=>$datosp,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);    
    }
}