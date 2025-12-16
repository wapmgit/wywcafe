<?php
namespace sisventas\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use sisventas\Mov_notas;
use DB;

use sisventas\Pacientes as Clientes;

//use App\Models\Clientes;
use Exception;

class ClientsApiController extends Controller
{
    private $errorServer = ['status' => 500, 'message' => 'Error de comunicación con el servidor de la base de datos.', 'data' => ''];
    private $recordsNotFound = ['status' => 400, 'message' => '0 registros encontrados.', 'data' => ''];

    public function sendData()
    { 
		$client = new Client([
		'base_uri' => 'http://pedidos.nks-sistemas.net',
		'timeout'  => 200,
		]);
     try {	
		  $clients = DB::table('clientes as cli')
		  ->join('vendedores as vend','vend.id_vendedor','=','cli.vendedor')	
		 ->select(DB::raw('(space(12)*0) as cxc'),DB::raw('(space(12)*0) as vacios'),'cli.id_cliente','cli.nombre','cli.cedula','cli.cedula as rif','cli.direccion','cli.telefono','cli.diascre as dias_credito','cli.vendedor','vend.comision')
		 ->where('status','=',"A")
		 ->orderby('id_cliente','desc')		  
		 ->groupby('cli.id_cliente')
		  ->get(); 		  
			
			$ventas=DB::table('venta as v')
			->select(DB::raw('sum(v.saldo) as cuenta'),'v.idcliente')
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->where('v.saldo','>',0)
			->groupby('v.idcliente')
			->get();
			
			$detalleventas=DB::table('venta as v')
			->join('detalle_venta as dv','dv.idventa','=','v.idventa')
			->join('articulo as art','art.idarticulo','=','dv.idarticulo')
			->select('dv.idventa','art.nombre','dv.cantidad','dv.precio_venta')
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->where('v.saldo','>',0)
			->get();
		   
		   $longitudc = count($clients);
			$longitudn = count($ventas);	
			for ($i=0;$i<$longitudc;$i++){
				for($j=0;$j<$longitudn;$j++){
				if ($clients[$i]->id_cliente==$ventas[$j]->idcliente){
					$clients[$i]->cxc=$ventas[$j]->cuenta;
				};
				}
			}	
			//vacios	
			$vacios=DB::table('deposito')
			->select(DB::raw('sum(debe-debo) as vacios'),'id_persona as idcliente')
			->groupby('id_persona')
			->get();
			
			$longitudv = count($vacios);	
			for ($i=0;$i<$longitudc;$i++){
				for($j=0;$j<$longitudv;$j++){
				if ($clients[$i]->id_cliente==$vacios[$j]->idcliente){
					$clients[$i]->vacios=$vacios[$j]->vacios;
				};
				}
			}
			//dd($clients);
  
			$q2=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select('n.tipo',DB::raw('sum(n.pendiente) as saldo'),'c.id_cliente','c.nombre')
			->where('n.pendiente','>',0)
			->groupby('n.tipo','n.idcliente')
			->get();
					 	
		$longitud = count($clients);		
			for ($i=0;$i<$longitud;$i++){
				foreach($q2 as $t){
						
					if(($clients[$i]->id_cliente==$t->id_cliente) and ($t->tipo==1)){
						$aux=$clients[$i]->cxc;
						if(is_null($aux)) {$aux=0;}
						$clients[$i]->cxc=($t->saldo + $aux);
					}  
					if(($clients[$i]->id_cliente==$t->id_cliente) and ($t->tipo==2)){
						$aux2=$clients[$i]->cxc;
						if(is_null($aux2)) {$aux2=0;}
						$clients[$i]->cxc=($aux2 - $t->saldo);
					} 
			}  
		}  
		//obtener la cuenta por cobrar
        $q1=DB::table('venta')->select('idcliente',DB::raw('CONCAT("FAC-",idventa) as doc'),'fecha_emi as fecha','total_venta as monto','saldo')
						->where('tipo_comprobante','=','FAC')
						->where('devolu','=',0)
						->where('saldo','>',0); 
        $q2=DB::table('notasadm')->select('idcliente',DB::raw('CONCAT("N/D-",idnota) as doc'),'fecha as fecha','monto','pendiente as saldo')
		->where('pendiente','>',0)
		->where('tipo','=',1);
		$ventascxc= $q1->union($q2)->get(); 
		
		// los recibos
			$recibos=DB::table('venta as v')
			->join('recibos as r','r.idventa','=','v.idventa')
			->select('r.idventa','r.monto','r.idbanco as moneda','r.recibido','r.fecha')
			->where('v.saldo','>',0)
			->where('v.devolu','=',0)
			->get();
			
		//	
		$empresa=DB::table('empresa')->select('tc')-> where('idempresa','=','1')->first();	
		
		//$emprejs=json_encode($empresa);
		$clientesjs=json_encode($clients);
		$recibosjs=json_encode($recibos);
		$ventasjs=json_encode($ventascxc);
		$detalleventasjs=json_encode($detalleventas);
		
		//  $client = new Client(); //GuzzleHttp\Client
		$response = $client->request('POST', 'http://creciven.com/api/recibir-clientes', [
			'form_params' => [
				'empresa' => '200',
				'clientes' => $clientesjs,
				'ventas' => $ventasjs,			
				'recibos' => $recibosjs,
				'detalleventas' => $detalleventasjs,
				'tasa' => $empresa->tc	
			]
		]);
	//return $response->getBody();
            if ($clients)
                $records = sizeof($clients);

         //   return ($response)
        //        ? response()->json(['status' => 200, 'message' => (string)$records . ' registros enviados.', 'data' => $clients])
         //       : response()->json([$this->recordsNotFound]);
     } catch (Exception $e) {
		$link="pacientes/paciente";
	     return view ('reportes.mensajes.sinconexion',["link"=>$link]);		
	}
		   return Redirect::to('pacientes/paciente');
}
}

