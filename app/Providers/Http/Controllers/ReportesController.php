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
        if ($request)
        {
			$vendedores=DB::table('vendedores')->get();    
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
			if (($query)==""){$query=$corteHoy; }
             $query2=trim($request->get('searchText2'));
            $query2 = date_create($query2);  
	
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
         //datos venta
	
         if($request->get('vendedor')==0){
            $datos=DB::table('venta as v')
			-> join('clientes as c','v.idcliente','=','c.id_cliente')
			-> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
			->select('v.idventa','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
			-> whereBetween('v.fecha_emi', [$query, $query2])
			-> groupby('v.idventa')
            ->get();
				// dd($datos);
			// pagos
			  $pagos=DB::table('recibos as re')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
		 ->where('re.monto','>',0)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
        //datos devolucion     
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.monto) as totaldev'))
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
		 //dd($devolucion);   
		 }else{
			$datos=DB::table('venta as v')
      -> join('clientes as c','v.idcliente','=','c.id_cliente')
	  -> join ('vendedores as ven','ven.id_vendedor','=','c.vendedor')
	  ->select('v.idventa','c.nombre','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','ven.nombre as vendedor','v.user')
	  -> where('ven.id_vendedor','=',$request->get('vendedor'))
			-> whereBetween('v.fecha_emi', [$query, $query2])
			-> groupby('v.idventa')
            ->get(); 
	
				  $pagos=DB::table('recibos as re')
				  ->join('venta as v','v.idventa','=','re.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
				  ->join('vendedores as ve','ve.id_vendedor','=','cli.vendedor')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
		 -> where('ve.id_vendedor','=',$request->get('vendedor'))
		 ->where('re.monto','>',0)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idpago')
            ->get(); 		
			
			 $devolucion=DB::table('devolucion as d')
			      -> join('recibos as r','r.idventa','=','d.idventa')
				  ->join('venta as v','v.idventa','=','r.idventa')
				  ->join('clientes as cli','cli.id_cliente','=','v.idcliente')
				  ->join('vendedores as ve','ve.id_vendedor','=','cli.vendedor')
            -> select(DB::raw('sum(r.monto) as totaldev'))
			-> where('ve.id_vendedor','=',$request->get('vendedor'))
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
		 }
	  $query2=date("Y-m-d",strtotime($query2."- 1 days"));
        return view('reportes.ventas.index',["datos"=>$datos,"devolucion"=>$devolucion,"empresa"=>$empresa,"pagos"=>$pagos,"vendedores"=>$vendedores,"searchText"=>$query,"searchText2"=>$query2]);
       
  }
  
}

    public function show($id)
    {   
	     $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> select ('v.idventa','v.fecha_hora','p.nombre','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.devolu','v.total_venta')
            ->where ('v.idventa','=',$id)
            -> first();

            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.idarticulo','dv.cantidad','dv.iddetalle_venta','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$id)
            ->get();
            return view("reportes.devolucion.index",["venta"=>$venta,"detalles"=>$detalles,"recibo"=>$recibo,"empresa"=>$empresa]);
      
    }
    public function store(DevolucionFormRequest $request){

//registra la venta
$user=Auth::user()->name;
    $devolucion=new Devolucion;
    $devolucion->idventa=$request->get('idventa');
    $devolucion->comprobante=$request->get('comprobante');
    $mytime=Carbon::now('America/Lima');
    $devolucion->fecha_hora=$mytime->toDateTimeString();
    $devolucion->user=$user;
	//dd($devolucion);
	$devolucion-> save();

    $venta=Venta::findOrFail( $devolucion->idventa);
    $venta->devolu='1';
	$venta->saldo='0';
    $venta->update();
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
return Redirect::to('ventas/venta');
}
    
     public function caja(Request $request)
    {
	
		$corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$tipo=$request->get('tipodoc');
        $query=trim($request->get('searchText'));
        $query2=trim($request->get('searchText2'));
			if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('ingreso as c')
            ->join ('proveedor as p', 'c.idproveedor','=','p.idproveedor')
			->select ('c.idingreso','c.base','c.miva','c.exento','c.num_comprobante','c.estado','c.total','c.saldo','c.fecha_hora','p.nombre','p.rif','tipo_comprobante')
			->where('tipo_comprobante','=',$tipo)
            ->whereBetween('c.fecha_hora', [$query, $query2])
            ->groupby('c.idingreso')
            ->get();
         // dd($datos);
			$pagos=DB::table('comprobante as re')->join('ingreso','ingreso.idingreso','=','re.idcompra')
			-> where('ingreso.tipo_comprobante','=',$tipo)
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
            -> whereBetween('re.fecha_comp', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
		$query2=date("Y-m-d",strtotime($query2."- 1 days"));
        return view('reportes.compras.index',["datos"=>$datos,"pagos"=>$pagos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);    
    }
	     public function gastos(Request $request)
    {
	
		$corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
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
            ->whereBetween('c.fecha', [$query, $query2])
            ->groupby('c.idgasto')
            ->get();
			$pagos=DB::table('comprobante as re')->join('gasto','gasto.idgasto','=','re.idgasto')
			-> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
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
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $lista=DB::table('articulo')
			->where('articulo.stock','>',0)
			->where('articulo.estado','=',"Activo")
			->OrderBy('articulo.nombre')
           ->get();
        return view('reportes.valorizado.index',["lista"=>$lista,"empresa"=>$empresa]);
            
    }
     public function inventario(Request $request)
    {   
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $lista=DB::table('articulo as art')->join('categoria as cat','cat.idcategoria','=','art.idcategoria')
		->select('art.nombre as nombre','art.stock','art.codigo','art.utilidad','art.util2','art.precio1','art.precio2','art.costo','art.iva')
		->where('art.estado','=',"Activo")
		->where('cat.servicio','=',0)
		->OrderBy('art.nombre')
        ->get();
        return view('reportes.inventario.index',["lista"=>$lista,"empresa"=>$empresa]);          
    }
	 public function listaprecio(Request $request)
    {   
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $lista=DB::table('articulo as art')->join('categoria as cat','cat.idcategoria','=','art.idcategoria')
		->select('art.nombre as nombre','art.stock','art.precio1','art.precio2','art.costo','art.iva')
		->where('art.stock','>',0)
		->where('art.estado','=',"Activo")
		->where('cat.servicio','=',0)
		->OrderBy('art.nombre')
        ->get();
        return view('reportes.inventario.listaprecio',["lista"=>$lista,"empresa"=>$empresa]);          
    }
	public function cero(Request $request)
    {   
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $lista=DB::table('articulo as art')->join('categoria as cat','cat.idcategoria','=','art.idcategoria')
		->select('art.codigo','art.utilidad','art.util2','art.nombre as nombre','art.stock','art.precio1','art.precio2','art.costo','art.iva')
		->where('art.stock','<=',0)
		->where('art.estado','=',"Activo")
		->where('cat.servicio','=',0)
		->OrderBy('art.nombre')
        ->get();
        return view('reportes.inventario.cero',["lista"=>$lista,"empresa"=>$empresa]);
            
    }
	    public function utilidad(Request $request)
    {   
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        if ($request)
        {
			$corteHoy = date("Y-m-d");
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
            $query2 = date_create($query2);
			if (($query)==""){$query=$corteHoy; }
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
         //datos venta
		    $resumen=($request->get('check'));    
			if ($resumen=="on"){    
			$datos=DB::table('venta as v')
			-> join('detalle_venta as dv','v.idventa','=','dv.idventa')
			-> join('articulo as a','dv.idarticulo','=','a.idarticulo')
			-> select('v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.total_venta','v.fecha_hora','a.idarticulo',DB::raw('dv.cantidad*0 as cantidad'),DB::raw('a.costo*0 as costo'),'a.iva',DB::raw('dv.precio_venta*0 as precio_venta'),DB::raw('sum(dv.cantidad * dv.costoarticulo) as costoneto'),DB::raw('sum(dv.cantidad*dv.precio_venta)as ventaneta'))	
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> Groupby('dv.idventa')      
			->get();
				}else{
			$datos=DB::table('venta as v')
			-> join('detalle_venta as dv','v.idventa','=','dv.idventa')
			-> join('articulo as a','dv.idarticulo','=','a.idarticulo')
			-> select('v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.total_venta','v.fecha_hora','a.idarticulo','dv.cantidad as cantidad','a.costo','a.iva','dv.precio_venta',DB::raw('(dv.cantidad * dv.costoarticulo) as costoneto'),DB::raw('(dv.cantidad*dv.precio_venta)as ventaneta'))
   
			-> whereBetween('v.fecha_hora', [$query, $query2])
			->get();
			}
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.aux) as totaldev'))
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
       //dd($devolucion);   
	   $query2=date("Y-m-d",strtotime($query2."- 1 days"));
       return view('reportes.utilidad.index',["datos"=>$datos,"devolucion"=>$devolucion,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
       
    }
            
    }
	public function corte(Request $request)
    {   
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$usuario=DB::table('users')->get();
	 //dd($request->get('usuario'));
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
		  $user=$request->get('usuario');
		 //datos v
		    if($request->get('usuario') == NULL){
            $datos=DB::table('venta as v')
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> groupby('v.idventa')
            ->get();
				//dd($datos);
			//ventas impuestos
			$impuestos=DB::table('detalle_venta as dv')
			-> join('articulo as art','dv.idarticulo','=','art.idarticulo')
			-> join('venta as v','dv.idventa','=','v.idventa')
			-> select(DB::raw(('sum(((dv.precio_venta*dv.cantidad)/((art.iva/100)+1))) as gravado')),DB::raw('sum(dv.precio_venta*dv.cantidad) as montoventa'),'art.iva','v.fecha_hora')
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> groupby('art.iva')
			->get();
		//
        //datos devolucion     
             $devolucion=DB::table('devolucion as d')
            -> join('recibos as r','r.idventa','=','d.idventa')
            -> select(DB::raw('sum(r.monto) as totaldev'))
            ->whereBetween('d.fecha_hora', [$query, $query2])
            ->get();
			//dd($devolucion);
			//cobros directos
			$pagos=DB::table('recibos as re')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"P")
			-> groupby('re.idpago')
            ->get();
      // dd($query);   
			$cobranza=DB::table('recibos as re')
         -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
            -> whereBetween('re.fecha', [$query, $query2])
			-> where ('re.tiporecibo','=',"A")
			-> groupby('re.idpago')
            ->get();
			$ingresos=DB::table('recibos as re')
			 -> select(DB::raw('sum(re.monto) as monto'),DB::raw('sum(re.recibido) as recibido'),'re.idbanco','re.idpago')
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idpago')
            ->get();
			$comisiones=DB::table('recibo_comision as re')
			-> select(DB::raw('sum(re.monto) as monto'))
            -> whereBetween('re.fecha', [$query, $query2])
            ->first();
			//dd($comisiones);
			
			$ingresosnd=DB::table('mov_notas as n')
			->join('venta','venta.idventa','=','n.iddoc')
            -> select(DB::raw('sum(n.monto) as recibido'))
            -> whereBetween('n.fecha', [$query, $query2])
			-> groupby('n.tipodoc')
            ->first();
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
				  } else {
		    $datos=DB::table('venta as v')
			-> whereBetween('v.fecha_hora', [$query, $query2])
			-> where ('user','=',$user)
			-> groupby('v.idventa')
            ->get();
			//dd($datos);
			//ventas impuestos
			$impuestos=DB::table('detalle_venta as dv')
			-> join('articulo as art','dv.idarticulo','=','art.idarticulo')
			-> join('venta as v','dv.idventa','=','v.idventa')
			-> select(DB::raw(('sum(((dv.precio_venta*dv.cantidad)/((art.iva/100)+1))) as gravado')),DB::raw('sum(dv.precio_venta*dv.cantidad) as montoventa'),'art.iva','v.fecha_hora')
			-> where ('v.user','=',$user)
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
			//dd($ingresosnd);
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));			  
				  }
		}
        return view('reportes.corte.index',["datos"=>$datos,"devolucion"=>$devolucion,"impuestos"=>$impuestos,"comision"=>$comisiones,"empresa"=>$empresa,"ingresos"=>$ingresos,"cobranza"=>$cobranza,"pagos"=>$pagos,"searchText"=>$query,"searchText2"=>$query2,"usuario"=>$usuario,"ingresosnd"=>$ingresosnd]);
       
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
	
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$vendedor=DB::table('vendedores')->get();
		$clientes=DB::table('clientes')->get();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')			
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.fecha', [$query, $query2])
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->where('ve.idvendedor','=',$request->get('vendedor'))
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();
			$busqueda=DB::table('vendedores')-> where('id_vendedor','=',$request->get('vendedor'))->select('nombre')->first();
			
			if($request->get('vendedor')==0){
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')			
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.fecha', [$query, $query2])
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();			
			$busqueda=[];
			}
		//	dd($datos);
		if($request->get('cliente')>0){
            $datos=DB::table('detalle_venta as dv') 
			 ->join('venta as ve','ve.idventa','=','dv.idventa')			
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.fecha', [$query, $query2])
			->where('ve.idcliente','=',$request->get('cliente'))
			->where('ve.devolu','=',0)
			->where('a.estado','=',"Activo")
			->where('ca.servicio','=',0)
			->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();			
			$busqueda=DB::table('clientes')-> where('id_cliente','=',$request->get('cliente'))->select('nombre')->first();
		//dd($busqueda);
		}
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.ventasarticulo.index',["busqueda"=>$busqueda,"clientes"=>$clientes,"vendedor"=>$vendedor,"datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
	    public function comprasarticulo(Request $request)
    {
        $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             if (($query)==""){$query=$corteHoy; }
			$query2 = date_create($query2);
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
            $datos=DB::table('detalle_ingreso as dv')            
             ->join ('articulo as a', 'a.idarticulo','=','dv.idarticulo') 
             ->join ('categoria as ca','ca.idcategoria','=','a.idcategoria')      
            -> select(DB::raw('avg(dv.precio_compra) as vpromedio'),DB::raw('avg(dv.subtotal) as subtotal'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'a.nombre','a.idarticulo','ca.nombre as grupo')
            ->whereBetween('dv.fecha', [$query, $query2])
            ->groupby('dv.idarticulo')
			->OrderBy('a.nombre')
            ->get();
			$query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.comprasarticulo.index',["datos"=>$datos,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
            
    }
	public function info()
    {
           $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        return view('reportes.mensajes.info',["empresa"=>$empresa]);
    }
	 public function resumen()
    {
           $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		    $compras=DB::table('ingreso as c')
            ->join ('proveedor as p', 'c.idproveedor','=','p.idproveedor')
			->select (DB::raw('sum(c.total) as vtotal'),DB::raw('sum(c.saldo) as vsaldo'),'c.idingreso','c.base','c.serie_comprobante','c.estado','c.total','c.saldo','c.fecha_hora','p.nombre','p.rif','p.telefono')
			->where('c.saldo','>',0)
		    ->get();
		  $gastos=DB::table('gasto as g')
            ->join ('proveedor as p', 'g.idpersona','=','p.idproveedor')
			->select (DB::raw('sum(g.monto) as vtotal'),DB::raw('sum(g.saldo) as vsaldo'),'g.idgasto','g.saldo','g.monto','g.documento','g.fecha','p.nombre','p.rif','p.telefono')
          ->where('g.saldo','>',0)
          ->where('g.estatus','=',0)
            ->groupby('g.idgasto')
            ->get();
			$ventas=DB::table('venta as v')
            ->join ('clientes as c', 'c.id_cliente','=','v.idcliente')
			->select (DB::raw('sum(v.total_venta) as vtotal'),DB::raw('sum(v.saldo) as vsaldo'),'c.id_cliente','v.tipo_comprobante','v.num_comprobante','v.total_venta','v.saldo','c.nombre','c.telefono','c.cedula')
          ->where('v.saldo','>',0)
          ->where('v.devolu','=',0)
		  ->where('v.tipo_comprobante','=','FAC')
            ->groupby('v.idcliente')
            ->get();
			

		//	dd($ventas);
			$valor=DB::table('articulo as dv')
			-> select(DB::raw('sum(dv.stock*dv.costo) as val_costo'),DB::raw('sum(dv.stock*dv.precio1) as val_precio'))
			->first(); 
				$q2=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select(DB::raw('sum(n.pendiente) as saldo'),DB::raw('sum(n.monto) as monto'),'c.id_cliente','c.nombre')
			->where('n.tipo','=',1)->where('n.pendiente','>',0)
			->groupby('n.idcliente')
			->get();
//dd($q2);			
			$clientes=DB::table('clientes')->get();			
			$proveedores=DB::table('proveedor')->get();			
			$articulos=DB::table('articulo')->get();			
        return view('reportes.resumen.index',["clientes"=>$clientes,"articulos"=>$articulos,"proveedores"=>$proveedores,"notas"=>$q2,"valor"=>$valor,"ventas"=>$ventas,"compras"=>$compras,"gastos"=>$gastos,"empresa"=>$empresa]);    

   }
	public function cobranza(Request $request)
    {   
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
		   $vendedores=DB::table('vendedores')->get();         
		   if($request->get('vendedor')==0){
			$cobranza=DB::table('recibos as re')
			->join('venta','venta.idventa','=','re.idventa' )
			->join('clientes','clientes.id_cliente','=','venta.idcliente')
			->join('vendedores as vende','vende.id_vendedor','=','clientes.vendedor')
			-> select('clientes.nombre','re.referencia','re.tiporecibo','venta.tipo_comprobante','venta.num_comprobante','re.idbanco','re.idpago','re.idrecibo','re.monto','re.recibido','re.fecha','vende.nombre as vendedor')    
			-> where('venta.devolu','=',0)
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idrecibo')
            ->get();
            $comprobante=DB::table('recibos')
            -> select(DB::raw('sum(recibido) as mrecibido'),DB::raw('sum(monto) as mmonto'),'idbanco','tiporecibo')        
            -> whereBetween('fecha', [$query, $query2])
            ->groupby('idpago')
            ->get();
		   	//dd($cobranza);
			$ingresosnd=DB::table('recibos as re')
			-> join('notasadm as n','n.idnota','=','re.idnota')
			->join('clientes','clientes.id_cliente','=','n.idcliente')
            -> select('clientes.nombre','re.referencia','re.tiporecibo','n.idnota as tipo_comprobante','n.idnota as num_comprobante','re.idbanco','re.idrecibo','re.idpago','re.monto','re.recibido','re.fecha','n.usuario as vendedor')
            -> whereBetween('re.fecha', [$query, $query2])
			-> groupby('re.idrecibo')
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> whereBetween('mov.fecha', [$query, $query2])
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
				-> select(DB::raw('sum(recibido) as mrecibido'),DB::raw('sum(monto) as mmonto'),'idbanco','tiporecibo')
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
				$recibonc=DB::table('mov_notas as mov')-> whereBetween('mov.fecha', [$query, $query2])
				->get();
			   }
		   $query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.cobranza.index',["comprobante"=>$comprobante,"vendedores"=>$vendedores,"empresa"=>$empresa,"cobranza"=>$cobranza,"searchText"=>$query,"searchText2"=>$query2,"ingresosnd"=>$ingresosnd,"recibonc"=>$recibonc]);
       
		}
	}
    public function pagos(Request $request)
    {   
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
   
			$pagos=DB::table('comprobante as co')
			->join('ingreso','ingreso.idingreso','=','co.idcompra' )
			->join('proveedor as p','p.idproveedor','=','ingreso.idproveedor')
           -> select('p.nombre','co.referencia','ingreso.tipo_comprobante','ingreso.num_comprobante','co.idbanco','co.idpago','co.idrecibo','co.monto','co.recibido','co.fecha_comp as fecha','ingreso.user as vendedor')
			-> where('ingreso.estatus','=',"")
            -> whereBetween('co.fecha_comp', [$query, $query2])
			-> groupby('co.idrecibo')
            ->get();
			$gastos=DB::table('comprobante as co')
			->join('gasto','gasto.idgasto','=','co.idgasto' )
			->join('proveedor as p','p.idproveedor','=','gasto.idpersona')
           -> select('p.nombre','co.referencia','gasto.documento','co.idbanco','co.idpago','co.idrecibo','co.monto','co.recibido','co.fecha_comp as fecha','gasto.usuario as vendedor')
            -> whereBetween('co.fecha_comp', [$query, $query2])
			-> groupby('co.idrecibo')
            ->get();
			
            $desglose=DB::table('comprobante')->select(DB::raw('sum(recibido) as recibido'),DB::raw('sum(monto) as monto'),'idbanco')
            -> whereBetween('fecha_comp', [$query, $query2])
            ->groupby('idpago')
            ->get();
			//dd($desglose);
		   $query2=date("Y-m-d",strtotime($query2."- 1 days"));
			return view('reportes.pagos.index',["comprobante"=>$desglose,"empresa"=>$empresa,"gastos"=>$gastos,"pagos"=>$pagos,"searchText"=>$query,"searchText2"=>$query2]);
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
			$mov=DB::table('reg_deposito as de')
			->join('deposito','deposito.id_deposito','=','de.deposito')
		->join('articulo','articulo.idarticulo','=','de.idarticulo')
		->where('deposito.tipo_p','=',"C")
        -> select('de.*','articulo.nombre','deposito.id_persona')
        ->get();
     $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
	 $vendedores=DB::table('vendedores')->get();
            $datos=DB::table('clientes')->select('id_cliente','nombre','cedula','licencia','telefono','direccion')
            -> where('ruta','=',$request->get('ruta'))
            -> where('vendedor','=',$request->get('vendedor'))
            ->get();
return view('reportes.ruta.index',["mov"=>$mov,"datos"=>$datos,"empresa"=>$empresa,"ruta"=>$request->get('ruta'),"vendedores"=>$vendedores]);
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
		$municipios=DB::table('municipios')->get();
		$notas=DB::table('notasadm')
		->select('idcliente',DB::raw('sum(pendiente) as deuda'))
		->where('pendiente','>',0)
		->where('tipo','=',1)
		->groupby('idcliente')
		->get();
		$sectores=DB::table('parroquias')->get();
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();

      if ($request->get('filtro'))
        {
			if($request->get('filtro')=="municipios"){
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('municipios as m','m.id_municipio','=','c.idmunicipio')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select('c.*','m.municipio as nsector','v.id_vendedor',DB::raw('sum(ve.saldo) as saldoc'))
			->where('c.idmunicipio','=',$request->get('idm'))
			->where('ve.devolu','=',0)
			->groupby('c.id_cliente')
			->get();	
			}		
			if($request->get('filtro')=="parroquias"){
			$clientes=DB::table('clientes as c')
	 		-> join('vendedores as v','c.vendedor','=','v.id_vendedor')
			->join('parroquias as p','p.id_parroquia','=','c.idsector')
			->leftjoin('venta as ve','ve.idcliente','=','c.id_cliente')
			->select('c.*','p.parroquia as nsector','v.id_vendedor',DB::raw('sum(ve.saldo) as saldoc'))
			->where('c.idsector','=',$request->get('ids'))
			->where('ve.devolu','=',0)
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
			->groupby('c.id_cliente')
			->get();
		}
			//dd($clientes);
return view('reportes.clientesectores.index',["notas"=>$notas,"municipios"=>$municipios,"sectores"=>$sectores,"clientes"=>$clientes,"empresa"=>$empresa]);
	}
		public function seguimiento(Request $request)
{     
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$dias=$request->get('dias');
			if (($dias)==""){$dias=365; }
			$corteHoy = date("Y-m-d"); 
           $query2 = date_create($corteHoy);  
           $query2=date_format($query2, 'Y-m-d');
		      $query2=date("Y-m-d",strtotime($query2."- ".$dias."days"));
	//
	//dd($query2);
		if($request->get('vednedor')==NULL){
            $datos=DB::table('venta as v')
			-> join('clientes as c','c.id_cliente','=','v.idcliente')
			->select('v.idventa','v.idcliente','c.ultventa','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','v.user')
			-> where('v.fecha_emi','>',$query2)
			-> groupby('v.idventa')
            ->get();
		}else{
			$datos=DB::table('venta as v')
			-> join('clientes as c','c.id_cliente','=','v.idcliente')
			->select('v.idventa','v.idcliente','c.ultventa','v.tipo_comprobante','v.num_comprobante','v.estado','v.total_venta','v.saldo','v.fecha_emi as fecha_hora','v.fecha_emi','v.saldo','v.devolu','v.user')
			-> where('v.idvendedor','=',$request->get('vendedor'))
			-> where('v.fecha_emi','>',$query2)
			-> groupby('v.idventa')
            ->get();
		}	
		$mov=DB::table('clientes')->get();
		$vendedores=DB::table('vendedores')->get();
	//	->rightjoin('clientes','clientes.id_cliente','=','ve.idcliente')
		//->where ('ve.idcliente','=',null)
     //   -> select('clientes.*')
      //  ->get();
//dd($mov);
return view('reportes.seguimiento.index',["vendedores"=>$vendedores,"clientes"=>$mov,"ventas"=>$datos,"empresa"=>$empresa,"query"=>$dias]);
	}
	
	public function analisiscobros(Request $request)

	{		
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
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
			-> where('ve.devolu','=',0)
			-> where('ve.fecha_emi','<',$query)
            ->first();	
			$cxcvende=DB::table('venta as ve')
			->join('vendedores as vnd','vnd.id_vendedor','=','ve.idvendedor')
			->select(DB::raw('sum(ve.saldo) as saldoc'),'vnd.nombre')
			-> where('ve.tipo_comprobante','=',"FAC")
			-> where('ve.devolu','=',0)
			-> where('ve.fecha_emi','<',$query)
			->groupby('ve.idvendedor')
            ->get();
			$cxcperiodo=DB::table('venta as ve')
			->select(DB::raw('sum(ve.total_venta) as tventa'),DB::raw('sum(ve.saldo) as saldoc'))
			-> where('ve.tipo_comprobante','=',"FAC")
			-> where('ve.devolu','=',0)
			-> whereBetween('ve.fecha_emi', [$query, $query2])
            ->first();
		
			$cxcpervend=DB::table('venta as ve')
				->join('vendedores as vnd','vnd.id_vendedor','=','ve.idvendedor')
				->select(DB::raw('sum(ve.total_venta) as tventa'),DB::raw('sum(ve.saldo) as saldoc'),'vnd.nombre')
			-> where('ve.tipo_comprobante','=',"FAC")
			-> where('ve.devolu','=',0)
			-> whereBetween('ve.fecha_emi', [$query, $query2])
            ->groupby('ve.idvendedor')
            ->get();
			//dd($cxcvende);
			$cobranza=DB::table('recibos as re')
			 -> select('re.idbanco','re.tiporecibo',DB::raw('sum(re.monto) as rmonto'),DB::raw('sum(re.recibido) as rrecibido'))  
				-> where('re.idnota','=',0)
				-> whereBetween('re.fecha', [$query, $query2])
				-> groupby('re.idpago','re.tiporecibo')
				->get();
			$cobranzand=DB::table('recibos as re')
			 -> select('re.idbanco','re.tiporecibo',DB::raw('sum(re.monto) as rmonto'),DB::raw('sum(re.recibido) as rrecibido'))  
				-> where('re.idnota','>',0)
				-> whereBetween('re.fecha', [$query, $query2])
				-> groupby('re.idpago','re.tiporecibo')
				->get();
			//	dd($cobranza);
				$ingresosnc=DB::table('mov_notas as n')
            -> select(DB::raw('sum(n.monto) as recibido'))
            -> whereBetween('n.fecha', [$query, $query2])
			-> groupby('n.tipodoc')
            ->first();
			//dd($ingresosnd);
		$notas=DB::table('notasadm')
		->select(DB::raw('sum(monto) as mnota'),DB::raw('sum(pendiente) as deuda'))
		->where('pendiente','>',0)
		->where('tipo','=',1)
		-> where('fecha','<',$query2)
		->groupby('tipo')
		->first();
		//dd($query);
		$query2=trim($request->get('searchText2'));
return view('reportes.ventacobranza.index',["notas"=>$notas,"ingresosnc"=>$ingresosnc,"cobranzand"=>$cobranzand,"cobranza"=>$cobranza,"cxcpervend"=>$cxcpervend,"cxcvende"=>$cxcvende,"cxcante"=>$cxcante,"cxcperiodo"=>$cxcperiodo,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2]);
	}
}