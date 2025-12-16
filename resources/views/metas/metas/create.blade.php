@extends ('layouts.admin')
@section ('contenido')
<?php
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
			<h3>Nueva Meta </h3>
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
			{!!Form::open(array('url'=>'metas/save','method'=>'POST','autocomplete'=>'off','id'=>'formajuste'))!!}
            {{Form::token()}}
            <div class="row">
           
             <div class="col-lg-6 col-md-46col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Descripcion</label>
                    <input type="text" name="descripcion" id="concepto" value="" class="form-control"placeholder="Descripcion de Meta" > 
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3col-xs-12">

	<div class="form-group">
	<div class="input-group">      <label for="concepto">Inicio</label>
	<input type="date" class="form-control" name="inicio" value="">
	</div>
	
	</div>
            </div>
			   <div class="col-lg-3 col-md-3 col-sm-3col-xs-12">
<div class="form-group">
	<div class="input-group">      <label for="concepto">Fin</label>
		<input type="date" class="form-control" name="fin"  value="">
	</div>
</div>
        </div>	
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                             <label>Cod - Articulo - existencia</label> 
                             <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
                             @foreach ($articulos as $articulo)
                              <option value="{{$articulo -> idarticulo}} - {{$articulo -> precio1}}">{{$articulo -> articulo}}</option> 
                             @endforeach
                              </select>
                        </div>
                </div>
              
                    <div class="col-lg-3 ol-md-3 col-sm-3 col-xs-6">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" min="0" class ="form-control" placeholder="Cantidad">
                    </div>
                    </div>
    
                     <div class="col-lg-3 ol-md-3 col-sm-3 col-xs-6">
                    <div class="form-group"><label></label>	
                     <button type="button" id="bt_add"  <?php if($vencida==1){?>style="display: none"<?php } ?> onmouseover="this.style.color='blue';" onmouseout="this.style.color='grey';"  class="form-control"><i class="fa fa-fw fa-plus-square"></i></button>
                    </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                          <th>Opciones</th>
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Subtotal</th>
                      </thead>
                      <tfoot> 
                      <th>Total</th>
                          <th></th>
                          <th><h4 id="tcnt">  0.00</h4><input type="hidden" name="cnt" id="cnt"></th>
                          <th><h4 id="total">$.  0.00</h4><input type="hidden" name="totalo" id="totalo"></th>
                          </tfoot>
                      <tbody></tbody>
                  </table>
				</div>
                    </div>

                </div>
                    
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar" align="right">
            	    <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
                        <button class="btn btn-primary" type="button" id="btnguardar">Guardar</button>
            	       <button class="btn btn-danger" type="reset" id="btncancelar">Cancelar</button>
					   <div style="display: none" id="loading">  <img src="{{asset('imagenes/sistema/loading30.gif')}}"></div>
                    </div>
                </div>
     
        </div>
			{!!Form::close()!!}		
       
@push ('scripts')
<script>

$(document).ready(function(){
		document.getElementById('pcantidad').addEventListener('keypress',function(e){ validarno(e); });	
    $('#bt_add').click(function(){ 
     agregar();
    });
	$("#pidarticulo").change(function(){
		  document.getElementById('pcantidad').focus();
	})

 $('#btnguardar').click(function(){   

 if($("#concepto").val() == "" ){alert('Debe indicar Concepto.'); } else{
		document.getElementById('loading').style.display=""; 
		document.getElementById('btnguardar').style.display="none"; 
		document.getElementById('btncancelar').style.display="none"; 
		document.getElementById('formajuste').submit(); }	
    })

})
								function validarno(e){
								let tecla = (document.all) ? e.keyCode : e.which;
								if(tecla==13) { 
								event.preventDefault();
								} }	
var cont=0;
var total=0;
var acumcnt=0;
subtotal=[];
subcnt=[];
$("#guardar").hide();

    function agregar(){
	
        total=$("#totalo").val();
        if (total>0){total=total*1;}if (total<0){total=total*1;}
		datosarticulo=document.getElementById('pidarticulo').value.split('-');
        idarticulo=datosarticulo[0];
        articulo= $("#pidarticulo option:selected").text();
        cantidad= $("#pcantidad").val();
        precio_compra=datosarticulo[1];
	

        if (idarticulo!="" && cantidad != ""){         
            subtotal[cont]=(cantidad*precio_compra);                 
            subcnt[cont]=cantidad;                 
            total=(total)+(subtotal[cont]);           
            acumcnt=parseFloat(acumcnt)+parseFloat(subcnt[cont]);           
            var fila='<tr class="selected" id="fila'+cont+'"><td><button class="btn btn-warning btn-xs" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" readonly style="width: 80px" value="'+cantidad+'"></td><td><input type="number" name="precio_compra[]"  style="width: 80px" readonly value="'+subtotal[cont].toFixed(2)+'"></td></tr>';
            cont++;
            limpiar();
			auxtotal=(total*1).toFixed(2);
            $("#tcnt").html(acumcnt);
            $("#total").html("$ : " + auxtotal);
            $("#cnt").val(acumcnt); 
            $("#totalo").val(total); 
         	$("#pidarticulo").selectpicker('toggle');
            evaluar();
            $('#detalles').append(fila);
        }
        else{
            alert("Error al ingresar el articulo")
        }
    }
    function eliminar(index){
      total= $("#totalo").val();  $("#cnt").val(); 
        total=total-subtotal[index];       acumcnt=acumcnt-subcnt[index];
		auxtotal=(total*1).toFixed(2);    	
        $("#total").html("$" + auxtotal);   $("#tcnt").html(acumcnt);
          $("#totalo").val(total);    $("#cnt").val(acumcnt);
        $("#fila" + index).remove();
        evaluar();

    }
    function limpiar(){
        $("#pcantidad").val("");    
    }

    function evaluar(){
        if(total =! 0){
            $("#guardar").show();
        }
        else
        {
            $("#guardar").hide();
        }
    }

</script>
@endpush
@endsection