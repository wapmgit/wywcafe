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
			<h3>Nuevo Bloque </h3>
			@if (count($errors)>0)
			<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
				</ul>
			</div>
			@endif
        </div> @include('compras.ajuste.modalcsv')
        </div>
			{!!Form::open(array('url'=>'metas/bloques','method'=>'POST','autocomplete'=>'off','id'=>'formajuste'))!!}
            {{Form::token()}}
            <div class="row">
           
             <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                <div class="form-group">
                    <label for="concepto">Nombre del Bloque</label>
                    <input type="text" name="concepto" id="concepto" value="{{old('descripcion')}}" class="form-control"placeholder="Descripcion del Documento" > 
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
                <div class="form-group">
                    <label for="responsable">Responsable</label>
                    <input type="text"  name="responsable" id="responsable" value="{{old('responsable')}}" class="form-control" placeholder="Responsable">
                </div>
            </div>
		
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                        <div class="form-group">
                             <label>Cod - Articulo - existencia</label>
                             <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
                             @foreach ($articulos as $articulo)
                              <option value="{{$articulo -> idarticulo}} - {{$articulo -> costo}}">{{$articulo -> articulo}}</option> 
                             @endforeach
                              </select>
                        </div>
                </div>

                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
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
                      </thead>
                      <tfoot> 
                      <th>Total</th>
                          <th><h4 id="total"> 0</h4><input type="hidden" name="totalo" id="totalo"></th>
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

    $('#bt_add').click(function(){  
     agregar();
    });


 $('#btnguardar').click(function(){   

 if($("#concepto").val() == "" ){alert('Debe indicar Concepto.'); } else{
 if($("#responsable").val() == "" ){alert('Debe indicar Responsable.');}else{ 
		document.getElementById('loading').style.display=""; 
		document.getElementById('btnguardar').style.display="none"; 
		document.getElementById('btncancelar').style.display="none"; 
		document.getElementById('formajuste').submit(); }	 }
    })

})
			
var cont=0;
var total=0;
subtotal=[];
$("#guardar").hide();

    function agregar(){
        total=$("#totalo").val();
        if (total>0){total=total*1;}if (total<0){total=total*1;}
		datosarticulo=document.getElementById('pidarticulo').value.split('-');
        idarticulo=datosarticulo[0];
        articulo= $("#pidarticulo option:selected").text();
			optselect=$("#pidarticulo").val(); 
        if (idarticulo!=""){

                 
            total=total+subtotal[cont];
            
            var fila='<tr class="selected" id="fila'+cont+'"><td><button class="btn btn-warning btn-xs" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td></tr>';
            cont++;
			auxtotal=(cont*1).toFixed(2);
            $("#total").html(cont);
            $("#totalo").val(cont); 
			$('#pidarticulo :selected').remove(); 
			$("#pidarticulo")
				.selectpicker('refresh');
         	$("#pidarticulo").selectpicker('toggle');
            evaluar();
            $('#detalles').append(fila);
        }
        else{
            alert("Error al ingresar el articulo")
        }
    }
    function eliminar(index){
      total= $("#totalo").val();
        total=total-1;
		auxtotal=(total*1);
        $("#total").html(auxtotal);
          $("#totalo").val(total);
        $("#fila" + index).remove();
        evaluar();

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