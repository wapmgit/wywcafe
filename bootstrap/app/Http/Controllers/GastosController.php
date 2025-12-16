<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Gastos;
use sisventas\Movbanco;
use sisventas\comprobante;
use Auth;
use Carbon\Carbon;
use DB;
class GastosController extends Controller
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
            $gasto=DB::table('gasto as g')->join('proveedor as p','p.idproveedor','=','g.idpersona')
			->select('g.*','p.nombre','p.rif')
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orderBy('g.idgasto','desc')
            ->paginate(20);
     
     return view ('gastos.gasto.index',["gasto"=>$gasto,"empresa"=>$empresa,"searchText"=>$query]);
        }
    } 
	    public function create(){
			$monedas=DB::table('monedas')->get();
		$personas=DB::table('proveedor')
        -> where('estatus','=','A')->get();
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        return view("gastos.gasto.create",["monedas"=>$monedas,"personas"=>$personas,"empresa"=>$empresa]);
    } 
	    public function store(Request $request){
		//	dd($request);
		$user=Auth::user()->name;
		try{
    DB::beginTransaction();
	$idcliente=explode("_",$request->get('idproveedor'));
			$ajuste=new Gastos;
			$ajuste->idpersona=$idcliente[0];
			$ajuste->documento=$request->get('documento');
			$ajuste->descripcion=$request->get('descripcion');
			$ajuste->monto=$request->get('monto');
			if($request->get('tdeuda')>0){
			$ajuste->saldo=$request->get('tdeuda');}else{$ajuste->saldo=$request->get('monto');}
			$mytime=Carbon::now('America/Caracas');
			$ajuste->fecha=$mytime->toDateTimeString();
			$ajuste->usuario=$user;
			$ajuste-> save();
				if($request->get('totala')>0){
  // inserta el recibo
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
              while($contp < count($idpago)){
				$recibo=new comprobante;
				$recibo->idgasto= $ajuste->idgasto;
				$recibo->monto=$request->get('total_venta');
				$recibo->idpago=$idpago[$contp];
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$mytime=Carbon::now('America/Caracas');
				$recibo->fecha_comp=$mytime->toDateTimeString();						
				$recibo->save();
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/D";
		$mov->tipodoc="GAST";
        $mov->numero=$pago[0]."-".$request->get('documento');
        $mov->concepto="Egreso Gastos";
		$mov->tipo_per="P";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[1];
        $mov->nombre=$idcliente[2];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=0;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=Auth::user()->name;
        $mov->save();
				$contp=$contp+1;
			  } 
	}
                DB::commit();
	}
catch(\Exception $e)
{
    DB::rollback();
} 

return Redirect::to('gastos/gasto');
}
public function show($id){
    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $gasto=DB::table('gasto as g')
            -> join ('proveedor as p','p.idproveedor','=','g.idpersona')
            -> select ('g.*','p.nombre','p.rif','p.telefono','p.direccion')
            ->where ('g.idgasto','=',$id)
            -> first();

            $comprobante=DB::table('comprobante as co')
            -> where ('co.idgasto','=',$id)
            ->get();

            return view("gastos.gasto.show",["gasto"=>$gasto,"comprobante"=>$comprobante,"empresa"=>$empresa]);
}
public function destroy($id){
			$ingreso=Gastos::findOrFail($id);
			 $ingreso->descripcion=$ingreso->descripcion."-Anulada";
			  $ingreso->estatus=1;
			 $ingreso->update();
			$recibos=DB::table('comprobante')
            -> select('idrecibo')
            -> where ('idgasto','=',$id)
            ->get();
		$longitud = count($recibos);
		$array = array();
			foreach($recibos as $t){
			$arraycod[] = $t->idrecibo;
			}
for ($i=0;$i<$longitud;$i++){
 $recibo=comprobante::findOrFail($arraycod[$i]);
					 $recibo->referencia='Anulado';
					 $recibo->monto='0,0';
					 $recibo->recibido='0,0';
					 $recibo->update();
}
			 	
			 return Redirect::to('gastos/gasto');
}
}
