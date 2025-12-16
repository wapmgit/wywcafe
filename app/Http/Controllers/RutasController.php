<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Rutas;
use Illuminate\Support\Facades\Redirect;
use DB;
use Auth;

class RutasController extends Controller
{
    public function __construct()
    {
     
    }
    public function index(Request $request)
    {
		$ide=Auth::user()->idempresa;
		 $nivel=Auth::user()->nivel;
		$query=trim($request->get('searchText'));
		$rutas=DB::table('rutas')->where('nombre','LIKE','%'.$query.'%')
		-> where('idempresa','=',$ide)
        -> get();
		return view('rutas.rutas.index',["rutas"=>$rutas,"searchText"=>$query]);	
    }
	 public function create()
    {
        return view("rutas.rutas.create");
    }
	    public function store (Request $request)
    {
		//dd($request);
		$ide=Auth::user()->idempresa;
        $categoria=new Rutas;
        $categoria->idempresa=$ide;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->save();
        return Redirect::to('rutas/rutas');

    }
	    public function edit($id)
    {
        return view("rutas.rutas.edit",["ruta"=>Rutas::findOrFail($id)]);
    }
	    public function update(Request $request,$id)
    {		
        $categoria=Rutas::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
           return Redirect::to('rutas/rutas');
    }
	    public function show($id)   
    { 
        $ruta=Rutas::findOrFail($id);
        $clientes=DB::table('clientes as a')
            -> join('rutas as c','c.idruta','=','a.ruta') 
			->select('a.*')			
            ->where ('c.idruta','=',$id)
            ->where ('a.status','=','A')
            ->orderBy('a.nombre','asc')
            ->get();
    
      return view("rutas.rutas.show",["clientes"=>$clientes,"ruta"=>$ruta]);
    }
}
