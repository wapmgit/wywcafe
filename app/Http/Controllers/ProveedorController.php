<?php


namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Proovedor;
use sisventas\Notasadmp;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\ProveedorFormRequest;
use DB;
use Carbon\Carbon;
use Auth;


class ProveedorController extends Controller
{
   public function __construct()
	{
$this->middleware('auth');
	
	}

	public function index(Request $request)
	{
	 $ide=Auth::user()->idempresa;
		if ($request)
		{
			
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$rol=DB::table('roles')-> select('newproveedor','editproveedor','crearcompra','edoctap')->where('iduser','=',$request->user()->id)->first();
			$query=trim($request->get('searchText'));
			$proveedores=DB::table('proveedor')->where('nombre','LIKE','%'.$query.'%')
				->where('idempresa','=',$ide)
				->where('estatus','=','A')
				->orderBy('idproveedor','desc')
				->paginate(50);
				return view('proveedores.proveedor.index',["rol"=>$rol,"proveedor"=>$proveedores,"empresa"=>$empresa,"searchText"=>$query]);
		}
	} 

	public function create()
	{
		return view("proveedores.proveedor.create");
	}
    public function store (ProveedorFormRequest $request)
    {
		$ide=Auth::user()->idempresa;
        $proveedor=new Proovedor;
        $proveedor->idempresa=$ide;
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
	$pagos=DB::table('comprobante as re')
		->join('ingreso as in','in.idingreso','=','re.idcompra')
         -> select('re.monto','re.recibido','re.idbanco','re.idpago','in.tipo_comprobante','in.num_comprobante','re.fecha_comp','re.referencia')
		 -> where('in.idproveedor','=',$id)
            ->get(); 
	$pagosg=DB::table('comprobante as re')
		->join('gasto as ga','ga.idgasto','=','re.idgasto')
         -> select('re.monto','re.recibido','re.idbanco','re.idpago','ga.documento','ga.control','re.fecha_comp','re.referencia')
		 -> where('ga.idpersona','=',$id)
            ->get(); 
			$notas=DB::table('notasadmp')->where('idcliente','=',$id)->get();
	//dd($pagosg);			
        return view("proveedores.proveedor.show",["notas"=>$notas,"pagosg"=>$pagosg,"empresa"=>$empresa,"datos"=>$datos,"gastos"=>$gastos,"compras"=>$compras,"pagos"=>$pagos]);
    }
	    public function validar (Request $request){
			$ide=Auth::user()->idempresa;
            if($request->ajax()){
        $result=DB::table('proveedor')->where('idempresa','=',$ide)->where('rif','=',$request->get('rif'))->get();
         return response()->json($result);
     }
      
      }
	  	public function notasadm (Request $request){
				
		$ide=Auth::user()->idempresa;
		$contador=DB::table('notasadmp')->select(DB::raw('count(idnota) as idventa'))-> where('idempresa','=',$ide)->limit('1')->orderby('idnota','desc')->first();
		if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}
        $paciente=new Notasadmp;
        $paciente->tipo=$request->get('tipo');
        $paciente->idempresa=$ide;
        $paciente->numnota=$numero+1;
        $paciente->idcliente=$request->get('idcliente');
        $paciente->descripcion=$request->get('descripcion');
        $paciente->referencia=$request->get('referencia');
        $paciente->monto=$request->get('monto');
		$mytime=Carbon::now('America/Caracas');
		$paciente->fecha=$mytime->toDateTimeString();
        $paciente->pendiente=$request->get('monto');
		$paciente->usuario=Auth::user()->name;
        $paciente->save();
        return Redirect::to('proveedores/proveedor/historico/'.$request->get('idcliente'));
     }
}
