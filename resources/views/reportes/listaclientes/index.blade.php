@extends ('layouts.admin')
@section ('contenido')
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
		<h3>Indique Parametros del Reporte</h3>
		@include('reportes.listaclientes.search')
	</div>
</div>
@endsection
<?php $acum=0;$tventasf=0;$deb=0;$nvnew=0;$newpendiente=0;$newvendido=0;$repre2=0; $posi2=0;
$cefe=0; $reg=0;?>
@section ('reporte')
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
                <!-- /.box-header -->
   
 @include('reportes.listaclientes.empresa')                
<div class="panel panel-primary">
<div class="panel-body"> 
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
		  <th>Item</th>
		  <th>Cliente</th>
          <th>Cedula/Rif</th>
		  <th>Telefono</th>
          <th>Direccion</th> 
	      <th>Licencia</th>		
	      <th>Vendedor</th>		
	      <th>Ruta</th>		
	      <th>Categoria</th>		  
		</thead><?php $count=0; $deuda=0; $acump=0; $tmonto=0; $tdeuda=0;$tpendiente=$tventas=$tmiva=0; ?>
               @foreach ($data as $q)
				<tr> <?php $count++; 
				?> 
			<td><?php  echo $count; 
				?> </td>
			<td><small>{{ $q->nombre}}</small></td>
			<td><small>{{ $q->cedula}}</small></td>				
			<td><small>{{ $q->telefono}}</small></td>				
			<td><small><small>{{ $q->direccion}}</small></small></td>				
			<td><small>{{ $q->licencia}}</small></td>				
			<td><small><small>{{ $q->vendedor}}</small></small></td>				
			<td>{{ $q->ruta}}</td>				
			<td><small>{{ $q->nombrecategoria}}</small></td>				
				</tr>
				@endforeach
			</table>
		</div>



  </div>
  </div>
  </div>
  </div>
  </div>
  

           
 <label>Usuario: {{ Auth::user()->name }}</label>   
                  
                  	     </div>
                    </div><!-- /.row -->
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Impimir</button>
            <!-- <a href="/reportes/compras/excel/"><button class="btn btn-warning">TXT</button></a> -->
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
  window.location="../reportes/clientes";
    });

});
</script>

@endpush
@endsection