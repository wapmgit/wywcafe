@extends ('layouts.admin')
@section ('contenido')

<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
        <h3 align="center">REPORTE DE INVENTARIO VALORIZADO</h3>

      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead style="background-color: #E6E6E6">
					<th>Id Articulo</th>
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Existencia</th>
					<th>costo</th>
          <th>Valorizado en costo</th>
          <th>Precio</th>
          <th>Valorizado en precio</th>
					
				</thead><?php $count=0; $costoacum=0; $precioacum=0;?>
               @foreach ($lista as $q)
				<tr> <?php $count++; 
        $costoacum=$q->costo*$q->stock+$costoacum;
        $precioacum=$q->stock*$q->precio1+$precioacum;
         ?> 
					<td>{{ $q->idarticulo}}</td>
          <td>{{ $q->codigo}}</td>
					<td>{{ $q->nombre}}</td>
					<td>{{ $q->stock}}</td>
          <td>{{ $q->costo}}</td>
          <td>{{ $q->costo*$q->stock}}</td>
					<td>{{$q->precio1}}</td>
					<td>{{$q->stock*$q->precio1}}</td>	
				</tr>

				@endforeach
        <tr style="background-color: #A9D0F5"><td><?php echo "Articulos:".$count; ?></td><td></td><td></td><td></td><td></td><td><?php echo $costoacum; ?></td><td></td><td><?php echo $precioacum; ?></td></tr>
			</table>
		</div>
  
  </div>
  </div>
  </div>


         
@endsection