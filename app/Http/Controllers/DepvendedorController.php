<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use sisventas\Depvendedor;
use DB;
use Auth;
use Carbon\Carbon;

class DepvendedorController extends Controller
{
	public function __construct()
    {
     
    }
	public function index(Request $request)
    {

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
	$ide=Auth::user()->idempresa;
	 $nivel=Auth::user()->nivel;
	$rol=DB::table('roles')-> select('newdepvendedor')->where('iduser','=',$request->user()->id)->first();
            $query=trim($request->get('searchText'));
            $deposito=DB::table('depvendedor')->where('nombre','LIKE','%'.$query.'%')
			->where('idempresa','=',$ide)
            ->orderBy('id_deposito','asc')
            ->paginate(30);		
            return view('depositos.deposito.index',["rol"=>$rol,"deposito"=>$deposito,"searchText"=>$query]);
     
    }
		   public function create()
    {
        return view("depositos.deposito.create");
    }
		    public function store (Request $request)
    {
		$ide=Auth::user()->idempresa;
        $categoria=new Depvendedor;
        $categoria->nombre=$request->get('nombre');
        $categoria->idempresa=$ide;
		 $categoria->descripcion=$request->get('descripcion');
        $categoria->save();
        return Redirect::to('depositos/deposito');

    }
		   public function edit($id)
    {
        return view("depositos.deposito.edit",["categoria"=>Depvendedor::findOrFail($id)]);
    }
	public function update(Request $request,$id)
    {
        $categoria=Depvendedor::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('depositos/deposito');
    }
	public function show($id)
	   { 
			$categoria=Depvendedor::findOrFail($id);
			$articulos=DB::table('articulo as a')
            -> join('existencia as ex','a.idarticulo','=','ex.idarticulo')
			-> join('categoria as c','a.idcategoria','=','c.idcategoria')
            -> select ('a.idarticulo','a.nombre','a.codigo','a.costo','a.precio1','ex.existencia as stock','c.nombre as categoria','a.descripcion','a.estado')
            ->where ('ex.id_almacen','=',$id)
            ->where ('a.estado','=','Activo')
            ->orderBy('a.nombre','asc')
            ->paginate(20);    
      return view("depositos.deposito.show",["articulos"=>$articulos,"categoria"=>$categoria]);
    }
}
