<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Categoria;
use sisventas\Articulo;
use sisventas\Pacientes;
use sisventas\Vendedores;
use sisventas\Proovedor;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests\CategoriaFormRequest;
use DB;
use Auth;

class CategoriaController extends Controller
{
    public function __construct()
    {
     
    }
    public function index(Request $request)
    {
		 $nivel=Auth::user()->nivel;
		 if ($nivel=="L")
		 {
			 $monedas=DB::table('monedas')->get();
		$personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.tipo_cliente','clientes.nombre','clientes.cedula','vendedores.comision','vendedores.nombre as nombrev')-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
		if ($contador==""){$contador=0;}
			return view("ventas.venta.create",["personas"=>$personas,"monedas"=>$monedas,"articulos"=>$articulos,"contador"=>$contador]);
			} else {
				if ($request)
			{
            $query=trim($request->get('searchText'));
            $categorias=DB::table('categoria')->where('nombre','LIKE','%'.$query.'%')
            ->where ('condicion','=','1')
            ->orderBy('idcategoria','asc')
            ->paginate(10);
            return view('almacen.categoria.index',["categorias"=>$categorias,"searchText"=>$query]);
			}
		}
    }
    public function create()
    {
        return view("almacen.categoria.create");
    }
	 public function grafico()
    {
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
         $nivel=Auth::user()->nivel;
     if ($nivel=="A")
         
     {
		 $clientes=DB::table('clientes')->get();
		  $proveedor=DB::table('proveedor')->get();
		  $articulos=DB::table('articulo')->get();
		   $vendedores=DB::table('vendedores')->get();
		$y = date("Y");
		$vene =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0101',$y.'0131']) -> first();
		$vfeb =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0201',$y.'0231']) -> first();
		$vmar =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0301',$y.'0331']) -> first();
		$vabr =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0401',$y.'0430']) -> first();
		$vmay =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0501',$y.'0530']) -> first();
		$vjun =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0601',$y.'0630']) -> first();
		$vjul =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0701',$y.'0731']) -> first();
		$vago =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0801',$y.'0831']) -> first();
		$vsep =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'0901',$y.'0931']) -> first();
		$voct =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'1001',$y.'1101']) -> first();
		$vnov =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'1101',$y.'1131']) -> first();
		$vdic =DB::table('venta')-> select(DB::raw('sum(total_venta) as total '))-> whereBetween('fecha_hora', [$y.'1201',$y.'1231']) -> first();
        
		
        $cene =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0101',$y.'0131']) -> first(); 
		$cfeb =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0201',$y.'0231']) -> first();
		$cmar =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0301',$y.'0331']) -> first();
		$cabr =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0401',$y.'0430']) -> first();
		$cmay =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0501',$y.'0530']) -> first();
		$cjun =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0601',$y.'0630']) -> first();
		$cjul =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0701',$y.'0731']) -> first();
		$cago =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0801',$y.'0831']) -> first();
		$csep =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'0901',$y.'0931']) -> first();
		$coct =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'1001',$y.'1031']) -> first();
		$cnov =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'1101',$y.'1131']) -> first();
		$cdic =DB::table('ingreso')-> select(DB::raw('sum(total) as total '))-> whereBetween('fecha_hora', [$y.'1201',$y.'1231']) -> first();
        
		
        return view('almacen.categoria.grafico',["vene"=>$vene,"vfeb"=>$vfeb,"vmar"=>$vmar,"vabr"=>$vabr,"vmay"=>$vmay,"vjun"=>$vjun,"vjul"=>$vjul,"vago"=>$vago,"cene"=>$cene,"cfeb"=>$cfeb,"cmar"=>$cmar,"cmay"=>$cmay,"cabr"=>$cabr,"cjun"=>$cjun,"cjul"=>$cjul,"cago"=>$cago,"csep"=>$csep,"vsep"=>$vsep,"voct"=>$voct,"coct"=>$coct,"vnov"=>$vnov,"cnov"=>$cnov,"vdic"=>$vdic,"cdic"=>$cdic,"empresa"=>$empresa,"clientes"=>$clientes,"proveedor"=>$proveedor,"articulo"=>$articulos,"vendedores"=>$vendedores]);
    } else {
		$monedas=DB::table('monedas')->get();
		$personas=DB::table('clientes')->join('vendedores','vendedores.id_vendedor','=','clientes.vendedor')->select('clientes.id_cliente','clientes.tipo_precio','clientes.nombre','clientes.cedula','clientes.tipo_cliente','vendedores.comision','vendedores.nombre as nombrev')-> where('clientes.status','=','A')->groupby('clientes.id_cliente')->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
		 $vendedores=DB::table('vendedores')->get();
		$proveedor=DB::table('proveedor')->get();    
			//dd($contador);
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.costo','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
        //dd($articulos);
		if ($contador==""){$contador=0;}
		return view("ventas.venta.create",["personas"=>$personas,"monedas"=>$monedas,"articulos"=>$articulos,"contador"=>$contador,"empresa"=>$empresa,"vendedores"=>$vendedores]);
    }
    }
    public function store (CategoriaFormRequest $request)
    {
        $categoria=new Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->condicion='1';
        $categoria->save();
        return Redirect::to('almacen/categoria');

    }
    public function show($id)
    
    { 

        $categoria=Categoria::findOrFail($id);
        $articulos=DB::table('articulo as a')
            -> join('categoria as c','a.idcategoria','=','c.idcategoria')
            -> select ('a.idarticulo','a.nombre','a.codigo','a.costo','a.precio1','a.stock','c.nombre as categoria','a.descripcion','a.estado')
            ->where ('c.idcategoria','=',$id)
            ->where ('a.estado','=','Activo')
            ->orderBy('a.nombre','asc')
            ->paginate(20);
    
      return view("almacen.categoria.show",["articulos"=>$articulos,"categoria"=>$categoria]);
    }
    public function edit($id)
    {
        return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);
    }
    public function update(CategoriaFormRequest $request,$id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('almacen/categoria');
    }
    public function destroy($id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->condicion='0';
        $categoria->update();
        return Redirect::to('almacen/categoria');
    }
	   public function recalcular( Request $request)
    {
		$nutil=0;$nprecio=0;$pt=0;
			$modo=$request->get('modo');
			$tasa=$request->get('tasa');
            $categoria=$request->get('categoria');
			if ($modo == 1){
			$articulos=DB::table('articulo as a')
            -> select ('a.idarticulo','a.utilidad','a.util2','iva','a.costo','a.precio1','a.precio2')
            ->where ('a.idcategoria','=',$categoria)
			->get();
			 $cont = 0;
			while($cont < count($articulos)){
                      //actualizo stock   
			$articulo=Articulo::findOrFail($articulos[$cont]->idarticulo); 
		    $nprecio=$articulo->precio1+(($tasa/100)*$articulos[$cont]->precio1);
			$pt=($articulos[$cont]->costo + (($articulos[$cont]->iva/100)*$articulos[$cont]->costo));  
			  $nutil=((($nprecio/$pt)*100)-100);
			  $articulo->precio1=$nprecio;
			  $articulo->utilidad=$nutil;
			  $articulo->precio2=$nprecio;
			 $articulo->util2=$nutil;
			  $articulo->update();
            $cont=$cont+1;
            }     	
			}
			if ($modo == 2){
			$articulos=DB::table('articulo as a')
            -> select ('a.idarticulo','a.utilidad','a.util2','iva','a.costo','a.precio1','a.precio2')
            ->where ('a.idcategoria','=',$categoria)
			->get();
			 $cont = 0;
			while($cont < count($articulos)){
                      //actualizo stock   
         $articulo=Articulo::findOrFail($articulos[$cont]->idarticulo); 
			$articulo->utilidad=$tasa;
			$impuesto=$articulo->iva;
			$costo=$articulo->costo;
			$np=($costo + (($tasa/100)*$costo))+(($costo + (($tasa/100)*$costo))*($impuesto/100));
			  $articulo->precio1=$np;
			  $articulo->utilidad=$tasa;
			  $articulo->precio2=$np;
			 $articulo->util2=$tasa;
			  $articulo->update();
            $cont=$cont+1;
            }     	
			}
     // 	dd($articulo);
       return Redirect::to('almacen/categoria');
    }





}
