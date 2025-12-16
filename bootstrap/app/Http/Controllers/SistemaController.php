<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use sisventas\empresa;
use DB;
class SistemaController extends Controller
{
    //
    public function index(Request $request)
	{
		
		
			$empresa=DB::table('empresa')
			->first();
			return view('sistema.tasa.index',["empresa"=>$empresa]);
		
	}
	   public function show()
	{
			
			$user=DB::table('users')
			->get();
			//dd($user);
			return view('sistema.tasa.usuarios',["empresa"=>$user]);
		
	}
		   public function ayuda()
	{		
			return view('sistema.ayuda.index');	
	}


 public function almacena(Request $request)
    {
		
   //  if($request->ajax()){
	
		$empresa=empresa::findOrFail('1');
        $empresa->tc=$request->get('act_tasa');
		 $empresa->peso=$request->get('act_peso');
        $empresa->update();
		
// inica actualizar precio

 //$results=DB::update('update articulo set costo=(costo_t*'.$empresa->tc.'),precio1=(precio_t*'.$empresa->tc.') where costo_t > 0 and estado="activo"');
//var_dump($results);
// culmina actualizar
   //        return response()->json();
         return Redirect::to('sistema/tasa');
 }
 //   }
}
