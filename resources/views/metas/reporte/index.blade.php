@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('metas.reporte.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0; $acumv=$vendi=0; $cnt=0; $acummenta=$acummeta=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Ventas SysVent@s</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
              </div>
            </div>
</div>
                  

<div class="row">
<div class="panel-body">
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	    </div>
					<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
     <h3 align="center">SEGUIMIENTO DE META </h3> 
     <h5 align="center">{{$meta->inicio}} al {{$meta->fin}}</h5> 
	    </div>
				<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
		<div align="center">   <img src="{{asset('dist/img/logoempresa.jpg')}}" width="40%" height="80%" title="NKS"></div>
		</div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?>  </span>
  </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
    </div>
	
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div>
                   
</div><!-- /.box-body -->
</div><!-- /.box -->
             

@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="../reportes/corte";
    });

});

</script>

@endpush
@endsection