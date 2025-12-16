<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;

use sisventas\Http\Requests;
use sisventas\Http\Requests\AjusteFormRequest;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use DB;
use sisventas\Articulo;
use sisventas\Ajuste;
use sisventas\Kardex;
use sisventas\Datacsv;
use sisventas\DetalleAjuste;
use Auth;
use Carbon\Carbon;
use response;
use Illuminate\Support\Collection;

class AjusteController extends Controller
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
            $ajustes=DB::table('ajuste as a')
            -> join ('detalle_ajuste as da','a.idajuste','=','da.idajuste')
            -> select ('a.idajuste','a.fecha_hora','a.concepto','a.responsable','a.monto')
            -> where ('a.concepto','LIKE','%'.$query.'%')
            -> orderBy('a.idajuste','desc')
            -> groupBy('a.idajuste','a.fecha_hora')
                ->paginate(20);
     
     return view ('compras.ajuste.index',["ajustes"=>$ajustes,"empresa"=>$empresa,"searchText"=>$query]);
        }
    } 
    public function create(){
		$categorias=DB::table('categoria')->where('condicion','=','1')->get();
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
        $articulos =DB::table('articulo as art')
        -> select(DB::raw('CONCAT(art.codigo,"-",art.nombre," - ",art.stock," - ",art.costo,"-",art.iva) as articulo'),'art.idarticulo','art.stock','art.costo')
        -> where('art.estado','=','Activo')
        -> get();
        return view("compras.ajuste.create",["articulos"=>$articulos,"empresa"=>$empresa,"categorias"=>$categorias]);
    } 
    public function store(Request $request){
		//dd($request);
$user=Auth::user()->name;
try{
    DB::beginTransaction();
    $ajuste=new Ajuste;
    $ajuste->concepto=$request->get('concepto');
    $ajuste->responsable=$request->get('responsable');
    $ajuste->monto=$request->get('totalo');
    $mytime=Carbon::now('America/Caracas');
    $ajuste->fecha_hora=$mytime->toDateTimeString();
 
    $ajuste-> save();

        $idarticulo = $request -> get('idarticulo');
        $cantidad = $request -> get('cantidad');
        $tipo = $request -> get('tipo');
        $costo = $request -> get('precio_compra');

        $cont = 0;
            while($cont < count($idarticulo)){
            $detalle=new DetalleAjuste();
            $detalle->idajuste=$ajuste->idajuste;
            $detalle->idarticulo=$idarticulo[$cont];
            $detalle->tipo_ajuste=$tipo[$cont];

            $detalle->cantidad=$cantidad[$cont];
            $detalle->costo=$costo[$cont];
            $detalle->valorizado=($costo[$cont]*$cantidad[$cont]);
            $detalle->save();  
            $articulo=Articulo::findOrFail($idarticulo[$cont]);
$valida=$detalle->tipo_ajuste=$tipo[$cont];
//$articulo->costo=$costo[$cont];
//$costop= $costo[$cont];
//$impuesto= $articulo->iva;
//$utilidad= $articulo->utilidad;
//$util2= $articulo->util2;
//$pt=($costop + (($utilidad/100)*$costop))+($costop + (($utilidad/100)*$costop))*($impuesto/100);
  //  $pt2=($costop + (($util2/100)*$costop))+($costop + (($util2/100)*$costop))*($impuesto/100);
//$articulo->precio1=$pt;
//$articulo->precio2=$pt2;
    if($valida=="Cargo"){ $tipom=1;
$articulo->stock=($articulo->stock+$cantidad[$cont]);
    }else{ $tipom=2;
$articulo->stock=($articulo->stock-$cantidad[$cont]);
    }
        $articulo->update();           	
 		$kar=new Kardex;
		$kar->fecha=$mytime->toDateTimeString();
		$kar->documento="AJUS-".$ajuste->idajuste;
		$kar->idarticulo=$idarticulo[$cont];
		$kar->cantidad=$cantidad[$cont];
		$kar->costo=$costo[$cont];
		$kar->tipo=$tipom; 
		$kar->user=$user;
		 $kar->save();   
            $cont=$cont+1;
            }
        DB::commit();
}
catch(\Exception $e)
{
    DB::rollback();
}

return Redirect::to('compras/ajuste');
}
public function show($id){
    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
    $ajuste=DB::table('ajuste as a')

            -> join ('detalle_ajuste as da','a.idajuste','=','da.idajuste')
            -> select ('a.idajuste','a.fecha_hora','a.concepto','a.responsable','a.monto')
            ->where ('a.idajuste','=',$id)
            -> first();

            $detalles=DB::table('detalle_ajuste as da')
            -> join('articulo as a','da.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','da.cantidad','da.tipo_ajuste','da.costo')
            -> where ('da.idajuste','=',$id)
            ->get();

            return view("compras.ajuste.show",["ajuste"=>$ajuste,"detalles"=>$detalles,"empresa"=>$empresa]);
}
public function etiquetas($id){

    $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();

            $detalles=DB::table('detalle_ajuste as d')
            -> join('articulo as a','d.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','a.precio1','a.codigo')
            -> where ('d.idajuste','=',$id)
            ->get();
//dd($detalles);
            return view("compras.ajuste.etiquetas",["empresa"=>$empresa,"detalles"=>$detalles]);
}
public function loadcsv(Request $request){
         $empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
 $num=0;
 $consulta=[];
   $fname = $_FILES['sel_file']['name'];
    $chk_ext = explode(".",$fname);
	         if(strtolower(end($chk_ext)) == "csv")
         {
             //si es correcto, entonces damos permisos de lectura para subir
             $filename = $_FILES['sel_file']['tmp_name'];
             $handle = fopen($filename, "r");
 
             while (($data = fgetcsv($handle, 1500, ";")) !== FALSE)
             {
               //Insertamos los datos con los valores...
                
			$linea[]=array('codigo'=>$data[0],'cantidad'=>$data[1]);//Arreglo Bidimensional para guardar los datos de cada linea leida del archivo
			}          
             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
             fclose($handle);		
    foreach($linea as $indice=>$value) //Iteracion el array para extraer cada uno de los valores almacenados en cada items
    {
   $cod=$value["codigo"];//Codigo del producto
    $cantidad=$value["cantidad"];//descripcion del producto
    $codigo=trim($cod);
	$articulos=DB::table('articulo')->where('codigo','=',$codigo)->get();
	  $num=count($articulos); 
    if ($num>0)//Si es == 0 inserto 
	{
		    $data=new Datacsv;
    $data->idarticulo=$articulos[0]->idarticulo;
    $data->nombre=$articulos[0]->nombre;
    $data->costo=$articulos[0]->costo;
    $data->cantidad=$cantidad;
    $data->save();
		
		//$consulta[]=array("idarticulo"=>$articulos[0]->idarticulo,"nombre"=>$articulos[0]->nombre,"costo"=>$articulos[0]->costo,"cantidad"=>$cantidad);
    }//fin del if que comprueba que se guarden los datos

    }//fin deforecha

    }
	//$articulos=json_encode($consulta);
	$art=DB::table('datacsv')-> where('idarticulo','>',0)->get();
	//dd($art);
	$borrar=DB::table('datacsv')->where('id','>',0)->delete();
        return view("compras.ajuste.createcsv",["articulos"=>$art,"empresa"=>$empresa,"concepto"=>$request->get('conceptomodal'),"responsable"=>$request->get('responsablemodal')]);
}
   
}
