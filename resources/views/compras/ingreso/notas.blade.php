@extends ('layouts.admin')
@section ('contenido')
 @include('compras.ingreso.empresa')
	
	<h4 align="center">IMPORTAR NOTA DE ENTREGA A COMPRAS</h4>
		<?php if ($ingreso->estatus=="Anulada"){?><h3 align="center">* ANULADA * </h3><?php } ?>
  <hr/>
		    <div class="row">
					{!!Form::open(array('url'=>'ingreso/pnotas','method'=>'POST','id'=>'form','autocomplete'=>'off'))!!}
            {{Form::token()}}
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

                    <div class="form-group">
                    	<label for="proveedor">Rif -> Proveedor</label>
                   <p>{{$ingreso->rif}} -> {{$ingreso->nombre}}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                      <label for="proveedor">Direccion</label>
                   <p>{{$ingreso->direccion}}</p>
                    </div>
                </div>
				  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$ingreso->telefono}}</p>
                    </div>
                </div>
				
	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                	<label for="tipo_comprobante">Emision</label>
                         <input type="date" name="emision" class="form-control" value="{{$ingreso->emision}}">
                </div>
				</div>
				         	      <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="serie_comprobante">Serie-Documento</label>
                    <input type="text" name="serie_comprobante" value="{{$ingreso->serie_comprobante}}" class="form-control"placeholder="Numero del Documento" > 
                    <input type="hidden" name="id" value="{{$ingreso->idingreso}}" class="form-control" > 
                </div>
            </div>
			            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Numero Control</label>
                    <input type="text" required name="num_comprobante" id="num_comprobante" value="{{$ingreso->num_comprobante}}" class="form-control" placeholder="Numero de Control">
                </div>
            </div>
				</div>

            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                    
                  
                    
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="table-responsive">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #A9D0F5">
                     
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Precio Compra</th>
                          <th>Iva</th>
                          <th>Neto</th>
                          <th>Subtotal</th>
                      </thead>
                          <?php  $cnt=0; $mo=0; $abono=0; $acum=0; $pc=0;?>
                      <tbody>
                        @foreach($detalles as $det)
                        <?php $cnt++;  $mo=$mo+($det->subtotal); $pc= $det->cantidad*$det->precio_compra ?>
                        <tr >
                          <td>{{$det->articulo}}</td>
                          <td> <input id="cnt<?php echo $cnt; ?>"   type="number" readonly style="width: 60px" name="cantidad[]" value="{{$det->cantidad}}"></td>
                          <td> <input id="p<?php echo $cnt; ?>" onchange="javascript:calcular({{$cnt}});" step="0.01" type="number" style="width: 60px"  name="precio[]" value="{{$det->precio_compra}}"></td>
                          <td><input  id="iva<?php echo $cnt; ?>" type="number" style="width: 60px" name="iva[]" readonly value="{{$det->iva}}"></td>
                           <td><input  id="neto<?php echo $cnt; ?>" type="number" style="width: 60px" name="neto[]" readonly value="{{$pc}}"></td>
                          <td><input  id="sub<?php echo $cnt; ?>" type="number" style="width: 80px" name="subt[]" readonly  value="{{$det->subtotal}}">
						  <input type="hidden" name="detalle[]"  value="{{$det->iddetalle}}">
						  </td>
                        </tr>
                        @endforeach
                      </tbody> 
                      <tfoot> 
                     
                          <th colspan="5">TOTAL:</th>
                          <th ><input type="hidden" style="width: 80px" name="tcompra" id="tcompra" value="{{$mo}}"><h4 id="total"><b> <?php  echo number_format( $mo, 2,',','.'); ?> $</b></h4></th>
                          </tfoot>
                  </table>
				  </div>
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >Base Imponible: </label>  <input  id="tbase" type="number" style="width: 80px" name="tbase" readonly  value="{{$ingreso->base}}">
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >Iva: </label> <input  id="tiva" type="number" style="width: 80px" name="tiva" readonly  value="{{$ingreso->miva}}">
                    </div>
                     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <label >Exento: </label> <input  id="texe" type="number" style="width: 80px" name="texe" readonly  value="{{$ingreso->exento}}">                   </div>
                    </div>

                </div>
                    
                </div>
              
     
        </div>

				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
					 <button type="button" id="regresar" class="btn btn-danger" data-dismiss="modal" title="Presione Alt+flecha izq. para regresar">Regresar</button>
                     <button type="submit" id="imprimir" class="btn btn-primary" data-dismiss="modal">Convertir</button>
                    </div>
                </div>  
            	
             <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="num_comprobante">Fecha:</label>
                    <p><?php echo date("d-m-Y",strtotime($ingreso->fecha_hora)); ?></p>
                </div>
            </div> {!!Form::close()!!}
			@push ('scripts')
<script>
$(document).ready(function(){
	var acumneto=0;

$('#regresar').on("click",function(){
  window.location="/compras/ingreso";
  
});
});
function calcular(cnt){
	tcomp=$("#tcompra").val();
	sbant=$("#neto"+cnt).val();
	cant=$("#cnt"+cnt).val();
	pc=$("#p"+cnt).val();
	iva=$("#iva"+cnt).val();
	miva=$("#tiva").val(); 
	mbase=$("#tbase").val();
	mexe=$("#texe").val();
	var nneto=(cant*pc);
	vneto=$("#neto"+cnt).val();
	var subant= $("#sub"+cnt).val();	
//
if(iva > 0){
	var mexeant=0;
	var ivant=(sbant*(iva/100));
	var sb=(nneto*(1+(iva/100)));
	var niva=(nneto*((iva/100)));
$("#tiva").val((((miva-ivant)+niva)));	
$("#tbase").val((((mbase-vneto)+nneto)));
}else{
	sb=cant*pc;
	ivant=0;
	var mexeant=vneto;
	$("#texe").val((((mexe-mexeant)+sb)));
}

$("#neto"+cnt).val(nneto);
$("#sub"+cnt).val(sb.toFixed(2));
$("#tcompra").val(((tcomp-subant)+sb).toFixed(2));
$("#total").html(((tcomp-subant)+sb).toFixed(2));
}
</script>
@endpush
@endsection