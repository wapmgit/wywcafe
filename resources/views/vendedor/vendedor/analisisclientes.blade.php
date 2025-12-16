@extends ('layouts.admin')
@section ('contenido')
<?php $cont=0; ?>

	<h3 align="center"> Analisis de Unidades Facturadas por Clientes  </h3>
  <hr/>
		       <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre Vendedor</label>
                   <p>{{$vendedores->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Cedula</label>
                   <p>{{$vendedores->cedula}}</p>
                    </div>
            </div>
			   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="form-group">
                      <label for="proveedor">Telefono</label>
                   <p>{{$vendedores->telefono}}</p>
                    </div>
            </div>
            </div>
            <div class ="row">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					
                        @foreach($clientes as $det)
						<?php $cont++;?>
				<label><small><small>{{$det->nombre}} ->{{$det->cedula}} ->{{$det->telefono}}</small></small></label>
				<table align="center" border="1" width="90%">
						<tr><td align="center">Ene</td><td align="center">Feb</td><td align="center">Mar</td><td align="center">Abr</td>
						<td align="center">May</td><td align="center">Jun</td><td align="center">Jul</td><td align="center">Ago</td>
						<td align="center">Sep</td><td align="center">Oct</td><td align="center">Nov</td><td align="center">Dic</td>
						</tr>
						<tr>							
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==1)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==2)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==3)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==4)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==5)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==6)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==7)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==8)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==9)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==10)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==11)){ echo $re->unidades; }?>@endforeach </td>				
 <td align="center">@foreach($resumen as $re)<?php if(($re->id_cliente==$det->id_cliente)and ($re->mes==12)){ echo $re->unidades; }?>@endforeach </td>				
						  
						  </tr></table>
                        @endforeach
						<label> <strong>Clientes: </strong><?php echo $cont; ?></label>
                 </br>                
                </div>
       </div>
	   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12" align="center">
	   <a href="/vendedor/vendedor"><button class="btn btn-danger" id="back"  >Regresar</button></a>
	     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
		 </div>
	@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/vendedor/vendedor";
    });
});

</script>

@endpush
@endsection