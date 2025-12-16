<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\MetasVendedor;
use sisventas\ArticuloMetasVendedor;
use sisventas\Comisiones;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use Carbon\Carbon;
use Auth;

class MetasVendedorController extends Controller
{
     public function __construct()
    {
     
    }
 public function index(Request $request)
    {
        if ($request)
        {
			$rol=DB::table('roles')-> select('metav')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $metas=DB::table('metasvendedor as v')
			->join('vendedores as vend','vend.id_vendedor','=','v.idvendedor')
            -> where ('v.descripcion','LIKE','%'.$query.'%')   
->orderby('v.idmeta','DESC')			
            ->paginate(20);
	 if($rol->metav){
     return view ('metas.vendedor.index',["metas"=>$metas,"searchText"=>$query,"empresa"=>$empresa]);
	 }else{
			return view('reportes.mensajes.noautorizado');	
		 }
    
        }
    }
	    public function create(){
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
         $vendedores=DB::table('vendedores')->where('estatus','=',1)->get();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",art.stock," - ",art.precio1,"-",art.iva) as articulo'),'art.idarticulo','art.precio1')
        -> where('art.estado','=','Activo')
        -> get();
		$bloques=DB::table('bloques as art')
        -> select(DB::raw('CONCAT(art.idbloque,"-",art.descripcion) as descripcion'),'art.idbloque','art.articulos as precio1')
        -> where('art.estatus','=',0)
        -> get();
		$creci=DB::table('metasvendedor')->where('estatus','=',1)
		->select('idvendedor')->groupby('idvendedor')->get();
		//dd($creci);
        return view("metas.vendedor.create",["bloques"=>$bloques,"creci"=>$creci,"vendedores"=>$vendedores,"articulos"=>$articulos,"empresa"=>$empresa]);
    } 
		    public function store (Request $request)
    {
		//dd($request);
        $categoria=new MetasVendedor;
        $categoria->idvendedor=$request->get('idvendedor');
		$categoria->metodo=$request->get('opmeta');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->inicio=$request->get('inicio');
        $categoria->fin=$request->get('fin');
        $categoria->estatus=0;
        $categoria->cumplimiento=0;
        $categoria->cntarticulos=$request->get('cnt');
        $categoria->valormeta=$request->get('totalo');
        $categoria->nclientes=$request->get('nclientes');
        $categoria->pnclientes=$request->get('pnclientes');
        $categoria->cobranza=$request->get('cobranza');
        $categoria->pcobranza=$request->get('pcobranza');
        $categoria->reactivar=$request->get('reactivar');
        $categoria->preactivar=$request->get('preactivar');
		$categoria->pactivar=$request->get('activar');
		if($request->get('crecimiento')){
        $categoria->crecimiento=$request->get('crecimiento');
        $categoria->pcrecimiento=$request->get('pcrecimiento'); }
        $categoria->particulos=$request->get('particulos');
        $categoria->pcomision=$request->get('pcomision');
		$mytime=Carbon::now('America/Caracas');
		$categoria->creado=$mytime->toDateTimeString();
        $categoria->save();
		
		$idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $costo = $request -> get('precio_compra');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new ArticuloMetasVendedor();
            $detalle->idmeta=$categoria->idmeta;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->valor=($costo[$cont]);
            $detalle->save();    
            $cont=$cont+1;
		}
        return Redirect::to('metas/vendedor');

    }
	public function show($id)  
    { 
	//dd($id);
        $meta=MetasVendedor::findOrFail($id);
		$vendedor=DB::table('vendedores as v')->where('v.id_vendedor','=',$meta->idvendedor)->first();
		$comimeta=DB::table('comision as v')->where('v.idmeta','=',$meta->idmeta)->first();
		//dd($comimeta);
		$nclientes=DB::table('clientes as cl')
		-> select(DB::raw('count(cl.id_cliente) as nuevos'))  
			->whereBetween('cl.creado', [$meta->inicio, $meta->fin])	  
			->where('cl.vendedor','=',$meta->idvendedor)
			->first();
			
			$dias=$meta->cobranza;
            $iniciov = date_create($meta->inicio);  
            date_add($iniciov, date_interval_create_from_date_string('-'.$dias.' day'));
            $iniciov=date_format($iniciov, 'Y-m-d');		
			$cobranza=DB::table('venta as ve')
			->join('recibos as re','re.idventa','=','ve.idventa')
			-> select(DB::raw('count(re.idrecibo) as cobros'),DB::raw('sum(re.monto) as monto'))  
			->whereBetween('ve.fecha_hora', [$iniciov, $meta->fin])	  
			->first();
			//dd($cobranza);
			$diasv=$meta->reactivar;
            $iniv = date_create($meta->inicio);  
            date_add($iniv, date_interval_create_from_date_string('-'.$diasv.' day'));
            $iniv=date_format($iniv, 'Y-m-d');		
			//dd($iniv);
			$reactivar=DB::table('venta as ve')
			->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			-> select(DB::RAW('period_diff( date_format(cl.ultventa, "%y%m" ) , date_format(cl.facanterior, "%y%m" ) ) AS meses') ) 
			->whereBetween('ve.fecha_hora', [$iniv, $meta->fin])	  
			->where('ve.idvendedor','=',$meta->idvendedor)
			->groupBy('cl.id_cliente')
			->get();
		
        $articulos=DB::table('articulometasvendedor as am')
            -> join('articulo as art','art.idarticulo','=','am.idarticulo')
            ->where ('am.idmeta','=',$id)
            ->orderBy('art.nombre','asc')
            ->get();
			
			$datos=DB::table('venta as ve') 
			 ->join('detalle_venta as dv','dv.idventa','=','ve.idventa')
			// ->join('articulometasvendedor as mv','dv.idarticulo','=','mv.idarticulo')
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'dv.idarticulo')         
			->where('ve.devolu','=',0)
			//->where('mv.idmeta','=',$id)
			->where('ve.idvendedor','=',$meta->idvendedor)
			->whereBetween('dv.fecha_emi', [$meta->inicio, $meta->fin])
			->groupby('dv.idarticulo')
            ->get();	
			
				//dd($datos);
		$ventas=DB::table('venta as ven') 		    
            -> select(DB::raw('sum(ven.total_venta) as mventas'))
            ->where('ven.tipo_comprobante','=',"FAC")
            ->where('ven.devolu','=',0)
            ->where('ven.idvendedor','=',$meta->idvendedor)
			->whereBetween('ven.fecha_emi', [$meta->inicio, $meta->fin])
            ->first();
	
		//ecrecimeinto
		$creci=DB::table('metasvendedor')->where('idvendedor','=',$meta->idvendedor)->where('estatus','=',1)
		->select('cumplimiento')->orderby('idmeta','DESC')->first();
		$comision=DB::table('comision')-> join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('comision.id_vendedor','=',$meta->idvendedor)->where('comision.pendiente','>',0)->get();
    // dd($creci);
	$clientesv=DB::table('clientes as cl')
			-> select(DB::raw('count(cl.id_cliente) as clientes'))  	  
			->where('cl.vendedor','=',$meta->idvendedor)
			->first();
			//dd($clientesv);
			$activar=DB::table('venta as ve')
			->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			-> select(DB::raw('count(cl.id_cliente) as clientesventas')) 
			->whereBetween('ve.fecha_hora', [$meta->inicio, $meta->fin])	  
			->where('ve.idvendedor','=',$meta->idvendedor)
			->groupBy('ve.idcliente')
			->first();
	  return view("metas.vendedor.show",["activar"=>$activar,"clientesv"=>$clientesv,"creci"=>$creci,"comimeta"=>$comimeta,"comision"=>$comision,"mventa"=>$ventas,"reactivar"=>$reactivar,"cobranza"=>$cobranza,"nclientes"=>$nclientes,"vendedor"=>$vendedor,"articulos"=>$articulos,"meta"=>$meta,"datos"=>$datos]);
    }
	 public function metabloque($id)
   {	
			
		$meta=MetasVendedor::findOrFail($id);
		$vendedor=DB::table('vendedores as v')->where('v.id_vendedor','=',$meta->idvendedor)->first();
		$comimeta=DB::table('comision as v')->where('v.idmeta','=',$meta->idmeta)->first();
		//dd($comimeta);
		$nclientes=DB::table('clientes as cl')
		-> select(DB::raw('count(cl.id_cliente) as nuevos'))  
			->whereBetween('cl.creado', [$meta->inicio, $meta->fin])	  
			->where('cl.vendedor','=',$meta->idvendedor)
			->first();
		
			$dias=$meta->cobranza;
            $iniciov = date_create($meta->inicio);  
            date_add($iniciov, date_interval_create_from_date_string('-'.$dias.' day'));
            $iniciov=date_format($iniciov, 'Y-m-d');		
			$cobranza=DB::table('venta as ve')
			->join('recibos as re','re.idventa','=','ve.idventa')
			-> select(DB::raw('count(re.idrecibo) as cobros'),DB::raw('sum(re.monto) as monto'))  
			->whereBetween('ve.fecha_hora', [$iniciov, $meta->fin])	  
			->first();
			//dd($cobranza);
			$diasv=$meta->reactivar;
            $iniv = date_create($meta->inicio);  
            date_add($iniv, date_interval_create_from_date_string('-'.$diasv.' day'));
            $iniv=date_format($iniv, 'Y-m-d');		
			//dd($iniv);
			$reactivar=DB::table('venta as ve')
			->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			-> select(DB::RAW('period_diff( date_format(cl.ultventa, "%y%m" ) , date_format(cl.facanterior, "%y%m" ) ) AS meses') ) 
			->whereBetween('ve.fecha_hora', [$iniv, $meta->fin])	  
			->where('ve.idvendedor','=',$meta->idvendedor)
			->groupBy('cl.id_cliente')
			->get();
		
        $articulos=DB::table('articulometasvendedor as am')
            -> join('bloques as art','art.idbloque','=','am.idarticulo')
            ->where ('am.idmeta','=',$id)
            ->orderBy('art.descripcion','asc')
            ->get();						
	//dd($articulos);
					$datos=DB::table('venta as ve') 
			 ->join('detalle_venta as dv','dv.idventa','=','ve.idventa')
			 ->join('detalle_bloque as db','db.idarticulo','=','dv.idarticulo')
			// ->join('articulometasvendedor as mv','dv.idarticulo','=','mv.idarticulo')
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'dv.idarticulo','db.idbloque')         
			->where('ve.devolu','=',0)
			//->where('mv.idmeta','=',$id)
			->where('ve.idvendedor','=',$meta->idvendedor)
			->whereBetween('dv.fecha_emi', [$meta->inicio, $meta->fin])
			->groupby('db.idbloque')
            ->get();
			//
				//
		$ventas=DB::table('venta as ven') 		    
            -> select(DB::raw('sum(ven.total_venta) as mventas'))
            ->where('ven.tipo_comprobante','=',"FAC")
            ->where('ven.devolu','=',0)
            ->where('ven.idvendedor','=',$meta->idvendedor)
			->whereBetween('ven.fecha_emi', [$meta->inicio, $meta->fin])
            ->first();
	
		//ecrecimeinto
		$creci=DB::table('metasvendedor')->where('idvendedor','=',$meta->idvendedor)->where('estatus','=',1)
		->select('cumplimiento')->orderby('idmeta','DESC')->first();
		$comision=DB::table('comision')-> join('vendedores','vendedores.id_vendedor','=','comision.id_vendedor')->where('comision.id_vendedor','=',$meta->idvendedor)->where('comision.pendiente','>',0)->get();
    // dd($creci);
		$clientesv=DB::table('clientes as cl')
			-> select(DB::raw('count(cl.id_cliente) as clientes'))  	  
			->where('cl.vendedor','=',$meta->idvendedor)
			->first();
			//dd($clientesv);
			$activar=DB::table('venta as ve')
			->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			-> select(DB::raw('count(cl.id_cliente) as clientesventas')) 
			->whereBetween('ve.fecha_hora', [$meta->inicio, $meta->fin])	  
			->where('ve.idvendedor','=',$meta->idvendedor)
			->groupBy('ve.idcliente')
			->first();
	  return view("metas.vendedor.show2",["activar"=>$activar,"clientesv"=>$clientesv,"creci"=>$creci,"comimeta"=>$comimeta,"comision"=>$comision,"mventa"=>$ventas,"reactivar"=>$reactivar,"cobranza"=>$cobranza,"nclientes"=>$nclientes,"vendedor"=>$vendedor,"articulos"=>$articulos,"meta"=>$meta,"datos"=>$datos]);
    }
	public function cerrar(Request $request){
	
        $cerrarm=MetasVendedor::findOrFail($request->get('meta'));
        $cerrarm->cumplimiento=$request->get('cumplimiento');
        $cerrarm->estatus=1;
		$cerrarm->update();
	  
		if($request->get('pcomision')>0){
				//dd($request);
			$comi=Comisiones::findOrFail($request->get('pcomision'));
			$mcomi=$comi->montocomision;
			//dd($comi);
				if ($request->get('metodo')==0){
			$mmeta=$mcomi-($mcomi/(($cerrarm->pcomision/100)+1));
			$aux=(($mmeta*$cerrarm->cumplimiento)/100);
				}else{
			$mmeta=$mcomi-($mcomi/(($cerrarm->pcomision/100)+1));
			$aux=0;
				}
			$comi->idmeta=$request->get('meta');
			$comi->mtometa=($mmeta-$aux);
			$comi->pendiente=$mcomi-($mmeta-$aux);
			$comi->update();
		}
    return Redirect::to('metas/vendedor');
       
    } 
		    public function destroy($id)
    {
        $meta=MetasVendedor::findOrFail($id);
        $meta->estatus='2';
        $meta->update();
        return Redirect::to('metas/vendedor');
    }
	public function ajustar(Request $request)
    {
		//dd($request);
		$nv=(($request->get('valorold')/$request->get('cntold'))*$request->get('ncantidad'));
        $det=ArticuloMetasVendedor::findOrFail($request->get('iddetalle'));
		$antv=$det->valor;
		$det->cantidad=$request->get('ncantidad');
		$det->valor=$nv;
        $det->update();

			$agregar=($request->get('ncantidad')-$request->get('cntold'));
			$valor=($nv-$antv);

		$meta=MetasVendedor::findOrFail($request->get('idmeta'));
        $meta->cntarticulos=$meta->cntarticulos+$agregar;		
        $meta->valormeta=$meta->valormeta+$valor;		
        $meta->update();
		
		if($request->get('tipo')==0){
        return Redirect::to('metas/vendedor/'.$request->get('idmeta'));
		}else{
        return Redirect::to('detallemeta/bloque/'.$request->get('idmeta'));
		}
    }
	   public function obsmetavendedor(Request $request,$id)
    {
        $corteHoy = date("Y-m-d");
		$meta=MetasVendedor::findOrFail($id);
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$vendedor=DB::table('vendedores')->where('estatus','=',1)->get();
		$rutas=DB::table('rutas')->get();
		
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             $fecha=trim($request->get('fecha'));
			 $ruta=trim($request->get('ruta'));
             if (($query)==""){$query=$corteHoy; $query2=$corteHoy; }
             if (($fecha)==""){$fecha="fecha"; }
			$query2 = date_create($query2);
           date_add($query2, date_interval_create_from_date_string('0 day'));
            $query2=date_format($query2, 'Y-m-d');
		
        $articulos=DB::table('articulometasvendedor as am')
            -> join('bloques as art','art.idbloque','=','am.idarticulo')
            ->where ('am.idmeta','=',$id)
            ->orderBy('art.descripcion','asc')
            ->get();						
	if($request->get('ruta')){
			$datos=DB::table('venta as ve') 
			 ->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			 ->join('detalle_venta as dv','dv.idventa','=','ve.idventa')
			 ->join('detalle_bloque as db','db.idarticulo','=','dv.idarticulo')
			// ->join('articulometasvendedor as mv','dv.idarticulo','=','mv.idarticulo')
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'dv.idarticulo','db.idbloque')         
			->where('ve.devolu','=',0)
			//->where('mv.idmeta','=',$id)
			->where('ve.idvendedor','=',$meta->idvendedor)
			->where('cl.ruta','=',$ruta)
			->whereBetween('dv.fecha_emi', [$query, $query2])
			->groupby('db.idbloque')
            ->get();
	}else{
			$datos=DB::table('venta as ve') 
			 ->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			 ->join('detalle_venta as dv','dv.idventa','=','ve.idventa')
			 ->join('detalle_bloque as db','db.idarticulo','=','dv.idarticulo')
			// ->join('articulometasvendedor as mv','dv.idarticulo','=','mv.idarticulo')
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'dv.idarticulo','db.idbloque')         
			->where('ve.devolu','=',0)
			//->where('mv.idmeta','=',$id)
			->where('ve.idvendedor','=',$meta->idvendedor)
			->whereBetween('dv.fecha_emi', [$meta->inicio, $meta->fin])
			->groupby('db.idbloque')
            ->get();
	}
			 return view("metas.reporte.index",["rutas"=>$rutas,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2,"vendedor"=>$vendedor,"articulos"=>$articulos,"meta"=>$meta,"datos"=>$datos]);
	}
		    public function obsmetavendedors(Request $request)
    {
		//dd($request);	
		$id=$request->get('id');
        $corteHoy = date("Y-m-d");
		$meta=MetasVendedor::findOrFail($id);
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$vendedor=DB::table('vendedores')->where('estatus','=',1)->get();
		$rutas=DB::table('rutas')->get();
		
             $query=trim($request->get('searchText'));
             $query2=trim($request->get('searchText2'));
             $fecha=trim($request->get('fecha'));
			 $ruta=trim($request->get('ruta'));
             if (($query)==""){$query=$corteHoy; $query2=$corteHoy; }
             if (($fecha)==""){$fecha="fecha"; }
			$query2 = date_create($query2);
           date_add($query2, date_interval_create_from_date_string('0 day'));
            $query2=date_format($query2, 'Y-m-d');
	
        $articulos=DB::table('articulometasvendedor as am')
            -> join('bloques as art','art.idbloque','=','am.idarticulo')
            ->where ('am.idmeta','=',$id)
            ->orderBy('art.descripcion','asc')
            ->get();						
	if($request->get('ruta')){
			$datos=DB::table('venta as ve') 
			 ->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			 ->join('detalle_venta as dv','dv.idventa','=','ve.idventa')
			 ->join('detalle_bloque as db','db.idarticulo','=','dv.idarticulo')
			// ->join('articulometasvendedor as mv','dv.idarticulo','=','mv.idarticulo')
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'dv.idarticulo','db.idbloque')         
			->where('ve.devolu','=',0)
			//->where('mv.idmeta','=',$id)
			->where('ve.idvendedor','=',$meta->idvendedor)
			->where('cl.ruta','=',$ruta)
			->whereBetween('dv.fecha_emi', [$query, $query2])
			->groupby('db.idbloque')
            ->get();
	}else{
			$datos=DB::table('venta as ve') 
			 ->join('clientes as cl','cl.id_cliente','=','ve.idcliente')
			 ->join('detalle_venta as dv','dv.idventa','=','ve.idventa')
			 ->join('detalle_bloque as db','db.idarticulo','=','dv.idarticulo')
			// ->join('articulometasvendedor as mv','dv.idarticulo','=','mv.idarticulo')
            -> select(DB::raw('avg(dv.precio_venta) as vpromedio'),'dv.precio_venta as pventa',DB::raw('sum(dv.cantidad) as vendido'),'dv.idarticulo','db.idbloque')         
			->where('ve.devolu','=',0)
			//->where('mv.idmeta','=',$id)
			->where('ve.idvendedor','=',$meta->idvendedor)
			->whereBetween('dv.fecha_emi', [$meta->inicio, $meta->fin])
			->groupby('db.idbloque')
            ->get();
	}
			 return view("metas.reporte.index",["rutas"=>$rutas,"empresa"=>$empresa,"searchText"=>$query,"searchText2"=>$query2,"vendedor"=>$vendedor,"articulos"=>$articulos,"meta"=>$meta,"datos"=>$datos]);
	}
}
