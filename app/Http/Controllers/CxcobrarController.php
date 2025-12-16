<?php

namespace sisventas\Http\Controllers;

use Illuminate\Http\Request;
use sisventas\Http\Requests;
use sisventas\Pacientes;
use sisventas\Recibo;
use sisventas\Articulo;
use sisventas\Venta;
use sisventas\Ventaf;
use sisventas\Notasadm;
use sisventas\Relacionnc;
use sisventas\Formalibre;
use sisventas\Mov_notas;
use sisventas\RetencionVentas;
use sisventas\DetalleVentaf;
use sisventas\Movbanco;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use sisventas\Http\Requests\PacientesFormRequest;
use DB;
use Carbon\Carbon;
use Auth;
class CxcobrarController extends Controller
{
    public function __construct()
	{
$this->middleware('auth');
	}

	public function index(Request $request)
	{

		if ($request)
		{
			$ide=Auth::user()->idempresa;
			$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
			$rol=DB::table('roles')-> select('crearventa','abonarcxc')->where('iduser','=',$request->user()->id)->first();
			$query=trim($request->get('searchText'));
			$pacientes=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','c.vendedor')
			->select(DB::raw('SUM(v.saldo) as acumulado'),'c.codpais','c.nombre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('c.idempresa','=',$ide)
			->where('c.nombre','LIKE','%'.$query.'%')
			->where('v.tipo_comprobante','<>','PED')
			->where('v.saldo','>',0)
			->groupby('c.id_cliente')
			->paginate(20);
			//dd($pacientes);
			$notas=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'not.tipo','c.id_cliente')
			->where('not.idempresa','=',$ide)
			->where('c.nombre','LIKE','%'.$query.'%')
			->groupby('c.id_cliente','not.tipo')
			->where('not.pendiente','>',0)
			->paginate(20);
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			//->join('venta as v','v.idcliente','=','c.id_cliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'c.codpais','c.telefono','not.tipo','c.id_cliente','c.nombre','c.cedula')
			//->where('v.saldo','=',0)
			->where('not.idempresa','=',$ide)
			->where('not.tipo','=',1)
			->where('not.pendiente','>',0)
			->where('c.nombre','LIKE','%'.$query.'%')			
			->groupby('c.id_cliente')
			->paginate(20);
			//dd($notasnd);
			return view('pacientes.cobrar.index',["rol"=>$rol,"empresa"=>$empresa,"pacientes"=>$pacientes,"notas"=>$notas,"notasnd"=>$notasnd,"searchText"=>$query]);
		}
	}
	 public function detallesxcobrar($historia)
	{
         
           
       //     ->get();
      //  return view('reportes.compras.index',["datos"=>$datos,"searchText"=>$query);
			
	}

	public function show(Request $request, $historia)
	
