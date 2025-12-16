<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Venta;
use sisventas\Articulo;
use sisventas\Recibo;
use DB;
use sisventas\DetalleVenta;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;

class Utilidad@Controller extends Controller
{
    public function __construct()
    {
     
    }
	
 public function index(Request $request)
    {
       
     
     return view ('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query]);
        
    } 
    public function create(){

        $personas=DB::table('clientes')-> where('status','=','A')->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')

        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo')
        -> get();
     if ($contador==""){$contador=0;}
      return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos,"contador"=>$contador]);
    }
    public function store(ventaFormRequest $request){
$user=Auth::user()->name;
			try{
    DB::beginTransaction();
//registra la venta
    $venta=new Venta;
    $venta->idcliente=$request->get('id_cliente');
    $venta->tipo_comprobante=$request->get('tipo_comprobante');
    $venta->serie_comprobante=$request->get('serie_comprobante');
    $venta->num_comprobante=$request->get('num_comprobante');
    $venta->total_venta=$request->get('total_venta');
    $mytime=Carbon::now('America/Lima');
    $venta->fecha_hora=$mytime->toDateTimeString();
    $venta->impuesto='12';
    $venta->saldo=($request->get('total_venta')-($request->get('pefe')+$request->get('pdeb')+$request->get('pche')+$request->get('ptrn')));
    if ($venta->saldo > 0){
    $venta->estado='Credito';} else { $venta->estado='Contado';}
    $venta->devolu='0';
    $venta->user=$user;
    $venta-> save();
//dd($request->get('id_cliente'));
    // inserta el recibo

$recibo=new Recibo;
$recibo->idventa=$venta->idventa;
$recibo->monto=$request->get('total_venta');
$recibo->efectivo=$request->get('pefe');
$recibo->debito=$request->get('pdeb');
$recibo->refdeb=$request->get('prefd');
$recibo->cheque=$request->get('pche');
$recibo->refche=$request->get('prefc');
$recibo->transferencia=$request->get('ptrn');
$recibo->reftrans=$request->get('preft');
$recibo->aux=$request->get('pefe')+$request->get('pdeb')+$request->get('pche')+$request->get('ptrn');
$recibo->save();
  //registra el detalle de la venta

   // $venta->idcliente=$request->get('id_cliente');
        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $descuento = $request -> get('descuento');
        $precio_venta = $request -> get('precio_venta');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleVenta();
            $detalle->idventa=$venta->idventa;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->cantidad=$cantidad[$cont];
            $detalle->descuento=$descuento[$cont];
            $detalle->precio_venta=$precio_venta[$cont];
            $detalle->save();
                      //actualizo stock   
        $articulo=Articulo::findOrFail($idarticulo[$cont]);
        $articulo->stock=$articulo->stock-$cantidad[$cont];
        $articulo->update();
            $cont=$cont+1;
            }
			

        DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}

return Redirect::to('ventas/venta');
}
public function show($id){

$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            -> join ('detalle_venta as dv','v.idventa','=','dv.idventa')
            -> join ('recibos as r','v.idventa','=','r.idventa')
            -> select ('v.idventa','v.fecha_hora','p.nombre','p.direccion','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta','r.*')
            ->where ('v.idventa','=',$id)
            -> first();

            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$id)
            ->get();

            return view("ventas.venta.show",["venta"=>$venta,"empresa"=>$empresa,"detalles"=>$detalles]);
}
  public function edit($idcliente){

        $personas=DB::table('clientes')
        -> where('status','=','A')
        -> where ('id_cliente','=',$idcliente)
        ->get();
         $contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->get();
      //dd($contador);
        $articulos =DB::table('articulo as art')

        -> select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'),'art.idarticulo','art.stock','art.precio1 as precio_promedio','art.precio2 as precio2')
        -> where('art.estado','=','Activo')
        -> where ('art.stock','>','0')
        ->groupby('articulo','art.idarticulo','art.stock')
        -> get();
     
     return view("ventas.venta.create",["personas"=>$personas,"articulos"=>$articulos,"contador"=>$contador]);
    }

public function destroy($id){

    $venta=Venta::findOrFail($id);
    $venta->estado='C';
    $venta->update();
    return Redirect::to('ventas/venta');
}
public function devolucion(){
   $id=2;
   // $id=$request->get('id');
//dd($id);
    $venta=Venta::findOrFail($id);
    $venta->impuesto='18';
    $venta->update();
  return Redirect::to('ventas/venta');
}
}
