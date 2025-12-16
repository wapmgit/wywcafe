@extends ('layouts.admin')
@section ('contenido')
<div class="row">
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">	
<h3>Registros  <a href="deposito/create">	@if($rol->vacios==1)<button class="btn btn-info">Nuevo</button>@endif</a></h3>
</div>
        <div class="col-lg-4 col-xs-12">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
			  <h3> </h3>
              <p align="center">DEPOSITO: 		 
			  <label> {{$cntvacios->ingresos-$cntvacios->egresos}}</label></p>
	
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
             @if($rol->vacios==1)<a href="/deposito/deposito" class="small-box-footer">Acceder <i class="fa fa-arrow-circle-right"></i></a>@endif
          </div>
        </div>
</div>
	<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">	
		@include('almacen.deposito.search')
	</div>

 <?php $acumdebe=$acumdebo=0; ?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-condensed table-hover">
				<thead>
					<th>Id</th>
					<th>Cedula</th>
					<th>Nombre</th>
					<th>Debe</th>
					<th>Debo</th>
					<th>Opciones</th>
				</thead>
               @foreach ($categorias as $cat) <?php $acumdebe=$cat->debe+$acumdebe; $acumdebo=$cat->debo+$acumdebo; ?>
				<tr>
					<td>{{ $cat->id_deposito}}</td>
					<td>{{ $cat->identificacion}}</td>
					<td>{{ $cat->nombre}}</td>
					<td align="center">{{ $cat->debe}} 
					</td>
					<td align="center">{{ $cat->debo}}
					</td>
					<td>
					 <a href="/almacen/deposito/gestion/{{$cat->id_deposito}}"><button class="btn btn-success btn-xs"> Gestion</button></a>
                        <a href="{{URL::action('DepositoController@show',$cat->id_deposito)}}"><button class="btn btn-primary btn-xs">Ver Historico</button></a>
					</td>
				</tr>			
				@endforeach
				<tr><td colspan="3"> Total</td><td align="center"><?php echo $acumdebe; ?></td><td align="center"><?php echo $acumdebo; ?></td></tr>
			</table>
		</div>
		{{$categorias->render()}}
	</div>

</div>
@endsection