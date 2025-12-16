<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\precios;
use sisventas\Http\Requests;
use sisventas\Http\Requests\PrecioFormRequest;
use Illuminate\Support\Facades\Redirect;
use DB;

class PrecioController extends Controller
{
    public function _construct(){

    }

    public function index(Request $request){
    	if($request){
    		$query=trim($request->get('CajaTexto'));
    		$precio=DB::table('tratamientos')->where('tratamiento','LIKE','%'.$query.'%')
    		->orderby('tratamiento','ASC')
    		->paginate(10);
    		return view('tratamiento.precio.index',["tratamiento"=>$precio,"CajaTexto"=>$query]);
    	}

    }
  public function show($id)
	{
		return view("tratamiento.precio.show",["tratamiento"=>precios::findOrFail($id)]);
			
	}
  public  function edit($id){
return view("tratamiento.precio.edit",["tratamiento"=>Precios::findOrFail($id)]);
  }
  public function update(PrecioFormRequest $requets, $id){

    $dato=precios::findOrFail($id);
    $dato->tratamiento=$requets->get('tratamiento');
    $dato->clase=$requets->get('clase');
    $dato->precio_base=$requets->get('precio');
    $dato->update();
     return Redirect::to('tratamiento/precio');
  }
}
