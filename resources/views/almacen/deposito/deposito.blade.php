@extends ('layouts.admin')
@section ('contenido')
<style type="text/css">
#global {
	height: 600px;
	width: 100%;
	border: 1px solid #ddd;
	background: #f1f1f1;
	overflow-y: scroll;
}
</style>
<?php $in=$out=0;?>
	<h3 align="center">	DEPOSITO DE VACIOS</h3>
  <hr/>
  <div class="row">
          <div class="col-lg-8 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
			  <h3 align="center"></h3>
			<table width="95%">
			<tr><td>Articulo</td><Td>Stock</td></tr>
			@foreach($cntvacios as $cnt) <?php $in=$in+$cnt->ingresos;  
			$out=$out+$cnt->egresos?>
			<tr><td>{{$cnt->nombre}}</td><Td>{{$cnt->ingresos-$cnt->egresos }}</td></tr>
			@endforeach
			</table>
            </div>
          </div>
        </div>
 					@include('almacen.deposito.movalmacen')
		         <div class="col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
			  <h3 align="center"><?php echo $in-$out;  ?></h3>
              <p align="center">
			  <label> Stock General</p>
            </div>
			<div class="icon">
              <i class="ion ion-bag"></i>
            </div>
			<a href="" data-target="#mov" data-toggle="modal" class="small-box-footer"><button class="btn btn-success btn-xs">Registro</button></a>
          </div>
        </div>
  </div>
            <div class ="row" >
			<div id="global">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
                  <table id="detalles" width="100%">
				<thead style="background-color: #A9D0F5">                     
                          <th colspan="6">Movimientos en Deposito</th>
              </thead>
                      <thead style="background-color: #A9D0F5">                     
                          <th>Fecha</th>
						  <th>Articulo</th>
                          <th>Entrada</th>
                          <th>Salida</th>
                          <th>Concepto</th>
                          <th>Responsable</th>
              </thead><?php $acum=0; ?>
                      <tbody>
						@foreach($movvacios as $mov)
						<tr>
						<td>{{$mov->fecha}}</td>
						<td>{{$mov->nombre}}</td>
						<td>{{$mov->entrada}}</td>
						<td>{{$mov->salida}}</td>
						<td>{{$mov->concepto}}</td>
						<td>{{$mov->responsable}}</td>
						</tr>
						@endforeach
                      </tbody>  

                  </table>
                 
                    </div>
		</div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					 <button type="button" id="regresarpg" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                    </div>
                </div>

       </div>
		@push ('scripts')
<script>

$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
    document.getElementById('regresarpg').style.display="none";
  window.print(); 
  window.location="/almacen/deposito";
    });
	$('#regresarpg').on("click",function(){
		window.location="/almacen/deposito";
		});
});

</script>

@endpush
@endsection