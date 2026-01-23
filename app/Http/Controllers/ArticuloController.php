<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Articulo;
use sisventas\Existencia;
use sisventas\Vendedores;
use sisventas\DetalleIngreso;
use sisventas\ReportesController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ArticuloFormRequest;
use DB;
use Auth;

class ArticuloController extends Controller
{
      public function __construct()
    {
     
    }
    public function index(Request $request)
    {
        if ($request)
        {
			$ide=Auth::user()->idempresa;
			
			$rol=DB::table('roles')-> select('newarticulo','editarticulo','web')->where('iduser','=',$request->user()->id)->first();
           $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
              $articulos=DB::table('articulo as a')
			-> join('categoria as c','a.idcategoria','=','c.idcategoria')
			-> select ('a.idarticulo','a.nombre','a.precio1','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
             ->where('a.idempresa','=',$ide)
			->where('a.nombre','LIKE','%'.$query.'%')
            ->where('a.estado','=','Activo')         
            ->orderBy('a.idarticulo','desc')
			->groupBY('a.idarticulo')
            ->paginate(20);
			$existencia=DB::table('existencia as e')
			->join('depvendedor as de','de.id_deposito','=','e.id_almacen')
			 ->where('e.idempresa','=',$ide)
			->get();
			//dd($existencia);
            return view('almacen.articulo.index',["rol"=>$rol,"articulos"=>$articulos,"empresa"=>$empresa,"existencia"=>$existencia,"searchText"=>$query]);
        }
    }
    public function create(Request $request)
    {
		$ide=Auth::user()->idempresa;
    	$categorias=DB::table('categoria')->where('idempresa','=',$ide)->where('condicion','=',1)->get();
	$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        return view("almacen.articulo.create",["categorias"=>$categorias,"empresa"=>$empresa]);
    }
	  public function newcreate()
    {
		
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();
//dd($categorias);
        return view("almacen.articulo.newcreate",["categorias"=>$categorias]);
    }
 public function store (ArticuloFormRequest $request)
    {
	
		$ide=Auth::user()->idempresa;
        $validar=$request->get('codigo');
          try{
    DB::beginTransaction();
       // $articulos=Articulo::findOrFail($request->get('codigo'));
		$articulo=new Articulo;
        $articulo->idempresa=$ide;
        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=0;
        $articulo->descripcion=$request->get('descripcion');
        $articulo->estado='Activo';
        $articulo->utilidad=$request->get('utilidad');
		$articulo->unidad=$request->get('unidad');
        $articulo->precio1=$request->get('precio1');
        $articulo->precio2=$request->get('precio2');
         $articulo->util2=$request->get('util2');
        $articulo->costo=$request->get('costo');
        $articulo->vacio=$request->get('vacio');
        $articulo->volumen=$request->get('volumen');
        $articulo->grados=$request->get('grados');
		$articulo->pesogr=$request->get('peso');
		$articulo->sevende=$request->get('sevende');
		$articulo->clase=$request->get('clase');
        $articulo->origen=$request->get('origen');
        if($request->get('nivelp')){$articulo->mprima=$request->get('mprima'); }else{ $articulo->mprima=0;}
        	if($request->get('nivelp')){ $articulo->nivelp=$request->get('nivelp'); }else{ $articulo->nivelp=0;}
        //validar iva vacio
        $articulo->iva=$request->get('impuesto');
		$articulo->fraccion=$request->get('fraccion');
		if($request->get('comi')){$articulo->comi=$request->get('comi');}else{ $articulo->comi=0;}
		$articulo->pcomision=$request->get('porcentaje');
        
         if (input::hasfile($request->get('imagen'))){
        	$file=input::file('imagen');
        	$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        	$articulo->imagen=$file->getClientOriginalName();
        }

        $articulo->save();
		    $deposito=DB::table('depvendedor')->select('id_deposito','idvendedor')
            ->where('idempresa','=',$ide)
			->orderBy('id_deposito','asc')			
            ->first();
				$exis=new Existencia();
				  $exis->idempresa=$ide;
				  $exis->id_almacen=$deposito->id_deposito;
				  $exis->idarticulo=$articulo->idarticulo;
				  $exis->existencia=0;
				  $exis->save(); 
              DB::commit();
}
catch(\Exception $e)
{
    DB::rollback(); 
        $articulos=DB::table('articulo')->where('codigo','=',$validar)->first();
         $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        return view("almacen/articulo.edit",["articulo"=>$articulos,"categorias"=>$categorias]);
}
        return Redirect::to('almacen/articulo');

    }
    public function show($id)
    {
		//compra
		$ultcompra=DB::table('detalle_ingreso as di')
		->join('ingreso as in','in.idingreso','=','di.idingreso')
		->join('proveedor as p','p.idproveedor','=','in.idproveedor')
		->select('p.nombre','in.num_comprobante','in.fecha_hora','di.cantidad','di.precio_compra')->where('di.idarticulo','=',$id)
		->orderby('di.iddetalle_ingreso','des')->first();
		//venta
		$ultventa=DB::table('detalle_venta as dv')
		->join('venta as v','v.idventa','=','dv.idventa')
		->join('clientes as c','c.id_cliente','=','v.idcliente')
		->select('c.nombre','v.tipo_comprobante','v.num_comprobante','v.fecha_emi','dv.cantidad','dv.precio_venta')->where('dv.idarticulo','=',$id)
		->orderby('dv.iddetalle_venta','des')->first();
		//dd($ultventa);
		//ajustes
		$ajustes=DB::table('detalle_ajuste')->select(DB::raw('sum(cantidad) as cantidad'),'tipo_ajuste')
		->where('idarticulo','=',$id)
		->groupBy('tipo_ajuste')->get();
			$hoy = date("Y-m-d");  
		  $analisis=date("Y-m-d",strtotime($hoy."- 30 days"));
		  $analisisventa=DB::table('detalle_venta')->select(DB::raw('sum(cantidad) as cantidad'))
		  ->whereBetween('fecha_emi', [$analisis, $hoy])
		  ->where('idarticulo','=',$id)
			->first();
		   $analisiscompra=DB::table('detalle_ingreso')->join('ingreso','ingreso.idingreso','=','detalle_ingreso.idingreso')->select(DB::raw('sum(detalle_ingreso.cantidad) as cantidad'))
		  ->whereBetween('ingreso.fecha_hora', [$analisis, $hoy])
		  ->where('detalle_ingreso.idarticulo','=',$id)
			->first();
			$compras=DB::table('detalle_ingreso')->select(DB::raw('sum(cantidad) as cantidad'),DB::raw('sum(precio_compra) as precio'),DB::raw('count(idingreso) as compra'))->where('idarticulo','=',$id)->first();
			$ventas=DB::table('detalle_venta')->select(DB::raw('sum(cantidad) as cantidad'),DB::raw('sum(precio_venta) as precio'),DB::raw('count(idventa) as venta'))->where('idarticulo','=',$id)->first();
			$devcompras=DB::table('detalle_devolucioncompras')->select(DB::raw('sum(cantidad) as devocompras'))->where('codarticulo','=',$id)->first();
			$deventas=DB::table('detalle_devolucion')->select(DB::raw('sum(cantidad) as devoventas'))->where('idarticulo','=',$id)->first();
			$util=DB::table('detalle_venta')->select(DB::raw('sum(costoarticulo*cantidad) as costo'),DB::raw('sum(precio_venta*cantidad) as precio'))->where('idarticulo','=',$id)->first();
		  return view("almacen/articulo/show",["articulo"=>Articulo::findOrFail($id),"ultcompra"=>$ultcompra,"ultventa"=>$ultventa,"ajustes"=>$ajustes,"analisisventa"=>$analisisventa,"analisiscompra"=>$analisiscompra,"compras"=>$compras,"ventas"=>$ventas,"devcompras"=>$devcompras,"deventas"=>$deventas,"util"=>$util]);

    }
       public function edit($id)
    {
    	 $articulos=Articulo::findOrFail($id);
    	 $categorias=DB::table('categoria')->where('condicion','=','1')->get();
		 $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        return view("almacen/articulo.edit",["articulo"=>$articulos,"categorias"=>$categorias,"empresa"=>$empresa]);
    }
    public function update(ArticuloFormRequest $request,$id)
    {
	//	dd($request);
        $articulo=Articulo::findOrFail($id);
       $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');
        $articulo->estado='Activo';
        $articulo->utilidad=$request->get('utilidad');
        $articulo->unidad=$request->get('unidad');
        $articulo->precio1=$request->get('precio1');
        $articulo->precio2=$request->get('precio2');
        $articulo->util2=$request->get('util2');
        $articulo->costo=$request->get('costo');
        $articulo->iva=$request->get('impuesto');
		$articulo->fraccion=$request->get('fraccion');
        $articulo->comi=$request->get('comi');
		$articulo->pesogr=$request->get('peso');
		$articulo->sevende=$request->get('sevende');
		$articulo->pcomision=$request->get('porcentaje');
		$articulo->vacio=$request->get('vacio');
		 $articulo->volumen=$request->get('volumen');
        $articulo->grados=$request->get('grados');
		$articulo->clase=$request->get('clase');
        $articulo->origen=$request->get('origen');
		if($request->get('mprima')){$articulo->mprima=$request->get('mprima'); }else{ $articulo->mprima=0;}
        if($request->get('nivelp')){ $articulo->nivelp=$request->get('nivelp'); }else{ $articulo->nivelp=0;}

          if (input::hasfile($request->get('imagen'))){
        	$file=input::file('imagen');
        	$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        	$articulo->imagen=$file->getClientOriginalName();
        }
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
    public function destroy(Request $request,$id)
    {
		
		$id=$request->get('id');
        $articulo=Articulo::findOrFail($id);
		if($request->get('modo')==1){
        $articulo->estado='Activo';
		  }else{  
		     $articulo->estado='Inactivo';
		  }
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
	   public function almacena(Request $request)
    {
	$ide=Auth::user()->idempresa;
     if($request->ajax()){
		 $articulo=new Articulo;
		$articulo->idcategoria=$ide;
		$articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock="0";
        $articulo->descripcion=$request->get('nombre');
        $articulo->estado='Activo';
        $articulo->utilidad=$request->get('utilidad');
        $articulo->unidad=$request->get('unidad');
        $articulo->precio1=$request->get('precio1');
        $articulo->precio2=$request->get('precio2');
         $articulo->util2=$request->get('util2');
        $articulo->costo=$request->get('costo');
        $articulo->iva=$request->get('impuesto');
		$articulo->fraccion=$request->get('fraccion');
		$articulo->comi=$request->get('comi');
		$articulo->pcomision=$request->get('porcentaje');
		$articulo->volumen=$request->get('volumen');
        $articulo->grados=$request->get('grados');
		
  $articulo->save();

 $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",stock," - ",costo,"-",iva) as articulo'),'art.idarticulo','art.costo')
        -> where('art.codigo','=',$request->get('codigo'))
        -> get();
           return response()->json($articulos);
}
    }
	 public function kardex($id)
   {	
		//	dd($id);	
	 	 $articulo=Articulo::findOrFail($id);		 
		$datos=DB::table('kardex as k')
		->where('k.idarticulo','=',$id)
		->get();
	       return view("almacen/articulo.kardex",["datos"=>$datos,"articulo"=>$articulo]);
    }
    public function validar (Request $request){
            if($request->ajax()){
        $result=DB::table('articulo')->where('codigo','=',$request->get('codigo'))->get();
         return response()->json($result);
     }
      
      }
	     public function catalogo(Request $request)
    {
		$ide=Auth::user()->idempresa;
        $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
             $query=trim($request->get('grupo'));
             if (($query)==""){
				
            $datos=DB::table('articulo')                
            -> select('codigo','nombre','precio1','imagen','unidad')
			->where('idempresa','=',$ide)
			->where('estado','=',"Activo")
			->where('stock','>',0)
            ->where('imagen','<>',"")
			->OrderBy('idcategoria','asc')
            ->get(); 
			//dd($datos);
			 }else {
							
            $datos=DB::table('articulo')                
            -> select('codigo','nombre','precio1','imagen','unidad')
			-> where('idcategoria','=',$query)
			->where('idempresa','=',$ide)
			->where('estado','=',"Activo")
			->where('stock','>',0)
            ->where('imagen','<>',"")
			->OrderBy('nombre')
            ->get(); 	 
			 }
			 $grupo=DB::table('categoria')-> where('idempresa','=',$ide)->get();
        return view('reportes.catalogo.index',["datos"=>$datos,"empresa"=>$empresa,"grupo"=>$grupo,"searchText"=>$query]);
            
    }
			 public function detallekardex($id)
   {	
//dd($id);
	$data=explode("_",$id);
    $id=$data[0];
    $art=$data[1];
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join ('vendedores as vend','vend.id_vendedor','=','v.idvendedor')
            -> select ('vend.nombre as vendedor','p.id_cliente','v.idventa','v.saldo','v.fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
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
	       return view("almacen/articulo.detallekardex",["articulo"=>$art,"vacios"=>$vacios,"notasnc"=>$notasnc,"notasnd"=>$notasnd,"cxc"=>$cxc,"venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);
    }
		public function detallekardexajuste($id)
   {	
   $data=explode("_",$id);
    $id=$data[0];
    $art=$data[1];
      $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $ajuste=DB::table('ajuste as a')

            -> join ('detalle_ajuste as da','a.idajuste','=','da.idajuste')
            -> select ('a.idajuste','a.fecha_hora','a.concepto','a.responsable','a.monto')
            ->where ('a.idajuste','=',$id)
            -> first();

            $detalles=DB::table('detalle_ajuste as da')
            -> join('articulo as a','da.idarticulo','=','a.idarticulo')
            -> select('da.idarticulo','a.nombre as articulo','da.cantidad','da.tipo_ajuste','da.costo')
            -> where ('da.idajuste','=',$ajuste->idajuste)
            ->get();
            return view("almacen/articulo.detallekardexajuste",["articulo"=>$art,"ajuste"=>$ajuste,"detalles"=>$detalles,"empresa"=>$empresa]);  
  }
  		public function actstock(Request $request)
   {	
		$id=$request->get('id');
		$exis=$request->get('exis');
        $articulo=Articulo::findOrFail($id);
		$articulo->stock=$exis;
        $articulo->update();
	 
		$datos=DB::table('kardex as k')
		->where('k.idarticulo','=',$id)
		->get();
	      return view("almacen/articulo.kardex",["datos"=>$datos,"articulo"=>$articulo]);
           
  }
    	 public function grafico(Request $request)
    {
		$ide=Auth::user()->idempresa;
	$filtro="";
	$vende="";
	  $vendedores=DB::table('vendedores')->where('idempresa','=',$ide)->where('estatus','=',1)->get();
		  $articulos=DB::table('articulo')->where('idempresa','=',$ide)->get();
		if ($request->get('articulo')){
			  $filtro=Articulo::findOrFail($request->get('articulo'));
			  $filtro=$filtro->nombre;
			  $vende=Vendedores::findOrFail($request->get('vendedor'));
			  $vende=$vende->nombre;
		}
		$y = date("Y");
			$vene =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') ->select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0101',$y.'0131']) -> first();
		$vfeb =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0201',$y.'0231']) -> first();
		$vmar =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0301',$y.'0331']) -> first();
		$vabr =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0401',$y.'0430']) -> first();
		$vmay =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0501',$y.'0530']) -> first();
		$vjun =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0601',$y.'0630']) -> first();
		$vjul =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0701',$y.'0731']) -> first();
		$vago =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0801',$y.'0831']) -> first();
		$vsep =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'0901',$y.'0931']) -> first();
		$voct =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'1001',$y.'1101']) -> first();
		$vnov =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))-> where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'1101',$y.'1131']) -> first();
		$vdic =DB::table('detalle_venta as dv')->join('venta as v','v.idventa','=','dv.idventa') -> select(DB::raw('sum(cantidad) as total '))->where('v.idempresa','=',$ide)-> where('v.idvendedor','=',$request->get('vendedor'))->where('idarticulo','=',$request->get('articulo'))->where('v.devolu','=',0)-> whereBetween('fecha', [$y.'1201',$y.'1231']) -> first();
		
		
		$cene =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0101',$y.'0131']) -> first(); 
		$cfeb =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0201',$y.'0231']) -> first();
		$cmar =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0301',$y.'0331']) -> first();
		$cabr =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0401',$y.'0430']) -> first();
		$cmay =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0501',$y.'0530']) -> first();
		$cjun =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0601',$y.'0630']) -> first();
		$cjul =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0701',$y.'0731']) -> first();
		$cago =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0801',$y.'0831']) -> first();
		$csep =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'0901',$y.'0931']) -> first();
		$coct =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'1001',$y.'1031']) -> first();
		$cnov =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'1101',$y.'1131']) -> first();
		$cdic =DB::table('detalle_ingreso')-> select(DB::raw('sum(cantidad) as total '))->where('idempresa','=',$ide)-> where('idarticulo','=',$request->get('articulo'))->whereBetween('fecha', [$y.'1201',$y.'1231']) -> first();
        
		//dd($cene);
       // return view('reportes.articulografico.index',["vene"=>$vene,"vfeb"=>$vfeb,"vmar"=>$vmar,"vabr"=>$vabr,"vmay"=>$vmay,"vjun"=>$vjun,"vjul"=>$vjul,"vago"=>$vago,"vsep"=>$vsep,"voct"=>$voct,"vnov"=>$vnov,"vdic"=>$vdic,"empresa"=>$empresa,"clientes"=>$clientes,"proveedor"=>$proveedor,"articulo"=>$articulos,"vendedores"=>$vendedores]);
     return view('reportes.articulografico.index',["vende"=>$vende,"vendedores"=>$vendedores,"filtro"=>$filtro,"vene"=>$vene,"vfeb"=>$vfeb,"vmar"=>$vmar,"vabr"=>$vabr,"vmay"=>$vmay,"vjun"=>$vjun,"vjul"=>$vjul,"vago"=>$vago,"cene"=>$cene,"cfeb"=>$cfeb,"cmar"=>$cmar,"cmay"=>$cmay,"cabr"=>$cabr,"cjun"=>$cjun,"cjul"=>$cjul,"cago"=>$cago,"csep"=>$csep,"vsep"=>$vsep,"voct"=>$voct,"coct"=>$coct,"vnov"=>$vnov,"cnov"=>$cnov,"vdic"=>$vdic,"cdic"=>$cdic,"articulo"=>$articulos]);
    }

}
