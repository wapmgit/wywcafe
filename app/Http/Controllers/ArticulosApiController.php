<?php
namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use sisventas\Articulo;
use Illuminate\Support\Facades\Redirect;
use DB;

use Exception;

class ArticulosApiController extends Controller
{
	private $errorServer = ['status' => 500, 'message' => 'Error de comunicación con el servidor de la base de datos.', 'data' => ''];
	private $recordsNotFound = ['status' => 400, 'message' => '0 registros encontrados.', 'data' => ''];

    public function sendData()
    { 
	$client = new Client([
    // Base URI is used with relative requests
    'base_uri' => 'http://pedidos.nks-sistemas.net',
    // You can set any number of default request options.
    'timeout'  => 200,
		]);
    // try {
		  // Nuevo cliente con un url base
		  $article = DB::table('articulo')->join('categoria as cat','cat.idcategoria','=','articulo.idcategoria')
			->select ('articulo.idarticulo','articulo.codigo','articulo.nombre','articulo.costo','articulo.precio1','articulo.precio2','articulo.stock')
			->where('cat.servicio','=',0)
			->where('articulo.estado','=',"Activo")
			->get(); 
		 // dd($article);
		//  $client = new Client(); //GuzzleHttp\Client
		$articlejs=json_encode($article);
		$response = $client->request('POST', 'http://creciven.com/api/recibir-articulos', [
			'form_params' => [
				'empresa' => '200',
				'articulos' => $articlejs 
				]
			]);
		//	return $response->getBody();
			//	dd(json_encode($article));
            if ($article)
                $records = sizeof($article);

           // return ($response)
           //     ? response()->json(['status' => 200, 'message' => (string)$records . ' registros enviados.', 'data' => $article])
   /*        //     : response()->json([$this->recordsNotFound]);
     } catch (Exception $e) {
         $link="almacen/articulo";
			     return view ('reportes.mensajes.sinconexion',["link"=>$link]);	      
		}*/
        return Redirect::to('almacen/articulo');
		}

}
