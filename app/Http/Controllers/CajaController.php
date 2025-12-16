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
use sisventas\Monedas;
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
			$ide=Auth::user()->idempresa;
			$rol=DB::table('roles')-> select('accesobanco')->where('iduser','=',$request->user()->id)->first();
            $empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $caja=DB::table('monedas')-> where('idempresa','=',$ide)
            ->get();			
			return view('caja.caja.index',["rol"=>$rol,"caja"=>$caja,"empresa"=>$empresa]);
	
        }
    }
	    public function create()
    {
        return view("caja.caja.create");
    }
	    public function store (Request $request)
    {
		//dd($request);
		$ide=Auth::user()->idempresa;
        $categoria=new Monedas;
        $categoria->idempresa=$ide;
        $categoria->codigo=$request->get('codigo');
        $categoria->nombre=$request->get('nombre');
        $categoria->tipo=$request->get('tipo');
		$categoria->simbolo=$request->get('simbolo');
        $categoria->save();
        return Redirect::to('caja/caja');

    }
		   public function show($id)
    {
		
		$contador=DB::table('mov_ban')->select('id_mov')->limit('1')->orderby('id_mov','desc')->get();
		     $caja=DB::table('monedas')->where('idmoneda','=',$id)
			 ->select('idmoneda as codigo','idmoneda as idcaja','nombre','simbolo','idempresa')
				->first();
		$empresa=DB::table('empresa')-> where('idempresa','=',$caja->idempresa)->first();	
		$movimiento=DB::table('mov_ban')->where('idcaja','=',$id)->where('estatus','=',0)->get();
        $q1=DB::table('clientes')->where('idempresa','=',$caja->idempresa)->select('id_cliente as id','nombre','cedula as cedula','idbanco as tipo');
        $q2=DB::table('proveedor')->where('idempresa','=',$caja->idempresa)->select('idproveedor as id','nombre','rif as cedula','idbanco as tipo');
		$clientes= $q1->union($q2)->get();
		return view('caja.caja.show',["clientes"=>$clientes,"movimiento"=>$movimiento,"contador"=>$contador,"banco"=>$caja,"empresa"=>$empresa]);
		
	}
		    public function debito(Request $request)
    {
			$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		  //dd($request);
		 $idcliente=explode("_",$request->get('cliente'));
		$cliente=$idcliente[0];
		$tipo=$idcliente[1];
		$identificacion=$idcliente[2];
		$nombre=$idcliente[3];
         $mov=new Movbanco;
        $mov->idcaja=$request->get('idbanco');
		$mov->idempresa=$ide;
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
        $mov->fecha_mov=$request->get('fecha');
        $mov->user=Auth::user()->name;
        $mov->save();

	
     return Redirect::to('caja/caja/'.$mov->idcaja);   
    }
	public function credito(Request $request)
    {    
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$idcliente=explode("_",$request->get('cliente'));
		$cliente=$idcliente[0];
		$tipo=$idcliente[1];
		$identificacion=$idcliente[2];
		$nombre=$idcliente[3];
        $mov=new Movbanco;
        $mov->idcaja=$request->get('idbanco');
		$mov->idempresa=$ide;
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
        $mov->fecha_mov=$request->get('fecha');
        $mov->user=Auth::user()->name;
        $mov->save();
	
 return Redirect::to('caja/caja/'.$mov->idcaja);         
    }
