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
   //   try {	
		  $clients = DB::table('clientes as cli')
		 ->join('vendedores as vend','vend.id_vendedor','=','cli.vendedor')
		  ->leftjoin('venta as v','v.idcliente','=','cli.id_cliente')
		  ->select(DB::raw('sum(v.saldo) as cxc'),'cli.id_cliente','cli.nombre','cli.cedula','cli.cedula as rif','cli.direccion','cli.telefono','cli.diascre as dias_credito','cli.vendedor','vend.comision')
		 ->orderby('id_cliente','desc')		  
		 ->groupby('cli.id_cliente')
		  ->get(); 		  
		
		  
		  
  //dd($clients[0]->id_cliente);
  
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
 //dd($clients);	
		$clientesjs=json_encode($clients);
		//  $client = new Client(); //GuzzleHttp\Client
		$response = $client->request('POST', 'http://pedidos.nks-sistemas.net/api/recibir-clientes', [
			'form_params' => [
				'empresa' => '100',
				'clientes' => $clientesjs 
			]
		]);
	//return $response->getBody();
            if ($clients)
                $records = sizeof($clients);

         //   return ($response)
        //        ? response()->json(['status' => 200, 'message' => (string)$records . ' registros enviados.', 'data' => $clients])
         //       : response()->json([$this->recordsNotFound]);
     //  } catch (Exception $e) {
       //     return response()->json($this->errorServer);        
		//}
		   return Redirect::to('pacientes/paciente');
}
}

