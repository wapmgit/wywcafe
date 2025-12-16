<?php


namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Proovedor;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ProveedorFormRequest;
use DB;

class ProveedorController extends Controller
{
   public function __construct()
	{
$this->middleware('auth');
	}

	public function index(Request $request)
	{
		if ($request)
		{
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
			$query=trim($request->get('searchText'));
			$proveedores=DB::table('proveedor')->where('nombre','LIKE','%'.$query.'%')
				->where('estatus','=','A')
				->orderBy('idproveedor','desc')
				->paginate(20);
				return view('proveedores.proveedor.index',["proveedor"=>$proveedores,"empresa"=>$empresa,"searchText"=>$query]);
		}
	} 

	public function create()
	{
		return view("proveedores.proveedor.create");
	}
    public function store (ProveedorFormRequest $request)
    {
        $proveedor=new Proovedor;
        $proveedor->nombre=$request->get('nombre');
        $proveedor->rif=$request->get('rif');
        $proveedor->direccion=$request->get('direccion');
        $proveedor->telefono=$request->get('telefono');
        $proveedor->contacto=$request->get('contacto');
		$proveedor->tpersona=$request->get('tpersona');
		$proveedor->estatus='A';
            
        $proveedor->save();
        return Redirect::to('proveedores/proveedor');

    }
	
	public function edit($idproveedor)
	{
		return view("proveedores.proveedor.edit",["proveedor"=>Proovedor::findOrFail($idproveedor)]);
	}
	public function update(ProveedorFormRequest $request,$idproveedor)
	{
        $proveedor=Proovedor::findOrFail($idproveedor);
        $proveedor->nombre=$request->get('nombre');
        $proveedor->rif=$request->get('rif');
        $proveedor->direccion=$request->get('direccion');
        $proveedor->telefono=$request->get('telefono');
        $proveedor->contacto=$request->get('contacto');
		$proveedor->tpersona=$request->get('tpersona');
        $proveedor->update();
        return Redirect::to('proveedores/proveedor');
	}
	public function destroy()
	{
        $paciente=Pacientes::findOrFail($idproveedor);
        $paciente->status='I';
        $paciente->update();
        return Redirect::to('proveedores/proveedor');
	}
 public function historico($id)
    {    
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
	$datos=DB::table('proveedor')->where('idproveedor','=',$id)
	->first();
	$compras=DB::table('ingreso')->where('idproveedor','=',$id)->get();
	$gastos=DB::table('gasto')->where('idpersona','=',$id)->get();
				
        return view("proveedores.proveedor.show",["empresa"=>$empresa,"datos"=>$datos,"gastos"=>$gastos,"compras"=>$compras]);
    }
	    public function validar (Request $request){
            if($request->ajax()){
        $result=DB::table('proveedor')->where('rif','=',$request->get('rif'))->get();
         return response()->json($result);
     }
      
      }
}