public function consulta(Request $request, $var1)
    {    
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
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
    {    
	$id=$request->get('id');

      $corteHoy = date("Y-m-d");
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
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
     //   dd($mov);
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
		   public function detalle(Request $request,$id)
    {
	
			$corteHoy = date("Y-m-d");
		      $query=trim($request->get('searchText'));
                if (($query)==""){$query=$corteHoy; }
				$query2=trim($request->get('searchText2'));
				if (($query2)==""){$query2=$corteHoy; }
             
			$query2 = date_create($query2);
			$query = date_create($query);
			$fbanco = date_format($query, 'Y-m-d');
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$banco=DB::table('monedas as caja')->select('caja.nombre','caja.idmoneda as idcaja')->where('idmoneda','=',$id)->first();
        $movimiento=DB::table('mov_ban as mov')
        ->where('idcaja','=',$id)
		-> whereBetween('mov.fecha_mov', [$query, $query2])
		->where('mov.estatus','=',0)
        ->get();	
	//	dd($movimiento);
	

        return view("caja.caja.detalle",["movimiento"=>$movimiento,"banco"=>$banco,"searchText"=>$query,"searchText2"=>$query2]);
    }
			   public function detallef(Request $request)
    {
	$id=$request->get('id');
			$corteHoy = date("Y-m-d");
		      $query=trim($request->get('searchText'));
                if (($query)==""){$query=$corteHoy; }
				$query2=trim($request->get('searchText2'));
				if (($query2)==""){$query2=$corteHoy; }
             
			$query2 = date_create($query2);
			$query = date_create($query);
			$fbanco = date_format($query, 'Y-m-d');
            date_add($query2, date_interval_create_from_date_string('1 day'));
            $query2=date_format($query2, 'Y-m-d');
		$ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$banco=DB::table('monedas as caja')->select('caja.nombre','caja.idmoneda as idcaja')->where('idmoneda','=',$id)->first();
        $movimiento=DB::table('mov_ban as mov')
        ->where('idcaja','=',$id)
		-> whereBetween('mov.fecha_mov', [$query, $query2])
		->where('mov.estatus','=',0)
        ->get();	
	//	dd($movimiento);
	

        return view("caja.caja.detalle",["movimiento"=>$movimiento,"banco"=>$banco,"searchText"=>$query,"searchText2"=>$query2]);
    }
		public function recibo(Request $request, $id)
    {   
	//dd($id);
		
        $ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
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
           $query2 = $corteHoy = date("Y-m-d");    $query=$corteHoy; 
			$query2 = date_create($query2);
			date_add($query2, date_interval_create_from_date_string('1 day'));
			$query2=date_format($query2, 'Y-m-d');	
	$movimiento=Movbanco::findOrFail($id);
	$ba=$movimiento->idcaja;   	
	$movimiento->estatus='1';
	$movimiento->update();	
	$ide=$movimiento->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
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
	public function saldo(Request $request)
    {
	  $ide=Auth::user()->idempresa;
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();	
		
		$monedas=DB::table('monedas')-> where('idempresa','=',$ide)->get();

		$movimiento=DB::table('mov_ban')
		->select(DB::raw('SUM(monto) as tmonto'),'tipo_mov','idcaja')
		-> where('idempresa','=',$ide)
		->where('estatus','=',0)
		->where('tipo_mov','=',"N/C")
		->groupby('idcaja')
		->get();
		
		$debito=DB::table('mov_ban')
		->select(DB::raw('SUM(monto) as tmonto'),'tipo_mov','idcaja')
		-> where('idempresa','=',$ide)
		->where('estatus','=',0)
		->where('tipo_mov','=',"N/D")
		->groupby('idcaja')
		->get();
//dd($movimiento);
		return view('caja.caja.saldo',["movimiento"=>$movimiento,"debito"=>$debito,"monedas"=>$monedas,"empresa"=>$empresa]);
		
	}
			public function detalleventa($id)
   {	
  // dd($id);
   $data=explode("_",$id);
    $banco=$data[0];
    $id=$data[1];
		$recibo=DB::table('recibos as r')-> where ('r.idrecibo','=',$id)
            ->first();
	$empresa=DB::table('empresa')-> where('idempresa','=',$recibo->idempresa)->first();
			$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
			-> join ('vendedores as vend','vend.id_vendedor','=','v.idvendedor')
            -> select ('vend.nombre as vendedor','p.id_cliente','v.idventa','v.saldo','v.fecha_emi','p.nombre','p.cedula','p.licencia','p.telefono','p.ruta','p.direccion','p.contacto','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','v.devolu')
            ->where ('v.idventa','=',$recibo->idventa)
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta','dv.idarticulo')
            -> where ('dv.idventa','=',$venta->idventa)
			->orderBy('a.nombre','asc')
            ->get();
			$recibo=DB::table('recibos as r')-> where ('r.idventa','=',$venta->idventa)
            ->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$venta->idventa)-> where ('mov.tipodoc','=',"FAC")
            ->get();

		$cxc=DB::table('venta as ve')
		 -> join ('clientes as p','ve.idcliente','=','p.id_cliente')
         -> select(DB::raw('sum(ve.saldo) as saldo'))
		 ->where('ve.devolu','=',0)
		 ->where('ve.tipo_comprobante','=',"FAC")
		 ->where('ve.idcliente','=',$venta->id_cliente)
		-> groupby('ve.idcliente')->first();
		if($cxc==NULL){ $cxc=0;  }else { $cxc=$cxc->saldo;  }
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'))
			->where('not.tipo','=',1)
			->where('not.pendiente','>',0)
			->where('not.idcliente','=',$venta->id_cliente)			
			->groupby('not.idcliente')
			->first();
		if($notasnd==NULL){ $notasnd=0;  }else { $notasnd=$notasnd->tnotas;  }
			//dd($notasnd);
				$notasnc=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'))
			->where('not.tipo','=',2)
			->where('not.pendiente','>',0)
			->where('not.idcliente','=',$venta->id_cliente)
			->groupby('not.idcliente')
			->first();
				if($notasnc==NULL){ $notasnc=0;  }else { $notasnc=$notasnc->tnotas;  }
//dd($notasnc);

           $vacios=DB::table('deposito')->where('id_persona','=',$venta->id_cliente)
		   ->select('debe')
            ->first();	
	       return view("caja.caja.detalleventa",["articulo"=>$banco,"vacios"=>$vacios,"notasnc"=>$notasnc,"notasnd"=>$notasnd,"cxc"=>$cxc,"venta"=>$venta,"recibos"=>$recibo,"recibonc"=>$recibonc,"empresa"=>$empresa,"detalles"=>$detalles]);  
  }
}
