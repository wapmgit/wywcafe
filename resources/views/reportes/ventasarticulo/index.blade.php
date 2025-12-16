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
		@include('reportes.ventasarticulo.search')
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

    @include('reportes.ventasarticulo.empresa')
<p align="right">
  	<?Php if($fecha=="fecha"){ echo "<b>Facturacion</b>"; }else{ echo "<b>Emision</b>"; }  ?>  <span ><?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </span>

	</p>
	<div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6" >
       
          <th>Codigo</th>
          <th>Nombre</th>
          <th>Pv Promedio</th>
          <th>Grupo</th>
          <th>Precio Venta</th>
          <th>Cantidad</th>
          <th>Monto</th>
      
        </thead>
        <?php $ctra= 0; $acumcnt=0; $cdeb=0; $credito=0; $contado=0;$real=0; $count=0;$tventa=0; $auxp=$auxpv=0;?>

               @foreach ($datos as $q)
            <?php $tventa=$tventa +($q->vendido*$q->pventa); 
			$acumcnt=$acumcnt+$q->vendido;
			$auxp=number_format($q->vpromedio, 2,',','.'); $auxpv=number_format($q->pventa, 2,',','.');
			?>
        <tr>
         <td>{{ $q->codigo}}</td>
          <td>{{ $q->nombre}}</td>
          <td><?php echo number_format($q->vpromedio, 2,',','.');?></td>
          <td>{{ $q->grupo}}</td>
          <td><?php if ($auxp==$auxpv) {$real=$q->pventa; echo number_format($real, 2,',','.'); }
		  else { $real=($q->pventa); echo number_format(($real), 2,',','.');}
		  ?></td>
           <td><?php echo number_format(($q->vendido), 2,',','.'); ?>
		   	    <a class="enlace" href="" data-target="#modaldetalle{{$q->idarticulo}}" data-toggle="modal"><i class="fa fa-fw fa-eye" title="Ocultar" id="ocultarp2"></i></a>	</td>
           <td><?php echo number_format(($q->vendido*$real), 2,',','.'); ?></td>       
       </tr>
	    @include('reportes.ventasarticulo.modaldetalle')
        @endforeach
		<tr><td colspan="5" align="right"><strong> Total Venta:</strong></td><td><strong><?php echo $acumcnt." Unds"; ?></strong></td><td><strong><?php echo number_format(($tventa), 2,',','.')." $"; ?></strong></td></tr>
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
  window.location="/reportes/ventasarticulo";
    });
	$("#filtro").on("change",function(){
		var variable=$("#filtro").val();							
		if( variable==1){
			document.getElementById('divend').style.display=""; 
			document.getElementById('divruta').style.display="none"; 
			document.getElementById('divcli').style.display="none"; 
			document.getElementById('divrutaund').style.display="none";
			$("#idcliente").val(0);
		}
		if( variable==2){
			document.getElementById('divend').style.display="none"; 
			document.getElementById('divcli').style.display=""; 
			document.getElementById('divruta').style.display="none"; 
			document.getElementById('divrutaund').style.display="none";
			$("#idvendedor").val(0);
		}
		if( variable==3){
			document.getElementById('divruta').style.display=""; 
			document.getElementById('divend').style.display="none"; 
			document.getElementById('divcli').style.display="none"; 
			document.getElementById('divrutaund').style.display="none";
			$("#idvendedor").val(0);
		}
			if( variable==4){
			
			document.getElementById('divrutaund').style.display=""; 
			document.getElementById('divruta').style.display="none"; 
			document.getElementById('divend').style.display="none"; 
			document.getElementById('divcli').style.display="none"; 
			$("#idvendedor").val(0);
		}
	});
});
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>

@endpush
@endsection