<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Movbanco;
use sisventas\Venta;
use sisventas\ingreso;
use sisventas\recibo_comision;
use sisventas\Gastos;
use sisventas\Comisiones;
use sisventas\comprobante;
use sisventas\Recibo;
use DB;
use Carbon\Carbon;
use Auth;

class CajaController extends Controller
{
        public function index(Request $request)
    {
        if ($request)
        {
			//$rol=DB::table('roles')-> select('accesocaja','editcaja')->where('iduser','=',$request->user()->id)->first();
            $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
            $caja=DB::table('monedas')
            ->get();			
			return view('caja.caja.index',["caja"=>$caja,"empresa"=>$empresa]);
	
        }
    }
		   public function show($id)
    {
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$contador=DB::table('mov_ban')->select('id_mov')->limit('1')->orderby('id_mov','desc')->get();
		     $caja=DB::table('monedas')->where('idmoneda','=',$id)->select('idmoneda as codigo','idmoneda as idcaja','nombre','simbolo')
            ->first();
				$movimiento=DB::table('mov_ban')->where('idcaja','=',$id)->where('estatus','=',0)->get();
        $q1=DB::table('clientes')->select('id_cliente as id','nombre','cedula as cedula','idbanco as tipo');
        $q2=DB::table('proveedor')->select('idproveedor as id','nombre','rif as cedula','idbanco as tipo');
		$clientes= $q1->union($q2)->get();
		return view('caja.caja.show',["clientes"=>$clientes,"movimiento"=>$movimiento,"contador"=>$contador,"banco"=>$caja,"empresa"=>$empresa]);
		
	}
		    public function debito(Request $request)
    {
	          $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		  //dd($request);
		 $idcliente=explode("_",$request->get('cliente'));
		$cliente=$idcliente[0];
		$tipo=$idcliente[1];
		$identificacion=$idcliente[2];
		$nombre=$idcliente[3];
         $mov=new Movbanco;
        $mov->idcaja=$request->get('idbanco');
		$mov->iddocumento=0;
        $mov->tipo_mov="N/D";
        $mov->numero=$request->get('numero');
        $mov->concepto=$request->get('concepto');
		$mov->tipo_per=$tipo;
        $mov->idbeneficiario=$cliente;
		$mov->identificacion=$identificacion;
        $mov->nombre=$nombre;
        $mov->monto=$request->get('monto');
		$mov->tasadolar=$empresa->tasa_banco;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=Auth::user()->name;
        $mov->save();

	
     return Redirect::to('caja/caja/'.$mov->idcaja);   
    }
		     public function credito(Request $request)
    {    
	
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$idcliente=explode("_",$request->get('cliente'));
		$cliente=$idcliente[0];
		$tipo=$idcliente[1];
		$identificacion=$idcliente[2];
		$nombre=$idcliente[3];
        $mov=new Movbanco;
        $mov->idcaja=$request->get('idbanco');
        $mov->tipo_mov="N/C";
        $mov->numero=$request->get('numero');
        $mov->concepto=$request->get('concepto');
        $mov->tipo_per=$tipo;
        $mov->idbeneficiario=$cliente;
        $mov->identificacion=$identificacion;
        $mov->nombre=$nombre;
        $mov->monto=$request->get('monto');
		$mov->tasadolar=$empresa->tasa_banco;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=Auth::user()->name;
        $mov->save();
	
 return Redirect::to('caja/caja/'.$mov->idcaja);         
    }
public function consulta($var1)
    {    
	$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $data=substr($var1, 0, 3);
    $data2=substr($var1, 3, 2);
    IF($data=="DEB"){$data="N/D"; $nombre="DEBITOS";} IF($data=="CRE"){$data="N/C"; $nombre="CREDITOS";}

        $banco=DB::table('monedas')->where('idmoneda','=',$data2)->first();
        $movimiento=DB::table('mov_ban')
         ->where('mov_ban.estatus','=',0)
		->where('idcaja','=',$data2)
        ->where('tipo_mov','=',$data)
        ->get();

        return view("caja.caja.consulta",["banco"=>$banco,"movimiento"=>$movimiento,"detalle"=>$nombre,"empresa"=>$empresa]);
 
        
    }
public function movimientos(Request $request)
    {    $id=$request->get('id');

      $corteHoy = date("Y-m-d");
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
         $banco=DB::table('monedas')-> where('idmoneda','=',$id)->get();
             $query=trim($request->get('searchText'));
                if (($query)==""){$query=$corteHoy; }
				$query2=trim($request->get('searchText2'));
				if (($query2)==""){$query2=$corteHoy; }
             
         $query2 = date_create($query2);
         $query = date_create($query);
		  $fbanco = date_format($query, 'Y-m-d');
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');

            $mov=DB::table('monedas as caja')
            ->join('mov_ban as mv','caja.idmoneda','=','mv.idcaja')
            ->where('caja.idmoneda','=',$id)
			->where('mv.estatus','=',0)
            -> whereBetween('mv.fecha_mov', [$query, $query2])
            ->orderby('mv.id_mov', 'asc')
           ->get();
       // dd($mov);
	 $saldo=DB::table('mov_ban')
	 ->select('tipo_mov',DB::raw('SUM(monto) as tmonto' ))
	 ->where('idcaja','=',$id)
	 	 ->where('mov_ban.estatus','=',0)
	  -> whereBetween('fecha_mov', ['2022-10-01', $fbanco])
	  	 ->where('mov_ban.estatus','=',0)
	 ->groupby('tipo_mov')->get();
	 // dd($saldo);
        return view('caja.caja.detalladohistorico',["saldo"=>$saldo,"movimiento"=>$mov,"empresa"=>$empresa,"banco"=>$banco]);
            
    }
		   public function detalle($id)
    {
			$corteHoy = date("Y-m-d"); $corteHoy= date_create($corteHoy);
			$corteHoy2 = date("Y-m-d"); $corteHoy2= date_create($corteHoy2);
			date_add($corteHoy, date_interval_create_from_date_string('-1 day')); $query=date("Y-m-d"); 
			date_add($corteHoy2, date_interval_create_from_date_string('1 day')); $query2=date("Y-m-d"); 
			
			$corteHoy=date_format($corteHoy, 'Y-m-d h:m:s');
			$corteHoy2=date_format($corteHoy2, 'Y-m-d h:m:s');
	
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$banco=DB::table('monedas as caja')->select('caja.nombre','caja.idmoneda as idcaja')->where('idmoneda','=',$id)->first();
        $movimiento=DB::table('mov_ban as mov')
        ->where('idcaja','=',$id)
		-> whereBetween('mov.fecha_mov', [$corteHoy, $corteHoy2])
		->where('mov.estatus','=',0)
        ->get();	
	//	dd($movimiento);
	

        return view("caja.caja.detalle",["movimiento"=>$movimiento,"banco"=>$banco,"searchText"=>$query,"searchText2"=>$query2]);
    }
		public function recibo($id)
    {   
	//dd($id);
		
        $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$recibo=explode("_",$id);
		$idrecibo=$recibo[0];
		$tipo=$recibo[1];
		$caja=$recibo[2];
		$banco=DB::table('monedas')->select('monedas.simbolo')->where('idmoneda','=',$caja)->first();
		if($tipo=="P"){
            $mov=DB::table('mov_ban')
            ->join('proveedor as cli','mov_ban.idbeneficiario','=','cli.idproveedor')
			->select('mov_ban.*','cli.nombre','cli.rif as cedula')
            ->where('id_mov','=',$idrecibo)
           ->first();
		}
		   if($tipo=="C"){
            $mov=DB::table('mov_ban')
            ->join('clientes as cli','mov_ban.idbeneficiario','=','cli.id_cliente')
			->select('mov_ban.*','cli.nombre','cli.cedula as cedula')
            ->where('id_mov','=',$idrecibo)
           ->first();}
		   if($tipo=="V"){
            $mov=DB::table('mov_ban')
            ->join('vendedores as cli','mov_ban.idbeneficiario','=','cli.id_vendedor')
			->select('mov_ban.*','cli.nombre','cli.cedula as cedula')
            ->where('id_mov','=',$idrecibo)
           ->first();}
	//	dd($mov);
        return view('caja.caja.recibobanco',["caja"=>$banco,"movimiento"=>$mov,"empresa"=>$empresa]);
            
    }
			public function destroy($id)
    {		
//	dd($id);
			$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
           $query2 = $corteHoy = date("Y-m-d");    $query=$corteHoy; 
			$query2 = date_create($query2);
			date_add($query2, date_interval_create_from_date_string('1 day'));
			$query2=date_format($query2, 'Y-m-d');	
	$movimiento=Movbanco::findOrFail($id);
	$ba=$movimiento->idcaja;   	
	$movimiento->estatus='1';
	$movimiento->update();	
	//elimino recibo actualizao documento
			if ($movimiento->tipodoc=="VENT"){
			$recibo=Recibo::findOrFail($movimiento->iddocumento);
			 $venta=$recibo->idventa;
			 $monton=$recibo->monto;
			 $recibo->referencia='Anulado';
			 $recibo->monto='0,0';
			 $recibo->recibido='0,0';
			 $recibo->update();

			 $ingreso=Venta::findOrFail($venta);
			  $ingreso->saldo=($ingreso->saldo+$monton);
				$ingreso->update();
				}
			if ($movimiento->tipodoc=="COMP"){
			$recibo=comprobante::findOrFail($movimiento->iddocumento);
			 $compra=$recibo->idcompra;
			 $monton=$recibo->monto;
			 $recibo->referencia='Anulado';
			 $recibo->monto='0,0';
			 $recibo->recibido='0,0';
			 $recibo->update();

			 $ingreso=ingreso::findOrFail($compra);
			  $ingreso->saldo=($ingreso->saldo+$monton);
				$ingreso->update();
			}
			if ($movimiento->tipodoc=="GAST"){
			$recibo=comprobante::findOrFail($movimiento->iddocumento);
			 $compra=$recibo->idgasto;
			 $monton=$recibo->monto;
			 $recibo->referencia='Anulado';
			 $recibo->monto='0,0';
			 $recibo->recibido='0,0';
			 $recibo->update();

			 $ingreso=Gastos::findOrFail($compra);
			  $ingreso->saldo=($ingreso->saldo+$monton);
				$ingreso->update();
			}
			if ($movimiento->tipodoc=="COMI"){
			$recibo=recibo_comision::findOrFail($movimiento->iddocumento);
			 $compra=$recibo->id_comision;
			 $monton=$recibo->monto;
			 $recibo->referencia='Anulado';
			 $recibo->monto='0,0';
			 $recibo->recibido='0,0';
			 $recibo->update();

			 $ingreso=Comisiones::findOrFail($compra);
			  $ingreso->pendiente=($ingreso->pendiente+$monton);
			$ingreso->update();
			}
	//
		$banco=DB::table('monedas')-> where('idmoneda','=',$ba)->get();

			$mov=DB::table('monedas as caja')
            ->join('mov_ban as mv','caja.idmoneda','=','mv.idcaja')
            ->where('caja.idmoneda','=',$ba)
			->where('mv.estatus','=',0)
            -> whereBetween('mv.fecha_mov', [$query, $query2])
            ->orderby('mv.id_mov', 'asc')
           ->get();
		   
	 $saldo=DB::table('mov_ban')
	 ->select('tipo_mov',DB::raw('SUM(monto) as tmonto' ))
	 ->where('idcaja','=',$ba)
	  ->where('mov_ban.estatus','=',0)
	  -> whereBetween('fecha_mov', ['2023-03-01', $query2])
	 ->groupby('tipo_mov')->get();

        return view('caja.caja.detalladohistorico',["saldo"=>$saldo,"movimiento"=>$mov,"empresa"=>$empresa,"banco"=>$banco]);
    }
			   public function saldo()
    {
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$monedas=DB::table('monedas')->get();

		$movimiento=DB::table('mov_ban')
		->select(DB::raw('SUM(monto) as tmonto'),'tipo_mov','idcaja')
		->where('estatus','=',0)
		->where('tipo_mov','=',"N/C")
		->groupby('idcaja')
		->get();
		
		$debito=DB::table('mov_ban')
		->select(DB::raw('SUM(monto) as tmonto'),'tipo_mov','idcaja')
		->where('estatus','=',0)
		->where('tipo_mov','=',"N/D")
		->groupby('idcaja')
		->get();
//dd($movimiento);
		return view('caja.caja.saldo',["movimiento"=>$movimiento,"debito"=>$debito,"monedas"=>$monedas,"empresa"=>$empresa]);
		
	}
}
