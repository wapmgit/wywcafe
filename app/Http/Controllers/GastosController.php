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
			$ide=Auth::user()->idempresa;
			$rol=DB::table('roles')-> select('creargasto','anulargasto')->where('iduser','=',$request->user()->id)->first();
            $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
            $gasto=DB::table('gasto as g')->join('proveedor as p','p.idproveedor','=','g.idpersona')
			->select('g.*','p.nombre','p.rif')
			->where('g.idempresa','=',$ide)	
            -> where ('p.nombre','LIKE','%'.$query.'%')
            -> orderBy('g.idgasto','desc')
            ->paginate(50);
     
     return view ('gastos.gasto.index',["rol"=>$rol,"gasto"=>$gasto,"empresa"=>$empresa,"searchText"=>$query]);
        }
    } 
	    public function create(Request $request){
			$ide=Auth::user()->idempresa;
			$monedas=DB::table('monedas')->where('idempresa','=',$ide)	->get();
			$personas=DB::table('proveedor')
			->where('idempresa','=',$ide)	
			-> where('estatus','=','A')->get();
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
        return view("gastos.gasto.create",["monedas"=>$monedas,"personas"=>$personas,"empresa"=>$empresa]);
    } 
	    public function store(Request $request){
		$ide=Auth::user()->idempresa;
		$user=Auth::user()->name;
		  $contador=DB::table('gasto')->select(DB::raw('count(idgasto) as numero'))-> where('idempresa','=',$ide)->limit('1')->orderby('idgasto','desc')->first();
   if ($contador==NULL){$numero=0;}else{$numero=$contador->numero;}
		//try{
   // DB::beginTransaction();
	$idcliente=explode("_",$request->get('idproveedor'));
			$ajuste=new Gastos;
			$ajuste->idempresa=$ide;
			$ajuste->idpersona=$idcliente[0];
			$ajuste->numgasto=$numero+1;
			$ajuste->documento=$request->get('documento');
			$ajuste->control=$request->get('control');
			$ajuste->tasa=$request->get('tasa');
			$ajuste->descripcion=$request->get('descripcion');
			$ajuste->monto=$request->get('monto');
			$ajuste->base=$request->get('base');
			$ajuste->iva=$request->get('iva');
			$ajuste->exento=$request->get('exento');		
			$ajuste->saldo=$request->get('tdeuda');
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
				$recibo->idempresa= $ide;
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
		$mov->idempresa= $ide;
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
           //     DB::commit();
//	}
//catch(\Exception $e)
//{
//    DB::rollback();
//} 

return Redirect::to('gastos/gasto');
}
public function show(Request $request, $id){
	$ide=Auth::user()->idempresa;
    $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
    $gasto=DB::table('gasto as g')
            -> join ('proveedor as p','p.idproveedor','=','g.idpersona')
            -> select ('g.*','p.nombre','p.rif','p.telefono','p.direccion')
            ->where ('g.idgasto','=',$id)
            -> first();

            $comprobante=DB::table('comprobante as co')
            -> where ('co.idgasto','=',$id)
            ->get();

			$recibonc=DB::table('mov_notasp as mov')-> where ('mov.iddoc','=',$id)-> where ('mov.tipodoc','=',"GTO")
            ->get();

            return view("gastos.gasto.show",["recibonc"=>$recibonc,"gasto"=>$gasto,"comprobante"=>$comprobante,"empresa"=>$empresa]);
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
