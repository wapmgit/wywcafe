<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use sisventas\empresa;
use sisventas\Roles;
use sisventas\User;
use DB;
use Auth;

class SistemaController extends Controller
{
    //
    public function index(Request $request)
	{
		
		$ide=Auth::user()->idempresa;
		$rol=DB::table('roles')-> select('acttasa')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)
			->first();
			 if($rol->acttasa){
			return view('sistema.tasa.index',["empresa"=>$empresa]);
			 }else{
			return view('reportes.mensajes.noautorizado');	
		 }
	}
	   public function show(Request $request)
	{ //lista de usuarios
			$ide=Auth::user()->idempresa;
			$user=DB::table('users')->join('roles','roles.iduser','=','users.id')
			-> where('idempresa','=',$ide)
			->get();
			$rol=DB::table('roles')-> select('actroles','updatepass')->where('iduser','=',$request->user()->id)->first();
			//dd($user);
			return view('sistema.roles.usuarios',["empresa"=>$user,"rol"=>$rol]);
		
	}
		   public function ayuda()
	{		
			return view('sistema.ayuda.index');	
	}
    public function mensaje(Request $request)
	{	
			return view('reportes.mensajes.sinconexion');	
	}



 public function almacena(Request $request)
    {
			$ide=Auth::user()->idempresa;
   //  if($request->ajax()){
	
		$empresa=empresa::findOrFail($ide);
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
 		 public function actroles(Request $request)
    {
		//dd($request);
		$data=Roles::findOrFail($request->get('rol'));
		$usuario=$data->iduser;
		if ($request->get('op1')){ $data->newcliente=1; }else{$data->newcliente=0; }
		if ($request->get('op2')){ $data->editcliente=1; }else{$data->editcliente=0; }
		if ($request->get('op3')){ $data->newproveedor=1; }else{$data->newproveedor=0; }
		if ($request->get('op4')){ $data->editproveedor=1; }else{$data->editproveedor=0; }
		if ($request->get('op5')){ $data->newvendedor=1; }else{$data->newvendedor=0; }
		if ($request->get('op6')){ $data->editvendedor=1; }else{$data->editvendedor=0; }
		if ($request->get('op7')){ $data->newarticulo=1; }else{$data->newarticulo=0; }
		if ($request->get('op8')){ $data->editarticulo=1; }else{$data->editarticulo=0; }		
		if ($request->get('op9')){ $data->crearcompra=1; }else{$data->crearcompra=0; }
		if ($request->get('op10')){ $data->anularcompra=1; }else{$data->anularcompra=0; }
		if ($request->get('op11')){ $data->crearventa=1; }else{$data->crearventa=0; }
		if ($request->get('op12')){ $data->anularventa=1; }else{$data->anularventa=0; }	
		if ($request->get('op13')){ $data->creargasto=1; }else{$data->creargasto=0; }
		if ($request->get('op14')){ $data->anulargasto=1; }else{$data->anulargasto=0; }				
		if ($request->get('op15')){ $data->abonarcxp=1; }else{$data->abonarcxp=0; }
		if ($request->get('op16')){ $data->crearajuste=1; }else{$data->crearajuste=0; }	
		if ($request->get('op17')){ $data->abonargasto=1; }else{$data->abonargasto=0; }		
		if ($request->get('op18')){ $data->abonarcxc=1; }else{$data->abonarcxc=0; }	
		if ($request->get('op19')){ $data->crearpedido=1; }else{$data->crearpedido=0; }
		if ($request->get('op20')){ $data->anularpedido=1; }else{$data->anularpedido=0; }
		if ($request->get('op21')){ $data->importarpedido=1; }else{$data->importarpedido=0; }
		if ($request->get('op22')){ $data->editpedido=1; }else{$data->editpedido=0; }
		if ($request->get('op23')){ $data->rventas=1; }else{$data->rventas=0; }
		if ($request->get('op24')){ $data->ccaja=1; }else{$data->ccaja=0; }
		if ($request->get('op25')){ $data->rdetallei=1; }else{$data->rdetallei=0; }
		if ($request->get('op26')){ $data->rcxc=1; }else{$data->rcxc=0; }
		if ($request->get('op27')){ $data->rcompras=1; }else{$data->rcompras=0; }
		if ($request->get('op28')){ $data->rdetallec=1; }else{$data->rdetallec=0; }
		if ($request->get('op29')){ $data->rcxp=1; }else{$data->rcxp=0; }
		if ($request->get('op30')){ $data->newbanco=1; }else{$data->newbanco=0; }
		if ($request->get('op31')){ $data->accesobanco=1; }else{$data->accesobanco=0; }
		if ($request->get('op32')){ $data->comision=1; }else{$data->comision=0; }
		if ($request->get('op33')){ $data->pcomision=1; }else{$data->pcomision=0; }
		if ($request->get('op34')){ $data->metae=1; }else{$data->metae=0; }
		if ($request->get('op35')){ $data->metav=1; }else{$data->metav=0; }
		if ($request->get('op36')){ $data->acttasa=1; }else{$data->acttasa=0; }
		if ($request->get('op37')){ $data->actroles=1; }else{$data->actroles=0; }
		if ($request->get('op38')){ $data->updatepass=1; }else{$data->updatepass=0; }       
		if ($request->get('op39')){ $data->edocta=1; }else{$data->edocta=0; }       
		if ($request->get('op40')){ $data->actcliente=1; }else{$data->actcliente=0; }       
		if ($request->get('op41')){ $data->web=1; }else{$data->web=0; }       
		if ($request->get('op42')){ $data->edoctap=1; }else{$data->edoctap=0; }       
		if ($request->get('op43')){ $data->actvendedor=1; }else{$data->actvendedor=0; }       
		if ($request->get('op44')){ $data->importarne=1; }else{$data->importarne=0; }       
		if ($request->get('op45')){ $data->crearfl=1; }else{$data->crearfl=0; }       
		if ($request->get('op46')){ $data->importarfl=1; }else{$data->importarfl=0; }       
		if ($request->get('op47')){ $data->anularfl=1; }else{$data->anularfl=0; }       
		if ($request->get('op48')){ $data->crearfe=1; }else{$data->crearfe=0; }       
		if ($request->get('op49')){ $data->editarfe=1; }else{$data->editarfe=0; }       
		if ($request->get('op50')){ $data->anularfe=1; }else{$data->anularfe=0; }       
		if ($request->get('op51')){ $data->vacios=1; }else{$data->vacios=0; }       
		if ($request->get('op52')){ $data->lventas=1; }else{$data->lventas=0; }       
		if ($request->get('op53')){ $data->lcompras=1; }else{$data->lcompras=0; }       
		if ($request->get('op54')){ $data->valorizado=1; }else{$data->valorizado=0; }       
		if ($request->get('op55')){ $data->listap=1; }else{$data->listap=0; }       
		if ($request->get('op56')){ $data->resumeng=1; }else{$data->resumeng=0; }       
		if ($request->get('op57')){ $data->edoctabanco=1; }else{$data->edoctabanco=0; }       
		if ($request->get('op58')){ $data->rinventario=1; }else{$data->rinventario=0; }       
		$data ->update();

	
		
		$rol=DB::table('roles')-> select('actroles','updatepass')->where('iduser','=',$request->user()->id)->first();
		$user=DB::table('users')->join('roles','users.id','=','roles.iduser')
			->get();
			return view('sistema.roles.usuarios',["empresa"=>$user,"rol"=>$rol]);
			
	}
	public function updatepass(Request $request)
	{
		//dd($request);
    $user = Auth::user();
	$user = User::find($request->get('id'));
    $user->password = Hash::make($request->get('pass'));
    $user->save();
return view('sistema.ayuda.index');	
   // return redirect()->back()->with('success', '¡Contraseña actualizada correctamente!');
	}
}
