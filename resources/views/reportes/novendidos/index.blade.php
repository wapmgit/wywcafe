@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<style>
.multiselect {
  width: 200px;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px #dadada solid;
}

#checkboxes label {
  display: block;
}

#checkboxes label:hover {
  background-color: #1e90ff;
}
</style>
<?php $mostrar=1; ?>
<div class="row" id="search" style="display: true">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<h3>Indique la fecha para la consulta</h3>
		@include('reportes.novendidos.search')
	</div>
</div>

@endsection
@endif
<?php $acum=0;$efe=0;$deb=0;$che=0;$tra=0;
$cefe=0;?>
@section('reporte')
<div class="row">
            <div class="col-md-12">
              <div class="box">
          
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="background-color: #fff">
                  

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    @include('reportes.novendidos.empresa')
<p align="right">
 <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span>

	</p>
	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
       
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Unidad</th>
          <th>Stock</th>
        </thead>
        <?php $ctra= 0; $acumcnt=0; $cdeb=0; $credito=0; $contado=0;$real=0; $count=0;$tventa=0; $auxp=$auxpv=0;?>

               @foreach ($datos as $q)
<?php $count++; ?>
        <tr>
         
          <td>{{ $q->codigo}}</td>
          <td>{{ $q->nombre}}</td>
          <td>{{ $q->unidad}}</td>    
          <td>{{ $q->stock}}</td>    
       </tr>
        @endforeach
		<tr><td align="right"><strong> Total articulos:</strong></td><td><strong><?php echo $count; ?></strong></td>
		<td></td></tr>
      </table>
	  </div>
  </div>

    </div>
     <label>  Usuario: {{ Auth::user()->name }}</label>    
  </div>
  </div>
  </div>
	          

                  
                  		</div>
                  	</div><!-- /.row -->
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
  window.location="/reportes/novendido";
    });

});
</script>

@endpush
@endsection