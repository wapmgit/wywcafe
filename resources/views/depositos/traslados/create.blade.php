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
			<h3>Nuevo Traslado</h3>
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
			{!!Form::open(array('url'=>'deposito/traslado/','method'=>'POST','autocomplete'=>'off','id'=>'formulario'))!!}
            {{Form::token()}}
            <div class="row">
           
             <div class="col-lg-6 col-md-46col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="concepto">Concepto</label>
                    <input type="text" name="concepto" id="concepto" value="{{old('concepto')}}" class="form-control"placeholder="Descripcion del Documento" > 
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="responsable">Responsable</label>
                    <input type="text"  name="responsable" id="responsable" value="{{old('responsable')}}" class="form-control" placeholder="Responsable">
                </div>
            </div>
			     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                             <label>Dep. Origen</label>
                             <select name="origen" id="origen" class="form-control selectpicker" data-live-search="true">
							 <option value="0">Seleccione Origen..</option>
                             @foreach ($deposito as $dep)
                              <option value="{{$dep -> id_deposito}}">{{$dep-> nombre}}</option> 
                             @endforeach
                              </select>
                        </div>
					</div>
					 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="form-group">
                             <label>Dep. Destino</label>
                             <select name="destino" id="destino" class="form-control selectpicker" data-live-search="true">
							 <option value="0">Seleccione Destino..</option>
                             @foreach ($deposito as $dep)
                              <option value="{{$dep -> id_deposito}}">{{$dep-> nombre}}</option> 
                             @endforeach
                              </select>
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
                              <option value="{{$articulo -> idarticulo}}-{{$articulo -> costo}}">{{$articulo -> articulo}}</option> 
                             @endforeach
                              </select>
                        </div>
					</div>
              
  
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" class ="form-control" placeholder="Cantidad">
                    </div>
                    </div>
                   
                      <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group">
                        <label for="costo">Costo</label>
                        <input type="number" name="pcosto" id="pcosto" class ="form-control" placeholder="Costo">
                    </div>
                    </div>
                       <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <div class="form-group"></br>
                     <button type="button" id="bt_add" class="btn btn-primary" <?php if($vencida==1){?>style="display: none"<?php } ?> > Agregar</button>
                    </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                          <th>Opciones</th>
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Costo</th>
                          <th>Subtotal</th>
                      </thead>
                      <tfoot> 
                      <th>Total</th>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th><h4 id="total">$.  0.00</h4><input type="hidden" name="totalo" id="totalo"></th>
                          </tfoot>
                      <tbody></tbody>
                  </table>
                    </div>

                </div>
                    
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
            	    <div class="form-group">
                    <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
                        <button class="btn btn-primary" id="enviar" type="submit">Guardar</button>
            	       <button class="btn btn-danger" type="reset">Cancelar</button>
                    </div>
                </div>
     
        </div>
			{!!Form::close()!!}		
       
@push ('scripts')
<script>
$("#pcantidad").change(validar);  
$(document).ready(function(){
	$("#pidarticulo")
  .empty() 
  .selectpicker('refresh');
  
    $('#bt_add').click(function(){
	var vori=$("#origen").val();
	var vdes=$("#destino").val();
if( vdes==0){ alert('Debe Seleccionar Depositos para Traslado');}else{	
     agregar();
}
    })
		    $('#enviar').click(function(){
	document.getElementById("enviar").disabled=true;
		document.getElementById("formulario").submit();
	
    })
		 $("#origen").on("change",function(){
    var vmuni=$("#origen").val();
     $("#pidarticulo")
  .empty() 
  .selectpicker('refresh');
          var j=0;
         var form= $('#formulario');
        var url = '/deposito/traslado/listar';
        var data = form.serialize();
    $.post(url,data,function(result1){  
      var resultado1=result1;
          console.log(resultado1); 
         parada=resultado1.length;
if(parada<1){alert('almacen de origen no posee articulos con existencias¡¡');}	 
  for(j=0;j<=parada;j++){ $("#pidarticulo")
  .append( 
    '<option value="'+resultado1[j].idarticulo+'-'+resultado1[j].costo+'">'+resultado1[j].articulo+'</option>' )
  .selectpicker('refresh');
        }
		
          });
     });
	
	$("#destino").on("change",function(){
	var vori=$("#origen").val();
	var vdes=$("#destino").val();
	if(vori==vdes){ alert(' deposito Destino debe ser diferente al Deposito de Origen');
	  $("#destino").val('0');
	}
			 });
})
var cont=0;
var total=0;
subtotal=[];
$("#guardar").hide();

    function agregar(){
		if($("#concepto").val()!="" && $("#responsable").val()!=""){
        total=$("#totalo").val();
        if (total>0){total=total*1;}if (total<0){total=total*1;}
		datosarticulo=document.getElementById('pidarticulo').value.split('-');
        idarticulo=datosarticulo[0];
        articulo= $("#pidarticulo option:selected").text();
        cantidad= $("#pcantidad").val();
        precio_compra=$("#pcosto").val();

        if (idarticulo!="" && cantidad != "" && precio_compra!=""){
                      
            subtotal[cont]=(cantidad*precio_compra);              
            total=(total)+(subtotal[cont]);
            
            var fila='<tr class="selected" id="fila'+cont+'"><td><button class="btn btn-warning btn-xs" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td>'+subtotal[cont]+'</td></tr>';
            cont++;
            limpiar();
            $("#total").html("$ : " + total);
            $("#totalo").val(total); 
         
            evaluar();
            $('#detalles').append(fila);
        }
        else{
            alert("Error al ingresar el articulo");
        }
		}else{ alert("Debe Indicar un Concepto y Responsable del Movimiento");}
    }
    function eliminar(index){
      total= $("#totalo").val();
        total=total-subtotal[index];
        $("#total").html("$" + total);
          $("#totalo").val("");
        $("#fila" + index).remove();
        evaluar();

    }
    function limpiar(){
        $("#pcantidad").val("");
        $("#pprecio_compra").val("");
         $("#pcosto").val("");
      
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
    function validar(){   
      pcanti=$("#pcantidad").val();
      datosarticulo= $("#pidarticulo option:selected").text();
      arti=datosarticulo.split('-'); 
          st=arti[2];
        if (pcanti>parseFloat(st)){
          alert('cantidad supera al stock!! \n existencia:'+arti[2]);
          $("#pcantidad").val("");
          $("#pcosto").val("");
          $("#pcantidad").focus();
        } else {
            dato=document.getElementById('pidarticulo').value.split('-');
             st1=dato[1];
             $("#pcosto").val(st1);
          }
      
      }
</script>
@endpush
@endsection