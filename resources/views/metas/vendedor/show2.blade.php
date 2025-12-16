@extends ('layouts.admin')
@section ('contenido')
<?php 
$acum=0;
$acumv=0;
$vendi=0;$met=0;$cnt=0;$cnt2=0;$aprobado=0;$itmes=0;
$ceros=5;$acummeta=0; $por=0;$var=0;$cumplimiento=0; $pmeta=0;
function add_ceros($numero,$ceros) {
  $numero=$numero+
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $recibo.$numero;
};
?><div class="row">
			<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
				<h3 align="center"> META # <?php echo add_ceros($meta-> idmeta,$ceros); ?></h3>
				<span><b>{{$vendedor->cedula}}->{{$vendedor->nombre}}</b></span>
			</div>   
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                    	<label for="concepto">Descripcion: </label> {{$meta->descripcion}}
						<label for="monto">Monto: </label> <?php echo number_format( $meta->valormeta, 2,',','.'); ?><b> Fecha: </b> <?php echo date("d-m-Y",strtotime($meta->creado)); ?>
                    </div>
                </div>
			 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                    	<label for="concepto">Inicio: </label> <?php echo date("d-m-Y",strtotime($meta->inicio)); ?> <b>Fin: </b> <?php echo date("d-m-Y",strtotime($meta->fin)); ?>
                    </div>
                </div>
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
		  <table width="90%" align="center">
		  <tr>
		  <td><b>Nuevos Clientes / %</b></td>
		  <td><b>Cobranza (Dias) / %</b></td>
		  <td><b>Reactivacion (Dias) / %</b></td>
		  <td><b>Activacion</b></td>
		  <td><b>Crecimiento / %</b></td>
		  <td><b>Metas Articulos / %</b></td>
		  </tr>
		   <tr>
		  <td>{{$meta->nclientes}} / {{$meta->pnclientes}}</td>
		  <td>{{$meta->cobranza}} / {{$meta->pcobranza}}</td>
		  <td>{{$meta->reactivar}} / {{$meta->preactivar}}</td>
		  <td>{{$meta->preactivar}}</td>
		  <td>{{$meta->crecimiento}} / {{$meta->pcrecimiento}}</td>
		  <td>{{$meta->cntarticulos}} / {{$meta->particulos}}</td>
		  </tr>
		  
		  </table>
	
		  </div>
            </div>
		 <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 align="center">Unidades Establecidas en Meta</h4>
					<div class="table-responsive">
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
						<th>Id</th>
                          <th>Descripcion</th>
						  <th>Unds Meta</th>                       
						  <th>unds Venta</th>                       
						  <th>% meta</th>                       
						  <th>Valor</th>                       
                      </thead>
              
                      <tbody>
                     @foreach($articulos as $re) <?php  $acum=$acum+$re->cantidad;
					 $acumv=$acumv+$re->valor; $cnt++;
					 ?> <?php $aux=0; ?>
                        <tr >
                          <td><?php if($meta->estatus==0){?><a href="" data-target="#modal-ajuste-{{$re->idbloque}}" data-toggle="modal">{{$re->idbloque}}</a><?php }else { echo $re->idarticulo; } ?> </td>
						      <td>{{$re->descripcion}}</td> 
						   <td><?php echo number_format( $re->cantidad, 2,',','.'); ?></td>                   
						   <td>  @foreach($datos as $da)
						  
							<?php IF($re->idbloque==$da->idbloque){
								$aux=1;
								$vendi=$vendi+$da->vendido;
							echo number_format( $da->vendido, 2,',','.'); 
							if($re->cantidad <= $da->vendido){ $met=100; echo " <i class='fa fa-fw fa-thumbs-o-up'></i>";}
							else{ $met=($da->vendido*100)/$re->cantidad;  echo "<i class='fa fa-fw fa-thumbs-down'></i>-".($re->cantidad-$da->vendido);}
							}?>						
									@endforeach
		<?php if(($aux==0)and($re->cantidad>0)){
		$met=0;
		echo "<i class='fa fa-fw fa-thumbs-down'></i>-".$met; }?>
						   </td>  
							<td><?php $acummeta= $acummeta+$met; echo number_format( $met, 2,',','.')." %"; ?></td>						   
						   <td><?php echo number_format( $re->valor, 2,',','.'); ?></td>                   
                        </tr>
					@include('metas.vendedor.modalajustebloque')
                        @endforeach
                        <tfoot>                    
                          <th colspan="2">Total</th>
						  <th><?php echo number_format( $acum, 2,',','.');?> Unds</th>
						  <th><?php echo number_format( $vendi, 2,',','.');?> Unds</th>
						  <th><?php $por=($acummeta/$cnt); echo number_format( ($acummeta/$cnt), 2,',','.');?> %</th>
						  <th><?php echo number_format( $acumv, 2,',','.');?> $</th>
     
                          </tfoot>
                       
                      </tbody>
                  </table>
				  </div>
                    </div>
					<?php if($meta->crecimiento==1){$items=5;}else{$items=4;} $var =$meta->idmeta."-".$por;?>
                </div></div></div>            
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
	<table width="90%" align="center">
			  <tr>
		  <td><b>Nuevos Clientes</b></td>
		  <td><b>Cobranza</b></td>
		  <td><b>Reactivacion</b></td>
		  <td><b>Activacion</b></td>
		  <td><b>Metas Articulos</b></td> 
		  <td><b>Crecimiento</b></td>
		 
		  </tr>
		  <tr>
		  <td><?php if($nclientes->nuevos >= $meta->nclientes){$pmeta=$pmeta+$meta->pnclientes; $aprobado=$aprobado+1;} ?> {{$nclientes->nuevos}} </td>
		  <td><?php if($cobranza->cobros >= $meta->cobranza){$pmeta=$pmeta+$meta->pcobranza; $aprobado=$aprobado+1;} ?> Recibos: {{$cobranza->cobros}} Monto:<?php echo number_format( $cobranza->monto,'2','.',','); ?> $</td>
		  <td>@foreach($reactivar as $re)
		  <?Php if($re->meses>0){$cnt2++;} ?>
		  @endforeach <?php echo $cnt2;?> Cliente.</td>
		   <td><?php echo $activar->clientesventas ."/". $clientesv->clientes; if($activar->clientesventas==$clientesv->clientes){$pmeta=$pmeta+$meta->activar; $aprobado=$aprobado+1;}?></td>
		  <?php if($cnt2 >= $meta->reactivar){$pmeta=$pmeta+$meta->preactivar; $aprobado=$aprobado+1;} ?>
		  <td><?php if($vendi >= $meta->cntarticulos){$pmeta=$pmeta+$meta->particulos; $aprobado=$aprobado+1;} ?><?php echo number_format( $vendi, 2,',','.');?></td>
		  <td><b><?php if($meta->crecimiento==1){$pmeta=$pmeta+$meta->pcrecimiento;
		  if($pmeta>=$creci->cumplimiento) {echo "+ Ant ".$creci->cumplimiento."%"; }else{$pmeta=$pmeta-$meta->pcrecimiento;} } ?></b></td>
		  
		  </tr>
		  </table>
                </div><?php $cumplimiento=$aprobado/$items;
				 echo "<b>Meta ".$pmeta."% cumplida. </b>";
				if($comimeta<>NULL){
						if ($comimeta->idmeta<> 0) { echo "<b>Relacionanda con Comision </b>".$comimeta->id_comision;}
				}?>
            </div> 
								<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
<?php if($meta->estatus==0){?>
				<a href="href="" data-target="#cerrarm-{{$meta->idmeta}}" data-toggle="modal"><button class="btn btn-primary">Cerrar</button></a>	<?php } ?>			
					<button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
                </div>  
     
@include('metas.vendedor.cerrarm')       	

		
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/metas/vendedor";
    });
$('#regresar').on("click",function(){
  window.location="/metas/vendedor";
  
});
});
</script>
@endpush
@endsection