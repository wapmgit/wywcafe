@extends ('layouts.admin')
@section ('contenido')
	<h2 align="center"> ARTICULOS REGISTRADOS EN EL GRUPO</h2>
  <hr/>
		       <div class="row">
 @include('almacen.categoria.modal')
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Nombre</label>
                   <p>{{$categoria->nombre}}</p>
                    </div>
            </div>
             <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor">Descripcion</label>
                   <p>{{$categoria->descripcion}}</p>
                    </div>
            </div>
			   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">

                 <div class="form-group">
                      <label for="proveedor"></label>
                     <label><button id="repreciar"><a href="" data-target="#modal-calcular-{{$categoria->idcategoria}}" data-toggle="modal">Repreciar Grupo</a></button><label>
                    </div>
            </div>
            </div>
            <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6">
                     
                          <th>Codigo</th>
                          <th>Nombre</th>
                          <th>Costo</th>
                          <th>Precio</th>
                          <th>Stock</th>
                          <th>Monto</th>
              </thead><?php $acumcosto=0; $acumprecio=0; $acum=0; $monto=0;?>
                      <tbody>
                        @foreach($articulos as $det)
                        <tr > <?php $acumcosto=($acumcosto+($det->costo*$det->stock)); $acum=($acum+$det->stock);
						$acumprecio=($acumprecio+$det->precio1); $monto=($monto+($det->stock*$det->precio1)); ?>
                          <td>{{$det->codigo}}</td>
                          <td>{{$det->nombre}}</td>
                          <td>{{$det->costo}}</td>
                          <td>{{$det->precio1}}</td>
                          <td>{{$det->stock}}</td>
                          <td>{{$det->stock*$det->precio1}}</td>
                          
                        </tr>
                        @endforeach
                      </tbody>   {{$articulos->render()}}
					  <tr><td colspan="2">Total: </td><td><strong><?php echo number_format($acumcosto, 2,',','.');?></strong></td>
					  <td><strong><?php echo number_format($acumprecio, 2,',','.');?></strong></td>
					  <td><strong><?php echo number_format($acum, 2,',','.');?></strong></td>
					  <td><strong><?php echo number_format($monto, 2,',','.');?></strong></td></tr>
                  </table>
                 
                    </div>
                </div>   
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center"></br>
                     <button type="button" id="imprimir" class="btn btn-primary" data-dismiss="modal">Imprimir</button> 
                    </div>
                </div>                
                </div>
       </div>
	
@endsection
@push ('scripts')
<script>

$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
    document.getElementById('repreciar').style.display="none";
  window.print(); 
  window.location="/almacen/categoria";
    });

});

</script>

@endpush