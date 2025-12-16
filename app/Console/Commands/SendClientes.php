<?php

namespace sisventas\Console\Commands;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use sisventas\Http\Requests;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use DB;

class SendClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'enviarclientes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'enviar clientes';

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

        $q1=DB::table('venta')->select('idcliente',DB::raw('CONCAT("FAC-",idventa) as doc'),'fecha_emi as fecha','total_venta as monto','saldo')
						->where('tipo_comprobante','=','FAC')
						->where('devolu','=',0)
						->where('saldo','>',0); 
        $q2=DB::table('notasadm')->select('idcliente',DB::raw('CONCAT("N/D-",idnota) as doc'),'fecha as fecha','monto','pendiente as saldo')
		->where('pendiente','>',0)
		->where('tipo','=',1);
		$ventascxc= $q1->union($q2)->get(); 
		
			$recibos=DB::table('venta as v')
			->join('recibos as r','r.idventa','=','v.idventa')
			->select('r.idventa','r.monto','r.idbanco as moneda','r.recibido','r.fecha')
			->where('v.saldo','>',0)
			->where('v.devolu','=',0)
			->get();
		
		$clientesjs=json_encode($clients);
		$recibosjs=json_encode($recibos);
		$ventasjs=json_encode($ventascxc);
		 $client = new Client();
		$response = $client->request('POST', 'http://pedidos.nks-sistemas.net/api/recibir-clientes', [
			'form_params' => [
				'empresa' => '200',
				'clientes' => $clientesjs,
				'ventas' => $ventasjs,			
				'recibos' => $recibosjs				
			]
		]);
    }
}
