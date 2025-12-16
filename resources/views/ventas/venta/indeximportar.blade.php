@extends ('layouts.admin')
@section ('contenido')
@include('almacen.articulo.empresa')
<div class="row"><?php $cont=0; $tventa=0; $fserver=date('Y-m-d');?>
	{!!Form::open(array('url'=>'ventas/procesarnota','method'=>'POST','id'=>'form','autocomplete'=>'off'))!!}
            {{Form::token()}}
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
		   	<label>Cliente</label>
				<select name="id_cliente" id="id_cliente" class="form-control selectpicker" data-live-search="true">
						                           @foreach ($personas as $per)
                           <option value="{{$per -> id_cliente}}_{{$per -> tipo_precio}}_{{$per -> comision}}_{{$per -> nombrev}}_{{$per -> tipo_cliente}}_{{$per -> cedula}}_{{$per -> nombre}}_{{$per->diascre}}">{{$per -> cedula}}-{{$per -> nombre}}</option> 
                           @endforeach
                        </select> 
						</div>
						<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
								   	<label>Tasa</label>
						<input type="number" value="{{$empresa->tc}}" id="tasa" step="0.01" name="tasa" class="form-control"></input>
						</div>
							<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
						<label for="fecha">Fecha Emision</label>
							<input type="date"  style="width: 150px" name="fecha_emi"  id="fecha_emi" value="<?php echo $fserver;?>" class="form-control">
						</div>
						
						
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" >
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover" id="tabla">
				<thead>
					<th>Fecha</th>
					<th>Cliente</th>
					<th>Tipo comp</th>
					<th>Total</th>
					<th>Vendedor</th>
					<th>Incluir</th>
				</thead>
               @foreach ($ventas as $ven)
               <?php $cont++;
			   $tventa=$ven->mcosto+$ven->mivaf+$ven->texe;
$newdate=date("d-m-Y",strtotime($ven->fecha_hora));
    ?>
				<tr>
					<td><small><?php echo $newdate; ?></small></td>
					<td><small>{{ $ven->nombre}}</small></td>
					<td><small>{{ $ven->serie_comprobante.'-'.$ven->num_comprobante}} </small></td>
					<td>{{ $tventa}}</td>
					<td><small>{{ $ven->vendedor}}</small></td>
				
					<td>
			<input type="checkbox"  id="<?php echo $cont; ?>" onclick="javascript:abrirdivnc({{$cont}},{{$tventa}},{{$ven->mivaf}},{{$ven->texe}});" value="{{ $ven->idventa}}" name="convertir[]" />  
			<input type="checkbox" style="display:none" checked id="<?php echo "a".$cont; ?>" onclick="javascript:abriract({{$cont}},{{$tventa}},{{$ven->mivaf}},{{$ven->texe}});" value="{{ $ven->idventa}}" name="convertir2[]" />  
			<input type="checkbox" style="display:none"  id="<?php echo "p".$cont; ?>" value="{{ $ven->idventa}}" name="notas[]" />  
				
					</td>
				</tr>
		
				@endforeach
			</table>
		</div>

	</div>	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
	Total Factura: <input type="number" value="0" id="tdoc" name="tdoc" readonly class="form-control"></input>
	Total Iva: <input type="number" value="0" id="tiva" name="tiva" readonly class="form-control"></input>
	Total Exento: <input type="number" value="0" id="texe" name="texe" readonly class="form-control"></input>
	</div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
	Total Bs: <input type="number" value="0" id="tdocbs" name="tdocbs" readonly class="form-control"></input>
	
	</div>
	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
<button type="submit" id="procesa" class="btn btn-primary" ><u>P</u>rocesar</button>
	</div>
	{!!Form::close()!!}
</div>
@push ('scripts')
<script>

$(document).ready(function(){
	  $('#tabla').DataTable({
  });
});
function abrirdivnc(id,total,iva,exe){
		var mt=1;
	document.getElementById(id).style.display="none"; 
	document.getElementById('a'+id).style.display=""; 
	$('#'+id).attr("checked",false);
	$('#p'+id).attr("checked",true);
	var mdoc=$('#tdoc').val();
	var miva=$('#tiva').val();
	var mexe=$('#texe').val();
	var sumdoc=parseFloat(mdoc)+parseFloat(total);
	var sumiva=parseFloat(miva)+parseFloat(iva);
	var sumexe=parseFloat(mexe)+parseFloat(exe);
$('#tdoc').val(sumdoc.toFixed(2));
$('#tiva').val(sumiva.toFixed(2));
$('#texe').val(sumexe.toFixed(2));
$('#tdocbs').val(((parseFloat(mdoc)+parseFloat(total))*mt).toFixed(2));

}
function abriract(id,total,iva,exe){	
		var mt=1;
	document.getElementById(id).style.display=""; 
	document.getElementById('a'+id).style.display="none"; 
	document.getElementById('a'+id).checked="true"; 
	$('#p'+id).attr("checked",false);
	var mdoc=$('#tdoc').val();
	var miva=$('#tiva').val();
	var mexe=$('#texe').val();
	var resdoc=parseFloat(mdoc)-parseFloat(total);
	var resiva=parseFloat(miva)-parseFloat(iva);
	var resexe=parseFloat(mexe)-parseFloat(exe);
$('#tdoc').val(resdoc.toFixed(2));
$('#tiva').val(resiva.toFixed(2));
$('#texe').val(resexe.toFixed(2));
$('#tdocbs').val(((parseFloat(mdoc)-parseFloat(total))*mt).toFixed(2));
}
</script>
@endpush
@endsection