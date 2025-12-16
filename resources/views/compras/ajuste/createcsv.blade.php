@extends ('layouts.admin')
@section ('contenido')
<?php
$acumst=$art=0;
$fserver=date('Y-m-d');
$fecha_a=$empresa -> fechasistema;
function dias_transcurridos($fecha_a,$fserver)
{
$dias = (strtotime($fecha_a)-strtotime($fserver))/86400;
//$dias = abs($dias); $dias = floor($dias);
return $dias;
} 
$vencida=0;
if (dias_transcurridos($fecha_a,$fserver) < 0){
  $vencida=1;
  echo "<div class='alert alert-danger'>
      <H2>LICENCIA DE USO DE SOFTWARE VENCIDA!!!</H2> contacte su Tecnico de soporte.
      </div>";
};
  
?>
	<div class="row">

		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<h3>Nuevo Ajuste Archivo csv</h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
        </div>

    </div>
		
    <div class="row">
           	{!!Form::open(array('url'=>'compras/ajuste','method'=>'POST','autocomplete'=>'off','id'=>'formajustecsv'))!!}
            {{Form::token()}}
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
			<div class="form-group">
				<label for="concepto">Concepto</label>
				<input type="text" name="concepto" id="concepto" value="{{$concepto}}" class="form-control" > 
			</div>				
		 </div>				 
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="responsable">Responsable</label>
                    <input type="text"  name="responsable" id="responsable" value="{{$responsable}}" class="form-control">
                </div>
        </div>	
    </div>
    <div class ="row">
        <div class="panel panel-primary">
            <div class="panel-body">               
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
						<table  class="table table-striped table-bordered table-condensed table-hover">
							<thead style="background-color: #A9D0F5">
							  <th>Opciones</th>
							  <th>Articulo</th>
							  <th>Tipo Ajuste</th>
							  <th>Cantidad</th>
							  <th>Costo</th>
							  <th>Subtotal</th>
						  </thead>
					
								<tbody>
								<?php $art= count($articulos); ?>
									@foreach($articulos as $t)
									<?php $acumst=($acumst+($t -> costo*$t -> cantidad));?>
							<tr>
								<td><input type="hidden" name="idarticulo[]" value="{{$t -> idarticulo}}">{{$t -> idarticulo}}</td>
								<td>{{$t -> nombre}}</td>							
								<td><input type="hidden" name="tipo[]" value="Cargo">Cargo</td>
								<td><input type="hidden" name="cantidad[]" value="{{$t -> cantidad}}">{{$t -> cantidad}}</td>								
								<td><input type="hidden" name="precio_compra[]"  value="{{$t -> costo}}">{{$t -> costo}}</td>								
								<td>{{$t -> costo*$t -> cantidad}}</td>								
								</tr>
                             @endforeach						
							 </tbody>		
							 <tfoot> 
							<th>Total</th>
							  <th> <?php echo $art." Articulos"; ?> </th>
							  <th></th>
							  <th></th>
							  <th></th>
							  <th><h4 id="total"><?php echo "$". number_format($acumst,'2','.','.');?></h4><input type="hidden" name="totalo" id="totalo" value="<?php echo $acumst; ?>"></th>
							</tfoot>
						</table>
					</div>
                </div>

            </div>
                    
        </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar" align="right">
            	    <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
                        <button class="btn btn-primary" type="button" id="btnguardarcsv">Guardar</button>
            	       <button class="btn btn-danger" type="reset" id="btncancelarcsv">Cancelar</button>
					   <div style="display: none" id="loading2">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
                    </div>
                </div>
     {!!Form::close()!!}	
    </div>    
@push ('scripts')
<script>
 
$(document).ready(function(){
 $('#btnguardarcsv').click(function(){   
 if($("#concepto").val() == "" ){alert('Debe indicar Concepto.'); } else{
 if($("#responsable").val() == "" ){alert('Debe indicar Responsable.');}else{ 
		document.getElementById('loading2').style.display=""; 
		document.getElementById('btnguardarcsv').style.display="none"; 
		document.getElementById('btncancelarcsv').style.display="none"; 
		document.getElementById('formajustecsv').submit(); }	 }
    });
			
$('#btncancelar').click(function(){	
    window.location="/compras/ajuste";
});		
});  
</script>
@endpush
@endsection