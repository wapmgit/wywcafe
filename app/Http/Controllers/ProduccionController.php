<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use sisventas\Http\Requests;
use sisventas\Ptostado;
use sisventas\Pmolida;
use sisventas\Produccion;
use sisventas\Tostador;
use sisventas\Depmaquina;
use sisventas\DetalleProduccion;
use sisventas\Articulo;
use sisventas\Kardex;
use DB;
use Auth;
use Carbon\Carbon;

class ProduccionController extends Controller
{
 public function indext(Request $request)
    {
        if ($request)
        {
				$ide=Auth::user()->idempresa;
			$rol=DB::table('roles')-> select('metae')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
            $data=DB::table('ptostado as t')
			->join('tostador as to','to.id','=','t.tostador')
            -> where ('to.nombre','LIKE','%'.$query.'%')  
			->orderBy('idt','desc')
            ->paginate(20);
    	 if($rol->metae){
     return view ('produccion.tostado.index',["data"=>$data,"searchText"=>$query,"empresa"=>$empresa]);
		}else{
			return view('reportes.mensajes.noautorizado');	
		 }
        }
    }
		 public function createt(Request $request)
    {
		$ide=Auth::user()->idempresa;
		 $tostador=DB::table('tostador')		
               ->where ('idempresa','=',$ide)		
            ->get();
		 $producto=DB::table('articulo')		
            ->where ('idempresa','=',$ide)
             ->where ('nivelp','=',1)
            ->get();

		 $materia=DB::table('articulo as a')
			->select('a.idarticulo','a.nombre','a.stock')			
            ->where ('a.idempresa','=',$ide)
            ->where ('a.mprima','=',1)
            ->where ('a.nivelp','=',0)
            ->orderBy('a.nombre','asc')
            ->get();
        return view("produccion.tostado.create",["materia"=>$materia,"tostador"=>$tostador,"producto"=>$producto]);
    }
		    public function savetostado (Request $request)
    {
		dd($request);
		$user=Auth::user()->name;
		$ide=Auth::user()->idempresa;
        $categoria=new Ptostado;
        $categoria->idempresa=$ide;
        $categoria->tostador=$request->get('tostador');
        $categoria->cochas=$request->get('cochas');
        $categoria->idmprima=$request->get('mprima');
        $categoria->kgmprima=$request->get('kgsubidos');
        $categoria->kgtostado=$request->get('kgtostados');
        $categoria->idproducto=$request->get('producto');
        $categoria->comision=$request->get('comi');
        $categoria->comima=$request->get('comima');
        $categoria->kgcomi=$request->get('kgcomi');
        $categoria->kgcomima=$request->get('kgcomima');
        $categoria->responsable=$request->get('responsable');
        $categoria->reduccion=$request->get('reduccion');
		$mytime=Carbon::now('America/Caracas');
        $categoria->fecha=$mytime->toDateTimeString();
        $categoria->save();
		//reg tostador
		$tost=Tostador::findOrFail($request->get('tostador'));
		$tost->kg=$tost->kg+$request->get('kgcomi');
		$tost->pendiente=$tost->pendiente+$request->get('kgcomi');
		$tost->update();
		$dep=Depmaquina::findOrFail(1);
		$dep->kg=$dep->kg+$request->get('kgcomima');
		$dep->pendiente=$dep->pendiente+$request->get('kgcomima');
		$dep->update();
		//sale
		$articulo=Articulo::findOrFail($request->get('mprima'));
		$stock=$articulo->stock;
		$articulo->stock=$articulo->stock-$request->get('kgsubidos');
		$articulo->update();		
		$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="PRODT-".$categoria->idt;
		$kar->idarticulo=$request->get('mprima');
		$kar->cantidad=$request->get('kgsubidos');
		$kar->exis_ant=$stock;
		$kar->costo=$articulo->costo;
		$kar->tipo=2; 
		$kar->user=$user;
		$kar->save();
		//entra
		$articulo=Articulo::findOrFail($request->get('producto'));
		$stock=$articulo->stock;
		$articulo->stock=$articulo->stock+$request->get('kgtostados');
		$articulo->update();
		$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="PRODT-".$categoria->idt;
		$kar->idarticulo=$request->get('producto');
		$kar->cantidad=$request->get('kgtostados');
		$kar->exis_ant=$stock;
		$kar->costo=$articulo->costo;
		$kar->tipo=1; 
		$kar->user=$user;
		$kar->save();
        return Redirect::to('produccion/tostado');

    }
	public function savemolida (Request $request)
    {
		//dd($request);
		$user=Auth::user()->name;
		$ide=Auth::user()->idempresa;
        $categoria=new produccion;
        $categoria->idempresa=$ide;
        $categoria->responsable=$request->get('responsable');
        $categoria->encargado=$request->get('encargado');
        $categoria->idmprima=$request->get('mprima');
        $categoria->kgsubido=$request->get('kgsubidos');
        $categoria->kgmolidos=$request->get('kgtostados');
        $categoria->reduccion=$request->get('reduccion');
        $categoria->idproductofinal=$request->get('producto');
        $categoria->tipoemp=$request->get('tipoemp');
        $categoria->kgempa=$request->get('kgemp');
        $categoria->kgdif=$request->get('kgdif');
        $categoria->usuario=$user;
		$mytime=Carbon::now('America/Caracas');
        $categoria->fecha=$mytime->toDateTimeString();
        $categoria->save();
		
		   $idp=$request->get('idproduccion');
           $produ=$request->get('produccion');
		   $kgp=$request->get('kgproduccion');	 
           $contp=0;
			while($contp < count($idp)){
				$recibo=new DetalleProduccion;
				$recibo->idproduccion=$categoria->idproduccion;
				$recibo->idarticulo= $idp[$contp];
				$recibo->cantidad=$produ[$contp];
				$recibo->kgproduccion=$kgp[$contp];			
				if($produ[$contp]>0){$recibo->save();}
			
			$articulo=Articulo::findOrFail($idp[$contp]);
			$stock=$articulo->stock;
			$articulo->stock=$articulo->stock+$produ[$contp];
			if($produ[$contp]>0){$articulo->update();}		
			$kar=new Kardex;
			$kar->fecha=$mytime->toDateTimeString();
			$kar->documento="PRODME-".$categoria->idproduccion;
			$kar->idarticulo=$idp[$contp];
			$kar->cantidad=$produ[$contp];
			$kar->exis_ant=$stock;
			$kar->costo=$articulo->costo;
			$kar->tipo=1; 
			$kar->user=$user;
			if($produ[$contp]>0){$kar->save();}
				 $contp=$contp+1;
			  }  
		//sale

		//entra
		$articulo=Articulo::findOrFail($request->get('mprima'));
		$stock=$articulo->stock;
		$articulo->stock=$articulo->stock-$request->get('kgsubidos');
		$articulo->update();
		$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="PRODME-".$categoria->idproduccion;
		$kar->idarticulo=$request->get('mprima');
		$kar->cantidad=$request->get('kgsubidos');
		$kar->exis_ant=$stock;
		$kar->costo=$articulo->costo;
		$kar->tipo=2; 
		$kar->user=$user;
		$kar->save();
        return Redirect::to('produccion/molida');

    }
	public function dettostado($id)
    {
    	 $det=DB::table('ptostado as pt')
		 ->join('articulo as art','art.idarticulo','=','pt.idmprima')
		 ->join('articulo as arts','arts.idarticulo','=','pt.idproducto')
		 ->join('tostador as tos','tos.id','=','pt.tostador')
		 ->select('pt.*','art.nombre as psalida','arts.nombre as pentrada','tos.nombre')
		 ->where('pt.idt','=',$id)->first();
		// dd($det);
		 $empresa=DB::table('empresa')-> where('idempresa','=',$det->idempresa)->first();
		 
        return view("produccion.tostado.show",["det"=>$det,"empresa"=>$empresa]);
    }
	 public function indexm(Request $request)
    {
        if ($request)
        {
			$ide=Auth::user()->idempresa;
			$rol=DB::table('roles')-> select('metae')->where('iduser','=',$request->user()->id)->first();
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
            $query=trim($request->get('searchText'));
            $data=DB::table('produccion as t')
            -> where ('t.responsable','LIKE','%'.$query.'%')  
			->orderBy('idproduccion','desc')
            ->paginate(20);
    	 if($rol->metae){
     return view ('produccion.molida.index',["data"=>$data,"searchText"=>$query,"empresa"=>$empresa]);
		}else{
			return view('reportes.mensajes.noautorizado');	
		 }
        }
    }
	public function createm(Request $request)
    {
		$ide=Auth::user()->idempresa;
		 $otros=DB::table('articulo')		
            ->where ('idempresa','=',$ide)
             ->where ('nivelp','=',3)
            ->get();
		 $producto=DB::table('articulo')		
            ->where ('idempresa','=',$ide)
             ->where ('nivelp','=',2)
            ->get();

		 $materia=DB::table('articulo as a')
			->select('a.idarticulo','a.nombre','a.stock')			
            ->where ('a.idempresa','=',$ide)
            ->where ('a.mprima','=',1)
            ->where ('a.nivelp','=',1)
            ->orderBy('a.nombre','asc')
            ->get();
        return view("produccion.molida.create",["materia"=>$materia,"otros"=>$otros,"producto"=>$producto]);
    }
		public function detmolida($id)
    {

    	 $data=DB::table('produccion as p')
		 ->join('articulo as art','art.idarticulo','=','p.idmprima')
		 ->join('articulo as a','a.idarticulo','=','p.idproductofinal')
		 ->select('p.*','art.nombre as materiaprima','a.nombre as pfinal')
		 ->where('p.idproduccion','=',$id)->first();
		 		
		$det=DB::table('produccion as p')
		->join('detalle_produccion as dp','dp.idproduccion','=','p.idproduccion')
		->join('articulo as art','art.idarticulo','=','dp.idarticulo')
		->select('dp.*','art.nombre')
		 ->where('p.idproduccion','=',$id)->get();
		// dd($det);
		 $empresa=DB::table('empresa')-> where('idempresa','=',$data->idempresa)->first();
		 
        return view("produccion.molida.show",["det"=>$det,"data"=>$data,"empresa"=>$empresa]);
    }
}
