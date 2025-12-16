@extends ('layouts.admin')
@section ('contenido')
<?php 
$acum=0;
$acumv=0;
$vendi=0;$met=0;$cnt=0;
$ceros=5;$acummeta=0; $por=0;$var=0;$valor=0;
function add_ceros($numero,$ceros) {
  $numero=$numero+1;
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
          
            </div>
		 <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><h4 align="center">Unidades Establecidas en Meta</h4>
					<div class="table-responsive">
                  <table id="desglose" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
						<th>Codigo</th>
                          <th>Articulo</th>
						  <th>Unds Meta</th>                       
						  <th>unds Venta</th>                       
						  <th>% meta</th>                       
						  <th>Valor</th>                       
                      </thead>
              
                      <tbody>
                     @foreach($articulos as $re) <?php  $acum=$acum+$re->cantidad;
			 $cnt++;  $met=0; 
					 ?>
                        <tr >
                          <td>{{$re->codigo}}</td>
						      <td>{{$re->nombre}}</td> 
						   <td><?php echo number_format( $re->cantidad, 2,',','.'); ?></td>                   
						   <td>  @foreach($datos as $da)
						   
							<?php IF($re->idarticulo==$da->idarticulo){
								$vendi=$vendi+$da->vendido;
							echo number_format( $da->vendido, 2,',','.'); 
							if($re->cantidad <= $da->vendido){ $met=100; echo " <i class='fa fa-fw fa-thumbs-o-up'></i>";}

							else{  $met=($da->vendido*100)/$re->cantidad;  echo "<i class='fa fa-fw fa-thumbs-down'></i>-".($re->cantidad-$da->vendido);}
							$valor=$da->vendido*$da->vpromedio;
							} 
							?>
									@endforeach
							<?php		if($met==0){ $valor=0; echo "0 <i class='fa fa-fw fa-thumbs-down'></i>"; } ?>
						   </td>  
							<td><?php $acummeta= $acummeta+$met; echo number_format( $met, 2,',','.')." %"; ?></td>						   
						   <td><?php 		 $acumv=$acumv+$valor; echo number_format( $valor, 2,',','.'); ?></td>                   
                        </tr>
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
					<?php $var =$meta->idmeta."-".$por;?>
                </div></div></div>            
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">

                </div>
            </div> 
								<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
<?php if($meta->estatus==0){?>
<a href="{{URL::action('MetasController@edit',$var)}}"><button class="btn btn-primary">Cerrar</button></a>	<?php } ?>				
					<button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
                    </div>
                </div>  
            	

		
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  document.getElementById('regresar').style.display="none";
  window.print(); 
  window.location="/metas/metas";
    });
$('#regresar').on("click",function(){
  window.location="/metas/metas";
  
});
});
</script>
@endpush
@endsection