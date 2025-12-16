@extends ('layouts.admin')
@section ('contenido')
	<h3 align="center"> MOVIMIENTOS DE VACIOS</h3>
  <hr/>
		       <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Identificacion</label>
                   <p>{{$deposito->identificacion}}</p>
                    </div>
            </div>
             <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$deposito->nombre}}</p>
                    </div>
            </div>
			    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Debe</label>
                   <p>{{$deposito->debe}}</p>
                    </div>
            </div>
						    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Debo</label>
                   <p>{{$deposito->debo}}</p>
                    </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
				                        <thead style="background-color: #A9D0F5">                     
                          <th colspan="5">Movimientos del Debe</th>
              </thead>
                      <thead style="background-color: #A9D0F5">                     
                          <th>Fecha</th>
                          <th>Tipo</th>
                          <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Usuario</th>
              </thead><?php $acum=0; ?>
                      <tbody>
                        @foreach($movimiento as $det)
						<?php if ($det->tipo==1){ ?>
                        <tr > 
                          <td><?php echo date("d-m-Y",strtotime($det->fecha)); ?></td>
                          <td><?php if($det->tiporeg==1){ echo "Entrega"; }else { echo "Recepcion";} ?></td>
                          <td>{{$det->nombre}}</td>
                          <td>{{$det->cantidad}}</td>
                          <td>{{$det->usuario}}</td>                         
                        </tr>
						<?php } ?>
                        @endforeach
                      </tbody>  

                  </table>
                 
                    </div>
					                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
				                        <thead style="background-color: #A9D0F5">                     
                          <th colspan="5">Movimientos del Debo</th>
              </thead>
                      <thead style="background-color: #A9D0F5">                     
                          <th>Fecha</th>
                          <th>Tipo</th>
						   <th>Articulo</th>
                          <th>Cantidad</th>
                          <th>Usuario</th>
              </thead><?php $acum=0; ?>
                      <tbody>
                        @foreach($movimiento as $det)
						<?php if ($det->tipo==2){ ?>
                        <tr > 
                          <td><?php echo date("d-m-Y",strtotime($det->fecha)); ?></td>
                          <td><?php if($det->tiporeg==1){ echo "Entrega"; }else { echo "Recepcion";} ?></td>
                            <td>{{$det->nombre}}</td>
						  <td>{{$det->cantidad}}</td>
                          <td>{{$det->usuario}}</td>                         
                        </tr>
							<?php } ?>
                        @endforeach
                      </tbody>  

                  </table>
                 
                    </div>
					<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button>
					 <button type="button" id="regresarpg" class="btn btn-danger" data-dismiss="modal">Regresar</button>
                    </div>
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
    document.getElementById('regresarpg').style.display="none";
  window.print(); 
  window.location="/almacen/deposito";
    });
	$('#regresarpg').on("click",function(){
		window.location="/almacen/deposito";
		});
});

</script>

@endpush
@endsection