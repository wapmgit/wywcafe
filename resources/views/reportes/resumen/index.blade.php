@extends ('layouts.admin')
@section ('contenido')
<div class="row">

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>					
            	 </div>  
	    </div> 
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6"> 
  <h3 align="center">RESUMEN GERENCIAL</h3>
  </div>
</div>

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="table-responsive">      
      <table width="100%">
	    <thead style="background-color: #E6E6E6"><th colspan="5" > <div align="center">Cuentas por Pagar</div></th></thead>
        <thead style="background-color: #E6E6E6">
					<th>Proveedor</th>
					<th>Telefono</th>

					<th>Monto</th>
					<th>Por Pagar</th>
				</thead><?php $count=0;$montoacum=0; $acumcompra=0; $cli=array();?>
               @foreach ($compras as $q)
				<tr> <?php $count++; 
					$montoacum=$montoacum+$q->vsaldo; $acumcompra=$acumcompra+$q->vtotal;?> 
					<td><small>{{ $q->nombre}}</small></td>
					<td><small>{{ $q->telefono}}</small></td>
					<td><?php   echo number_format($q->vtotal, 2,',','.'); ?></td>
					<td><?php   echo number_format($q->vsaldo, 2,',','.'); ?></td>	
				</tr>
				@endforeach
				@foreach ($gastos as $q)
				<tr> <?php  
					$montoacum=$montoacum+$q->vsaldo; $acumcompra=$acumcompra+$q->vtotal;?> 
					<td><small>{{ $q->nombre}}</small></td>
					<td><small>{{ $q->telefono}}</small></td>
					<td><?php   echo number_format($q->vtotal, 2,',','.'); ?></td>
					<td><?php   echo number_format($q->vsaldo, 2,',','.'); ?></td>	
				</tr>
				@endforeach
				<tr style="background-color: #E6E6E6"><td colspan="2"><strong>Total</strong></td><td><strong><?php   echo "$ ".number_format($acumcompra, 2,',','.'); ?></strong></td><td><strong><?php   echo "$ ".number_format($montoacum, 2,',','.'); ?></strong></td></tr>
			</table>
		</div>
  
  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <div class="table-responsive">      
      <table width="100%">
	  	    <thead style="background-color: #E6E6E6"><th colspan="5" > <div align="center">Cuentas por Cobrar</div></th></thead>
        <thead style="background-color: #E6E6E6">
					<th>Cliente</th>
					<th>Telefono</th>
					<th>Monto</th>
					<th>Por Cobrar</th>
				</thead><?php $count=0;$cnt=0;$mn=0; $mpc=0; $montoventa=0; $montosaldo=0;?>
               @foreach ($ventas as $q)
				<tr> <?php $count++;   $mn=$q->vtotal; $mpc=$q->vsaldo;
        $montosaldo=$montosaldo+$q->vsaldo; $montoventa=$montoventa+$q->vtotal; ?> 
					<td><small>{{ $q->nombre}}</small></td>
					<td><small>{{ $q->telefono}}</small></td>
					@foreach ($notas as $not) <?php if ($not->id_cliente==$q->id_cliente){ $cnt++;
						$cli[]=$not->id_cliente;
       $montosaldo=$montosaldo+$not->saldo; $montoventa=$montoventa+$not->monto;	$mn=$mn+$not->monto;
	   $mpc=$mpc+$not->saldo;
								} ?>@endforeach
					<td><small><?php echo number_format($mn, 2,',','.')." $"; ?></small></td>
					<td><small><?php echo number_format($mpc, 2,',','.')." $"; ?></small></td>	
				</tr>
				@endforeach
				<?php 
  $long=count($cli);
  for($k=0;$k<$long;$k++){
   $arraynidcliente[]=$cli[$k];} 
   $longitud = count($notas);
			$array = array();
			foreach($notas as $t){
			$arrayidcliente[] = $t->id_cliente;
			}			
			for ($i=0;$i<$longitud;$i++){
				for($j=0;$j<$long;$j++){
				if ($arrayidcliente[$i]==$arraynidcliente[$j]){
					 $arrayidcliente[$i]=0;
				};
				}
			}	
			?>
				 @foreach ($notas as $not)
				 <?php for ($i=0;$i<$longitud;$i++){
						if ($not->id_cliente==$arrayidcliente[$i]){?>
				<tr>
				<td>{{$not->nombre}}</td>
				<td></td>
				<td>{{$not->monto}}</td>
				<td>{{$not->saldo}}</td>
				</tr>
				 <?php 
				  $montoventa=$montoventa+$not->monto;
				  $montosaldo=$montosaldo+$not->saldo;
				 
				 
				 } }?>
				@endforeach
				<tr style="background-color: #E6E6E6"><td colspan="2"><strong>Total</strong></td>
				<td><strong><?php   echo "$ ".number_format($montoventa, 2,',','.'); ?></strong></td>
<td><strong><?php   echo "$ ".number_format($montosaldo, 2,',','.'); ?></strong></td></tr>
			</table>
		</div>
  
  </div>
   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12"></br>
  <table width="100%">
   <tr  style="background-color: #E6E6E6"><td><label>Invantario Valorizado: Costo ->  <?php   echo "$ ".number_format($valor->val_costo, 2,',','.'); ?> Precio->  <?php   echo "$ ".number_format($valor->val_precio, 2,',','.'); ?> </label></td>
   <td><label>Clientes:<?php   echo count($clientes); ?> </label></td>
   <td><label>Proveedores:<?php   echo count($proveedores); ?> </label></td>
   <td><label>Articulos:<?php   echo count($articulos); ?> </label></td>
   </tr></table>   
   </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
					   <label>Usuario: </label>  {{ Auth::user()->name }}  
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div>
  </div>
  </div>


@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/reportes/resumen";
    });

});

</script>

@endpush
         
@endsection