	{
		$ide=Auth::user()->idempresa;
			$monedas=DB::table('monedas')->where('idempresa','=',$ide)->get();
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();
		$cliente=Pacientes::findOrFail($historia);
			$datos=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->select('v.total_venta','c.id_cliente','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.fecha_hora','v.fecha_emi','v.total_iva as base','v.texe','v.tasa','v.saldo','v.idventa','v.licor','v.forma','mret')
			->where('v.idcliente','=',$historia)
			->where('v.tipo_comprobante','<>','PED')
			->where('v.saldo','>',0)
		   ->get();
		   	$notas=DB::table('notasadm as not')
			->select('not.pendiente','not.descripcion','not.monto','not.fecha','not.idnota','not.referencia')
			->where('not.idcliente','=',$historia)
			->where('not.pendiente','>',0)
			->where('not.tipo','=',1)
			->get();
			$notasc=DB::table('notasadm as not')
			->select(DB::raw('sum(not.pendiente) as montonc'))
			->where('not.idcliente','=',$historia)
			->where('not.pendiente','>',0)
			->where('not.tipo','=',2)
			->first();
		//	dd($notas);
     return view('pacientes.cobrar.show',["datos"=>$datos,"notas"=>$notas,"notasc"=>$notasc,"cliente"=>$cliente,"monedas"=>$monedas,"empresa"=>$empresa]);	
	}
    public function store (Request $request)
    {
		//dd($request);
		$ide=Auth::user()->idempresa;
		$tipodoc=$request->get('tipodoc');
		$user=Auth::user()->name;
		$idcliente=explode("_",$request->get('cliente'));
		//dd($tipodoc);
		if($tipodoc==1){
 // inserta el recibo
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $fpago=$request->get('fpago');
           $tref=$request->get('tref');		 
           $contp=0;
             while($contp < count($idpago)){
				$recibo=new Recibo;
				$recibo->idempresa=$ide;
				$recibo->idventa=$request->get('venta');
				if($request->get('tdeuda')>0){
				$recibo->tiporecibo='A'; }else{$recibo->tiporecibo='A'; }
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$pago[0];
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$recibo->fecha=$fpago[$contp]; 
				$recibo->usuario=$user;				
				$recibo->save();
			$mov=new Movbanco;
			$mov->idcaja=$pago[0];
			$mov->idempresa=$ide;
			$mov->iddocumento=$recibo->idrecibo;
			$mov->tipo_mov="N/C";
			$mov->tipodoc="VENT";
			$mov->numero=$pago[0]."-C".$request->get('venta');
			$mov->concepto="Cobranza Ventas";
			$mov->tipo_per="C";
			$mov->idbeneficiario=$idcliente[0];
			$mov->identificacion=$idcliente[1];
			$mov->nombre=$idcliente[2];
			$mov->monto=$denomina[$contp]; 
			$mov->tasadolar=$tmonto[$contp]; 
			$mytime=Carbon::now('America/Caracas');
			$mov->fecha_mov=$fpago[$contp]; 
			$mov->user=$user;
			$mov->save();
				$contp=$contp+1;
			  } 			   
				$ventact=venta::findOrFail($request->get('venta')); 
				$ventact->saldo=($recibo->aux);
					if(($request->get('tdeuda')==0)and($request->get('convertir')=="on")){
					$ventact->forma=1;
					if($request->get('formato')=="on"){
					$ventact->formato=1;}else{	$ventact->formato=0;}
				}
				$ventact->fecha_fac=$mytime->toDateTimeString();
				$ventact->update();
			if(($request->get('tdeuda')==0)and($request->get('convertir')=="on")){
			//inserto la forma libre
			   $contador=DB::table('ventaf')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
				if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}
			
			$ventaf=new Ventaf;
			$ventaf->idcliente=$idcliente[0];
			$ventaf->idvendedor=$ventact->idvendedor;
			$ventaf->tipo_comprobante="FAC";
			$ventaf->serie_comprobante="NE00";
			$ventaf->num_comprobante=($numero+1);
			$ventaf->pedido=$ventact->idventa;	
			$ventaf->forma=1;
			if($request->get('formato')=="on"){
			$ventaf->formato=1;}else{	$ventaf->formato=0;}	
			$ventaf->tasa=$ventact->tasa;
			$ventaf->mcosto=$ventact->mcosto;
			$ventaf->mivaf=$ventact->mivaf;
			$ventaf->texe=$ventact->texe;
			$ventaf->total_venta=$ventact->total_venta;
			$ventaf->total_iva=$ventact->total_iva;
			$ventaf->descuento=0;
			$ventaf->licor=0;
			$ventaf->total_pagar=0;
			$ventaf->mret=$ventact->mret;
			$ventaf->fecha_hora=$ventact->fecha_hora;
			$ventaf->fecha_emi=$ventact->fecha_emi;
			$ventaf->fecha_fac=$mytime->toDateTimeString();
			$ventaf->impuesto='16';
			$ventaf->saldo=0;
			$ventaf->diascre=0;
			$ventaf->estado='Contado';
			$ventaf->devolu='0';
			$ventaf->comision=0;
			$ventaf->idcomision=0;
			$ventaf->pweb=0;
			$ventaf->user=$user;
			$ventaf-> save();
			//
			$pnro=DB::table('formalibre')
			->select(DB::raw('MAX(idforma) as pnum'))
			->first();				
			$fl=new Formalibre;
			$fl->idventa=$ventaf->idventa;
			$fl->nrocontrol=($pnro->pnum+7101);
			$fl->save();
				$detalles=DB::table('detalle_venta as da')
				-> select('da.idarticulo as cod','da.cantidad as cant','da.costoarticulo as costo','da.precio_venta as precio')
				-> where ('da.idventa','=',$request->get('venta'))
				->get();
			
				$longitud = count($detalles);		
			//dd();
					for ($i=0;$i<$longitud;$i++){
						$detalle=new DetalleVentaf();
						$detalle->idventa=$ventaf->idventa;
						$detalle->idarticulo=$detalles[$i]->cod;
						$detalle->cantidad=$detalles[$i]->cant;
						$detalle->costoarticulo=$detalles[$i]->costo;
						$detalle->descuento=1;
						$detalle->fecha==$mytime->toDateTimeString();
						$detalle->fecha_emi=$ventact->fecha_emi;
						$detalle->precio_venta=$detalles[$i]->precio;
						$detalle->save();			
								
				}
		}
		}
				if($tipodoc==2){
			// inserta el recibo
			//dd($request->get('venta'));
          $idpago=$request->get('tidpago');
           $idbanco=$request->get('tidbanco');
		   $denomina=$request->get('denominacion');
           $tmonto=$request->get('tmonto');
           $tref=$request->get('tref');		 
           $contp=0;
             while($contp < count($idpago)){
				$recibo=new Recibo;
				$recibo->idempresa=$ide;
				$recibo->idventa=0;
				$recibo->idnota=$request->get('venta');
				if($request->get('tdeuda')>0){
				$recibo->tiporecibo='A'; }else{$recibo->tiporecibo='A'; }
				$recibo->monto=$request->get('total_venta');
				$pago=explode("-",$idbanco[$contp]);
				$recibo->idpago=$pago[0];
				$recibo->idbanco=$idbanco[$contp];
				$recibo->recibido=$denomina[$contp];			
				$recibo->monto=$tmonto[$contp]; 
				$recibo->referencia=$tref[$contp];
				$recibo->tasap=$request->get('peso');
				$recibo->tasab=$request->get('tc');
				$recibo->aux=$request->get('tdeuda');
				$mytime=Carbon::now('America/Caracas');
				$recibo->fecha=$mytime->toDateTimeString();	
				$recibo->usuario=$user;					
				$recibo->save();
				
		$mov=new Movbanco;
        $mov->idcaja=$pago[0];
        $mov->idempresa=$ide;
		$mov->iddocumento=$recibo->idrecibo;
        $mov->tipo_mov="N/C";
		$mov->tipodoc="N/DA";
        $mov->numero=$pago[0]."-C".$request->get('venta');
        $mov->concepto="Cobranza N/D";
		$mov->tipo_per="C";
        $mov->idbeneficiario=$idcliente[0];
		$mov->identificacion=$idcliente[1];
        $mov->nombre=$idcliente[2];
        $mov->monto=$denomina[$contp]; 
		$mov->tasadolar=0;
        $mytime=Carbon::now('America/Caracas');
        $mov->fecha_mov=$mytime->toDateTimeString();
        $mov->user=$user;
        $mov->save();
		
		$contp=$contp+1;
			  } 
				$ventaup=notasadm::findOrFail($request->get('venta'));
				$ventaup->pendiente=$request->get('tdeuda');
				$ventaup->update();
		}
			if(($request->get('tdeuda')==0)and($request->get('convertir')=="on")){  
	return Redirect::to('ventas/formalibre/'.$request->get('venta').'_'.$ventact->formato); 
 
		}else {  
return Redirect::to('pacientes/cobrar/'.$idcliente[0]);   }
    }
	
	public function edit($id){
	
		$data=explode("-",$id);
		$empresa=DB::table('empresa')-> where('idempresa','=','1')->first();
		$venta=DB::table('venta as v')
            -> join ('clientes as p','v.idcliente','=','p.id_cliente')
            ->where ('v.idventa','=',$data[0])
            -> first();
            $detalles=DB::table('detalle_venta as dv')
            -> join('articulo as a','dv.idarticulo','=','a.idarticulo')
            -> select('a.nombre as articulo','dv.cantidad','dv.idarticulo','dv.descuento','dv.precio_venta')
            -> where ('dv.idventa','=',$data[0])
            ->get();
            $articulos=DB::table('articulo')-> where('estado','=','Activo')->get();
			$abonos=DB::table('recibos')-> where('idventa','=',$data[0])->get();
			$recibonc=DB::table('mov_notas as mov')-> where ('mov.iddoc','=',$data[0])-> where ('mov.tipodoc','=',"FAC")
            ->get();
          //  dd($articulos);
  return view("pacientes.cobrar.edit",["link"=>$data[1],"recibonc"=>$recibonc,"venta"=>$venta,"empresa"=>$empresa,"detalles"=>$detalles,"articulos"=>$articulos,"abonos"=>$abonos]);

	}
	public function update(PacientesFormRequest $request, $historia)
	{
      $paciente=Pacientes::findOrFail($historia);
        $paciente->nombre=$request->get('nombre');
        $paciente->cedula=$request->get('cedula');
        $paciente->telefono=$request->get('telefono');
    	$paciente->direccion=$request->get('direccion');
    	$paciente->tipo_cliente=$request->get('tipo_cliente');
        $paciente->tipo_precio=$request->get('precio');
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
	public function destroy()
	{
        $paciente=Pacientes::findOrFail($id_cliente);
        $paciente->status='I';
        $paciente->update();
        return Redirect::to('pacientes/paciente');
	}
	public function cuentascobrar(Request $request)	
	{	
	$ide=Auth::user()->idempresa;
	$rol=DB::table('roles')-> select('rcxc')->where('iduser','=',$request->user()->id)->first();
		$empresa=DB::table('empresa')-> where('idempresa','=',$ide)->first();		
		$vendedores=DB::table('vendedores')-> where('idempresa','=',$ide)->get();  
			if($request->get('vendedor')==NULL){
				$aux=0;
			$pacientes=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			-> join ('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
			->select('v.saldo as acumulado','v.idventa as tipo_comprobante','serie_comprobante','num_comprobante','v.fecha_emi as fecha_hora','v.user','c.nombre','c.diascre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('v.idempresa','=',$ide)
			->where('v.saldo','>',0)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->orderby('c.nombre','ASC');

			$q2=DB::table('notasadm as n')
			->join('clientes as c','c.id_cliente','=','n.idcliente')
			->select('n.pendiente as acumulado',DB::raw('CONCAT("N/D","-",n.tipo ) as serie_comprobante'),'idnota as num_comprobante','n.referencia as num_comprobante','n.fecha as fecha_hora','n.usuario as user','c.nombre','n.usuario as vendedor','c.diascre','c.cedula','c.telefono','c.id_cliente')
			->where('n.idempresa','=',$ide)
			->where('n.tipo','=',1)->where('n.pendiente','>',0);
			$clientes= $pacientes->union($q2)->get(); 
			//dd($clientes);
			$cuenta=DB::table('vendedores as v')->where('v.idempresa','=',$ide)->get();
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'c.id_cliente','c.nombre','not.idnota','c.cedula','not.fecha')
			->where('not.tipo','=',1)
			->where('not.idempresa','=',$ide)
			->where('not.pendiente','=',0)			
			->groupby('c.id_cliente')
			->get();
			$idv=0;
			}else{
			$idv=$request->get('vendedor');
			$aux=0;
				$clientes=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
			->select('v.saldo as acumulado','v.idventa as tipo_comprobante','serie_comprobante','v.num_comprobante','v.fecha_emi as fecha_hora','v.user','c.nombre','c.diascre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('v.idvendedor','=',$request->get('vendedor'))
			->where('v.idempresa','=',$ide)
			->where('v.saldo','>',0)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->orderby('c.nombre','ASC')	
			->get();
			//dd($clientes);
			$cuenta=DB::table('vendedores as v')->where('v.idempresa','=',$ide)->get();
			$notasnd=DB::table('notasadm as v')->where('v.idempresa','=',$ide)->get();
			
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'c.id_cliente','c.nombre','not.idnota','c.cedula','not.fecha')
			->where('not.tipo','=',1)
			->where('not.idempresa','=',$ide)
			->where('not.pendiente','>',0)	
			->where('c.vendedor','=',$request->get('vendedor'))			
			->groupby('c.id_cliente')
			->get();
			
			if($request->get('resumen')=="on"){
			$aux=1;
			$cuenta=DB::table('venta as v')
			->join('clientes as c','c.id_cliente','=','v.idcliente')
			->join('vendedores as ve','ve.id_vendedor','=','v.idvendedor')
			->select(DB::raw('sum(v.saldo) as acumulado'),'c.nombre','ve.nombre as vendedor','c.cedula','c.telefono','c.id_cliente')
			->where('v.idvendedor','=',$request->get('vendedor'))
			->where('v.saldo','>',0)
			->where('v.idempresa','=',$ide)
			->where('v.tipo_comprobante','=','FAC')
			->where('v.devolu','=',0)
			->groupby('v.idcliente')
			->orderby('c.nombre','ASC')	
			->get();
			$notasnd=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnotas'),'c.id_cliente')
			->where('not.tipo','=',1)
			->where('not.idempresa','=',$ide)
			->where('not.pendiente','>',0)		
			->where('c.vendedor','=',$request->get('vendedor'))				
			->groupby('c.id_cliente')
			->get();
			}
			}
			$nc=DB::table('notasadm as not')
			->join('clientes as c','c.id_cliente','=','not.idcliente')
			->select(DB::raw('SUM(not.pendiente) as tnc'),'c.id_cliente')
			->where('not.idempresa','=',$ide)
			->where('not.tipo','=',2)
			->where('not.pendiente','>',0)					
			->groupby('c.id_cliente')
			->get();
			
		if($rol->rcxc){
			return view('reportes.cobrar.index',["nc"=>$nc,"vende"=>$idv,"cuenta"=>$cuenta,"notasnd"=>$notasnd,"auxiliar"=>$aux,"pacientes"=>$clientes,"vendedores"=>$vendedores,"empresa"=>$empresa]);
		      		 }else{
			return view('reportes.mensajes.noautorizado');	
		 } 
		}
	public function aplicanc(Request $request)
	{
		//dd($request);

		if($request->get('tipo')=="N/D"){
			 $notas=Notasadm::findOrFail($request->get('iddoc'));
			 $notas->pendiente=($notas->pendiente-$request->get('total_abn'));
			 $notas->update();
			 	$mov=new Mov_notas;
				$mov->tipodoc="N/D";
				$mov->iddoc=$request->get('iddoc');
				$mov->monto=$request->get('total_abn');
				$mov->referencia=$request->get('ref');
				$mytime=Carbon::now('America/Caracas');
				$mov->fecha=$mytime->toDateTimeString();
				$mov->user=Auth::user()->name;
				$mov->save();
				$nc=DB::table('notasadm as da')
				-> select('da.idnota as not','da.pendiente')
				-> where ('da.tipo','=',2)
				-> where ('da.idcliente','=',$request->get('idcliente'))
				-> where ('da.pendiente','>',0)
				->get();	
			$longitud = count($nc);
			$array = array();
			foreach($nc as $t){
			$arrayidnota[] = $t->not;
			}
			$abono=$request->get('total_abn');
				for ($i=0;$i<$longitud;$i++){
						if($abono>0){
					$bajanota=Notasadm::findOrFail($arrayidnota[$i]);
					$montonc=$bajanota->pendiente;
						if($montonc>$abono){
						$bajanota->pendiente=($bajanota->pendiente-$abono);$abono=0;}else{
						$bajanota->pendiente=0; $abono=($abono-$montonc);
						}
					$bajanota->update();
					$rnc=new Relacionnc;
				$rnc->idmov=$mov->id_mov;
				$rnc->idnota=$arrayidnota[$i];
				$rnc->save();	
				}	
				}	
				}
			if($request->get('tipo')=="FAC"){
					//	
			 $notas=Venta::findOrFail($request->get('iddoc'));
			 $notas->saldo=($notas->saldo-$request->get('total_abn'));	
				if($request->get('convertirnc')=="on"){
				$notas->forma=1;}			 
				if($request->get('formatonc')=="on"){
				$notas->formato=1;}else{$notas->formato=0;}
				$mytime=Carbon::now('America/Caracas');
				$notas->fecha_fac=$mytime->toDateTimeString();	
			$notas->update();
			 //recibo
			 if($notas->saldo==0){ 	
				$recibo=new Recibo;
				$recibo->idventa=$request->get('iddoc');			
				$recibo->idnota=0; 
				$recibo->tiporecibo='P'; 
				$recibo->monto=0;
				$recibo->idpago=1;
				$recibo->idnota=0;
				$recibo->idbanco="1-Dolares";
				$recibo->recibido=0;			
				$recibo->monto=0; 
				$recibo->referencia= "N/C Aplicada $".$request->get('total_abn');
				$recibo->tasap=0;
				$recibo->tasab=0;
				$recibo->aux=$notas->saldo;
				$mytime=Carbon::now('America/Caracas');
				$recibo->fecha=$mytime->toDateTimeString();		
				$recibo->usuario=Auth::user()->name;				
				$recibo->save();
				//dd($recibo);
			 }
			// dd($notas);
			 	$mov=new Mov_notas;
				$mov->tipodoc="FAC";
				$mov->iddoc=$request->get('iddoc');
				$mov->monto=$request->get('total_abn');
				$mov->referencia=$request->get('ref');
				$mytime=Carbon::now('America/Caracas');
				$mov->fecha=$mytime->toDateTimeString();
				$mov->user=Auth::user()->name;
				$mov->save();	
				$nc=DB::table('notasadm as da')
				-> select('da.idnota as not','da.pendiente')
				-> where ('da.tipo','=',2)
				-> where ('da.idcliente','=',$request->get('idcliente'))
				-> where ('da.pendiente','>',0)
				->get();	
			$longitud = count($nc);
			$array = array();
			foreach($nc as $t){
			$arrayidnota[] = $t->not;
			}
			$abono=$request->get('total_abn');
				for ($i=0;$i<$longitud;$i++){
						if($abono>0){
					$bajanota=Notasadm::findOrFail($arrayidnota[$i]);
					$montonc=$bajanota->pendiente;
						if($montonc>$abono){
						$bajanota->pendiente=round(($bajanota->pendiente-$abono),2);$abono=0;}else{
						$bajanota->pendiente=0; $abono=($abono-$montonc);
						}
					$bajanota->update();
				$rnc=new Relacionnc;
				$rnc->idmov=$mov->id_mov;
				$rnc->idnota=$arrayidnota[$i];
				$rnc->save();	
				}	
				}	
				}
				 return Redirect::to('pacientes/cobrar/'.$request->get('idcliente'));
	}
		 public function pago(Request $request)
    {	
		$moneda=explode("_",$request->get('pidpagomodal'));
		$fac=$request->get('factura');
		$saldo=$request->get('saldo'); 
		$cont = 0;
        while($cont < count($fac)){
			$venta=Venta::findOrFail($fac[$cont]);
			$venta->saldo=0;	
			$venta->update();
				
				$recibo=new Recibo;
				$recibo->idventa=$fac[$cont];
				$recibo->tiporecibo="A";
				$recibo->idnota=0;
				$recibo->monto=$saldo[$cont];
				$recibo->idpago=$moneda[0];
				$recibo->idbanco=$moneda[1];
				$recibo->recibido=$saldo[$cont];			 
				$recibo->referencia="";
				$recibo->tasap="";
				$recibo->tasab="";
				$recibo->aux=0;
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->save();
			$cont=$cont+1;
            } 
   return Redirect::to('pacientes/cobrar');
 }
 		 public function pagond(Request $request)
    {	
		$moneda=explode("_",$request->get('pidpagomodaln'));
		$fac=$request->get('nota');
		$saldo=$request->get('pendiente'); 
		$cont = 0;
        while($cont < count($fac)){
			$venta=Notasadm::findOrFail($fac[$cont]);
			$venta->pendiente=0;	
			$venta->update();
				
				$recibo=new Recibo;
				$recibo->idventa=0;
				$recibo->tiporecibo="A";
				$recibo->idnota=$fac[$cont];
				$recibo->monto=$saldo[$cont];
				$recibo->idpago=$moneda[0];
				$recibo->idbanco=$moneda[1];
				$recibo->recibido=$saldo[$cont];;			 
				$recibo->referencia="";
				$recibo->tasap="";
				$recibo->tasab="";
				$recibo->aux=0;
				$mytime=Carbon::now('America/Caracas');			
				$recibo->fecha=$mytime->toDateTimeString();
				$recibo->save();
			$cont=$cont+1;
            } 
   return Redirect::to('pacientes/cobrar');
 }
  	public function pasarfl(Request $request)
	{
	//	dd($request);
	$user=Auth::user()->name;
		$ventact=Venta::findOrFail($request->get('idventafl'));
		$ventact->forma=1;			 
		$mytime=Carbon::now('America/Caracas');
		$ventact->fecha_fac=$mytime->toDateTimeString();	
		$ventact->update();
	$contador=DB::table('ventaf')->select('idventa')->limit('1')->orderby('idventa','desc')->first();
				if ($contador==NULL){$numero=0;}else{$numero=$contador->idventa;}
			
			$ventaf=new Ventaf;
			$ventaf->idcliente=$ventact->idcliente;
			$ventaf->idvendedor=$ventact->idvendedor;
			$ventaf->tipo_comprobante="FAC";
			$ventaf->serie_comprobante="NE00";
			$ventaf->num_comprobante=($numero+1);
			$ventaf->pedido=$ventact->idventa;	
			$ventaf->forma=1;
			$ventaf->formato=0;
			$ventaf->tasa=$ventact->tasa;
			$ventaf->mcosto=$ventact->mcosto;
			$ventaf->mivaf=$ventact->mivaf;
			$ventaf->texe=$ventact->texe;
			$ventaf->total_venta=$ventact->total_venta;
			$ventaf->total_iva=$ventact->total_iva;
			$ventaf->descuento=0;
			$ventaf->licor=0;
			$ventaf->total_pagar=0;
			$ventaf->mret=$ventact->mret;
			$ventaf->fecha_hora=$ventact->fecha_hora;
			$ventaf->fecha_emi=$ventact->fecha_emi;
			$ventaf->fecha_fac=$mytime->toDateTimeString();
			$ventaf->impuesto='16';
			$ventaf->saldo=0;
			$ventaf->diascre=0;
			$ventaf->estado='Contado';
			$ventaf->devolu='0';
			$ventaf->comision=0;
			$ventaf->idcomision=0;
			$ventaf->pweb=0;
			$ventaf->user=$user;
			$ventaf-> save();
			//
			$pnro=DB::table('formalibre')
			->select(DB::raw('MAX(idforma) as pnum'))
			->first();				
			$fl=new Formalibre;
			$fl->idventa=$ventaf->idventa;
			$fl->nrocontrol=($pnro->pnum+7001);
			$fl->save();
				$detalles=DB::table('detalle_venta as da')
				-> select('da.idarticulo as cod','da.cantidad as cant','da.costoarticulo as costo','da.precio_venta as precio')
				-> where ('da.idventa','=',$request->get('idventafl'))
				->get();
			
				$longitud = count($detalles);		
			//dd();
					for ($i=0;$i<$longitud;$i++){
						$detalle=new DetalleVentaf();
						$detalle->idventa=$ventaf->idventa;
						$detalle->idarticulo=$detalles[$i]->cod;
						$detalle->cantidad=$detalles[$i]->cant;
						$detalle->costoarticulo=$detalles[$i]->costo;
						$detalle->descuento=1;
						$detalle->fecha==$mytime->toDateTimeString();
						$detalle->fecha_emi=$ventact->fecha_emi;
						$detalle->precio_venta=$detalles[$i]->precio;
						$detalle->save();			
								
				}
        return Redirect::to('pacientes/cobrar/'.$ventact->idcliente);
	}
 	 	public function retencion(Request $request)
	{
		$query=trim($request->get('fecharet'));	
            $query = date_create($query); 
		$periodo=date_format($query, 'Y');
		$mes=date_format($query, 'm');
		//dd($request);
		$user=Auth::user()->name;
			$fl=new RetencionVentas;
			$fl->idfactura=$request->get('factura');
			$fl->idcliente=$request->get('idp');
			$fl->comprobante=$request->get('comprobanteret');
			$fl->pretencion=$request->get('idretenc');
			$fl->mretbs=$request->get('mret');
			$fl->mfactura=$request->get('mfac');
			$fl->impuesto=$request->get('miva');
			$fl->mretd=$request->get('mretd');
			$fl->tasa=$request->get('tasafac');
			$mytime=Carbon::now('America/Caracas');			
			$fl->fecharegistro=$mytime->toDateTimeString();
			$fl->fecha=$request->get('fecharet');
			$fl->periodo=$periodo;
			$fl->mes=$mes;
			$fl->usuario=$user;
			$fl->save();
			//actualizo saldo de venta
			$notas=Venta::findOrFail($request->get('factura'));
			$notas->saldo=($notas->saldo-$request->get('mretd'));		
			$notas->mret=($notas->mret+$request->get('mretd'));		
			$notas->update();
        return Redirect::to('pacientes/cobrar/'.$request->get('idp'));
	}
}
