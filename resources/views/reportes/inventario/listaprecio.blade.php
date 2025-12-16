@extends ('layouts.admin')
@section ('contenido')
<div class="panel panel-primary">
<div class="panel-body">		
 <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	</div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3"> 
	 <h3 align="center">LISTA DE PRECIOS</h3>
	 </div>
		<div class="col-lg-3 col-sm-3 col-md-3 col-xs-3">
		<div align="center">   <img src="{{asset('dist/img/logoempresa.jpg')}}" width="50%" height="90%" title="NKS"></div>
		</div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <div>
      
      <table width="100%">
        <thead style="background-color: #A9CCE3 !important">
			<th>Codigo</th>
			<th>Nombre</th>
			<th>Unidad</th>
		
			<th>Precio 1</th>
			<th>Precio 2</th>
				</thead><?php $count=0; $i=0;$costo=0;$costoacum=0; $precioacum=0;?>
               @foreach ($lista as $q)
			   <?php $i++; ?>
				<tr <?php if (($i%2)==0){ echo "style='background-color: #D4E6F1 !important'";}?>> <?php $count++; 
        $costoacum=$q->stock+$costoacum;
		$costo=$costo+($q->costo*$q->stock);
        $precioacum=$q->stock*$q->precio1+$precioacum;
         ?> 
		 <td>{{ $q->codigo}}</td>
					<td>{{ $q->nombre}} <?php if($q->iva>0){echo "(G)"; }else { echo "(E)"; } ?></td>
					<td>{{ $q->unidad}}</td>
				
					<td><?php echo number_format( $q->precio1, 2,',','.'); ?></td>	
          <td><?php echo number_format( $q->precio2, 2,',','.'); ?></td>  
				</tr>

				@endforeach
        <tr style="background-color: #A9CCE3" >
          <td colspan="3"><?php echo "<strong>Articulos: ".$count."</strong>"; ?></td>
          <td><?php echo "<strong>existencias : ".$costoacum."</strong>"; ?></td>
   

          <td></td>
</tr>
			</table>

		</div>
  
  </div>
  <div class="col-lg-12 col-md-12 csol-sm-6 col-xs-12">
                    <div class="form-group" align="center"></br>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					  <a href="/reportes/excel/inventariofisico"><button class="btn btn-warning">TXT</button></a> 
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
  window.location="/reportes/listaprecio";
    });

});

</script>

@endpush
         
@endsection