@extends ('layouts.admin')
@section ('contenido')
			@include('almacen.deposito.modal')
			@include('almacen.deposito.modal3')
	<h3 align="center"> REGISTROS DE MOVIMIENTOS DE VACIOS</h3>
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
                      <label for="proveedor">Debe <a href="" data-target="#modal-agg-{{$deposito->id_deposito}}" data-toggle="modal"><button class="btn btn-warning btn-xs">Agg.</button></a></label>
                   <p>{{$deposito->debe}}     </p>
                    </div>
            </div>
						    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                 <div class="form-group">
                      <label for="proveedor">Debo 	<a href="" data-target="#modal-aggdebo-{{$deposito->id_deposito}}" data-toggle="modal"><button class="btn btn-warning btn-xs">Agg.</button></a></label>
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
                          <th>Articulo</th>
                          <th>Entegas</th>
                          <th>Recepciones</th>
                          <th colspan="2">Pendiente</th>
              </thead><?php $acum=0; ?>
                      <tbody>
                        @foreach($articulo as $det)
						<?php $rec=$ent=0; $cnt=0;?>
                        <tr >  
                          <td>{{$det->nombre}}</td>
                          <td>@foreach($movimientoin as $de) <?php
						  if($de->idarticulo==$det->idarticulo){ $ent=$de->cntagg; echo $de->cntagg;  } ?> @endforeach </td>
						  <td> @foreach($movimientoout as $de2) <?php
						  if($de2->idarticulo==$det->idarticulo){ $rec=$de2->cntagg; echo $de2->cntagg; }?> @endforeach</td>
                       <td><?php $cnt=($ent-$rec); echo ($cnt)." "; ?></td>
						<td><a href="" data-target="#recep-{{$det->iddetalle}}" data-toggle="modal"><button class="btn btn-success btn-xs">Recep.</button></a></td>
                        </tr>
					@include('almacen.deposito.modal2')
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
                          <th>Articulo</th>
                          <th>Entegas</th>
                          <th>Recepciones</th>
                          <th colspan="2">Pendiente</th>
              </thead><?php $acum=0; ?>
                      <tbody>
                        @foreach($articulout as $det)
						<?php $rec=$ent=0; $cntb=0; ?>
                        <tr >  
                          <td>{{$det->nombre}}</td>
                          <td>@foreach($deboin as $de) <?php
						  if($de->idarticulo==$det->idarticulo){ $ent=$de->cntagg; echo $de->cntagg;  } ?> @endforeach </td>
						  <td> @foreach($deboout as $de2) <?php
						  if($de2->idarticulo==$det->idarticulo){ $rec=$de2->cntagg; echo $de2->cntagg; }?> @endforeach</td>
                       <td><?php $cntb=$ent-$rec; echo ($cntb)." "; ?></td>
						<td><a href="" data-target="#rdebo-{{$det->iddetalle}}" data-toggle="modal"><button class="btn btn-success btn-xs">Recep.</button></a></td>
                        </tr>
					@include('almacen.deposito.modal4')
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