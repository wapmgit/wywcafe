<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Articulo;
use sisventas\DetalleIngreso;
use sisventas\ReportesController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ArticuloFormRequest;
use DB;

class ArticuloController extends Controller
{
      public function __construct()
    {
     
    }
    public function index(Request $request)
    {
        if ($request)
        {
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $query=trim($request->get('searchText'));
            $articulos=DB::table('articulo as a')
			-> join('categoria as c','a.idcategoria','=','c.idcategoria')
			-> select ('a.idarticulo','a.nombre','a.precio1','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado')
            ->where('a.nombre','LIKE','%'.$query.'%')
            ->orwhere('a.codigo','LIKE','%'.$query.'%')
            ->where('a.estado','=','Activo')
            ->orderBy('a.idarticulo','desc')
            ->paginate(20);
			//dd($articulos);
            return view('almacen.articulo.index',["articulos"=>$articulos,"empresa"=>$empresa,"searchText"=>$query]);
        }
    }
    public function create()
    {
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();

        return view("almacen.articulo.create",["categorias"=>$categorias]);
    }
	  public function newcreate()
    {
		
    	$categorias=DB::table('categoria')->where('condicion','=','1')->get();
//dd($categorias);
        return view("almacen.articulo.newcreate",["categorias"=>$categorias]);
    }
 public function store (ArticuloFormRequest $request)
    {
		//dd($request);
        $validar=$request->get('codigo');
                try{
    DB::beginTransaction();
       // $articulos=Articulo::findOrFail($request->get('codigo'));
		$articulo=new Articulo;
        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=0;
        $articulo->descripcion=$request->get('descripcion');
        $articulo->estado='Activo';
        $articulo->utilidad=$request->get('utilidad');
        $articulo->precio1=$request->get('precio1');
        $articulo->precio2=$request->get('precio2');
         $articulo->util2=$request->get('util2');
        $articulo->costo=$request->get('costo');
        $articulo->vacio=$request->get('vacio');
        //validar iva vacio
        $articulo->iva=$request->get('impuesto');
        
         if (input::hasfile($request->get('imagen'))){
        	$file=input::file('imagen');
        	$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        	$articulo->imagen=$file->getClientOriginalName();
        }

        $articulo->save();

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
        return view("almacen/articulo.edit",["articulo"=>$articulos,"categorias"=>$categorias]);
    }
    public function update(ArticuloFormRequest $request,$id)
    {
        $articulo=Articulo::findOrFail($id);

       $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock=$request->get('stock');
        $articulo->descripcion=$request->get('descripcion');
        $articulo->estado='Activo';
        $articulo->utilidad=$request->get('utilidad');
        $articulo->precio1=$request->get('precio1');
        $articulo->precio2=$request->get('precio2');
        $articulo->util2=$request->get('util2');
        $articulo->costo=$request->get('costo');
        $articulo->iva=$request->get('impuesto');
		$articulo->vacio=$request->get('vacio');

          if (input::hasfile($request->get('imagen'))){
        	$file=input::file('imagen');
        	$file->move(public_path().'/imagenes/articulos',$file->getClientOriginalName());
        	$articulo->imagen=$file->getClientOriginalName();
        }
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
    public function destroy($id)
    {
        $articulo=Articulo::findOrFail($id);
        $articulo->estado='Inactivo';
        $articulo->update();
        return Redirect::to('almacen/articulo');
    }
	   public function almacena(Request $request)
    {
		//dd($request->get('codigo'));
     if($request->ajax()){
		 $articulo=new Articulo;
		$articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $articulo->nombre=$request->get('nombre');
        $articulo->stock="0";
        $articulo->descripcion=$request->get('nombre');
        $articulo->estado='Activo';
        $articulo->utilidad=$request->get('utilidad');
        $articulo->precio1=$request->get('precio1');
        $articulo->precio2=$request->get('precio2');
         $articulo->util2=$request->get('util2');
        $articulo->costo=$request->get('costo');
        $articulo->iva=$request->get('impuesto');
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
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
             $query=trim($request->get('grupo'));
             if (($query)==""){
				
            $datos=DB::table('articulo')                
            -> select('codigo','nombre','precio1','imagen')
            ->where('imagen','<>',"")
			->OrderBy('nombre')
            ->get(); 
			 }else {
							
            $datos=DB::table('articulo')                
            -> select('codigo','nombre','precio1','imagen')
			-> where('idcategoria','=',$query)
            ->where('imagen','<>',"")
			->OrderBy('nombre')
            ->get(); 	 
			 }
			 $grupo=DB::table('categoria')->get();
        return view('reportes.catalogo.index',["datos"=>$datos,"empresa"=>$empresa,"grupo"=>$grupo,"searchText"=>$query]);
            
    }

}
