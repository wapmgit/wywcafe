<?php

namespace sisventas\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class SendArticle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviararticulos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
   		  $article = DB::table('articulo')->join('categoria as cat','cat.idcategoria','=','articulo.idcategoria')
			->select ('articulo.idarticulo','articulo.codigo','articulo.nombre','articulo.costo','articulo.precio1','articulo.precio2','articulo.stock')
			->where('cat.servicio','=',0)
			->where('articulo.estado','=',"Activo")
			->get(); 

		$articlejs=json_encode($article);
		 $client = new Client();
		$response = $client->request('POST', 'http://pedidos.nks-sistemas.net/api/recibir-articulos', [
			'form_params' => [
				'empresa' => '200',
				'articulos' => $articlejs 
				]
			]);
    }
}
