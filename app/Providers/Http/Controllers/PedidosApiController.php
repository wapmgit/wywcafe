<?php
namespace sisventas\Http\Controllers;


use sisventas\Venta;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use sisventas\Detallepedido;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Redirect;
use DB;
use Carbon\Carbon;
use Exception;
use Auth;
class PedidosApiController extends Controller
{
	private $errorServer = ['status' => 500, 'message' => 'Error de comunicación con el servidor de la base de datos.', 'data' => ''];
	private $recordsNotFound = ['status' => 400, 'message' => '0 registros encontrados.', 'data' => ''];

	public function sendData()
    {
		$user=Auth::user()->name;
      //  try {
		$client = new Client();	
		$response = $client->request('POST', 'http://pedidos.nks-sistemas.net/api/enviar-pedidos?empresa=100');		
		$datos= $response->getBody();
		$datos2=  json_decode($datos,false);          		 
		$datos3=$datos2->data;
		//dd($datos2);
		$longitud = count($datos3);	
		$array = array();
			foreach($datos3 as $t){
			$arraycliente[] 	= $t->cliente_id;
			$arrayvend[] 		= $t->vendedor;
			$arraymonto[] 		= $t->total_pedido;
			//$diascre=DB::table('clientes')->select('diascre')-> where('id_cliente','=',$t->cliente_id)->first();
			//$comision=DB::table('vendedores')->select('comision')-> where('id_vendedor','=',$t->vendedor)->first();
			$arraydiascre[] 	= $t->dias_credito;
			$arraycomi[] 		= $t->comision;
			$arrayarticulos[] 	= $t->articulos;	
			}
			

			for ($i=0;$i<$longitud;$i++){
				$venta=new Venta;
				$venta->idcliente=$arraycliente[$i];
				$venta->tipo_comprobante="PED";
				$venta->serie_comprobante="NE00";
					$contador=DB::table('venta')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
					$numero=$contador->idventa;
				$venta->num_comprobante=($numero+1);
				$venta->total_venta=$arraymonto[$i];
				$mytime=Carbon::now('America/Caracas');
				$venta->fecha_hora=$mytime->toDateTimeString();
				$venta->fecha_emi=$mytime->toDateTimeString();
				$venta->impuesto='16';
				$venta->saldo=$arraymonto[$i];
				$venta->estado='Credito';	
				$venta->devolu='0';
				$venta->idvendedor=$arrayvend[$i];
				$venta->diascre=$arraydiascre[$i];
				$venta->comision=$arraycomi[$i];
				$venta->montocomision=(($arraymonto[$i])*($arraycomi[$i]/100));
				$venta->user=$user;
				$venta->pweb=1;
				$venta-> save();
				//del registro de articulo del pedido
				//$longart = count($arrayarticulos);
				
				$arr=json_decode( $arrayarticulos[$i],TRUE);  
				$longart=count($arr);
//dd($arr);
						//$arr=json_decode( $arrayarticulos[0],TRUE);  
//dd($arr[0]['precio']); 
						/* foreach($arr as $art){
							$arrayprecio[] 		= $art->precio;
							$arraycnt[] 		= $art->cantidad;
							$arrayart[] 		= $art->idarticulo;	
							//$datsoart=DB::table('articulos')->select('costo','precio2')-> where('idarticulo','=',$art->id_articulo)->first();							
							$arraycosto[]		= $art->costo;
							$arraypreciof[]		= $art->precio2;
						}	*/
						//$acumgadm=0;
							for ($j=0;$j<$longart;$j++){
						            $detalle=new Detallepedido();
									$detalle->idventa=$venta->idventa;
									$detalle->idarticulo=$arr[$j]['idarticulo']; 		
									$detalle->costoarticulo=$arr[$j]['costo'];
									$detalle->cantidad=$arr[$j]['cantidad'];
									$detalle->descuento=0;
									$detalle->precio_venta=$arr[$j]['precio'];
									$detalle->preciof=$arr[$j]['precio2'];
									//$acumgadm=($acumgadm+($arr[$j]['precio2']-$arr[$j]['precio']));
									$detalle->fecha_emi=$mytime->toDateTimeString();	
									$detalle->save();
							}   						
			}

			//dd($datos3); //obten go todos los pedidos
			// dd(json_decode($datos3[0]->articulos,false)); obtengo la lista de articulos del array
			/*if ($response)
                $records = sizeof($response);

				return ($response->ok())
                ? response()->json(['status' => 200, 'message' => (string)$records . ' registros enviados.', 'data' => $response['data']])
                : response()->json([$this->recordsNotFound]);
		   } catch (Exception $e) {
            return response()->json($this->errorServer); */
			  return Redirect::to('pedido/pedido');
	}

}
