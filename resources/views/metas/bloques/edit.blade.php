@extends ('layouts.admin')
@section ('contenido')
@include('metas.bloques.modal')
	<div class="row">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>Editar Bloque: {{ $bloque->descripcion}}</h3>
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
			{!!Form::model($bloque,['method'=>'PATCH','route'=>['metas.bloques.update',$bloque->idbloque]])!!}
            {{Form::token()}}
			 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8">
            <div class="form-group">
            	<label for="nombre">Nombre</label>
            	<input type="text" name="nombre" class="form-control"  onchange="conMayusculas(this)"  value="{{$bloque->descripcion}}" >
            </div>
            </div>
			 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
            <div class="form-group">
            	<label for="descripcion">Responsable</label>
            	<input type="text" name="responsable" class="form-control" value="{{$bloque->responsable}}" >
            </div>
            </div>
			 <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
			<div class="form-group">
            	<label for="descripcion">Fecha</label>
            	<input type="text" name="fecha" class="form-control" readonly value="{{$bloque->fecha}}" >
            </div>
            </div>
				<div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                     <div class="form-group">
            	<button class="btn btn-primary" type="submit">Guardar</button>
            	<button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
                </div> 
           {!!Form::close()!!}		

			
            
		</div>
		  <div clas ="row">
                <div class="panel panel-primary">
                <div class="panel-body">
                   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #E6E6E6">
                     
                          <th>Codigo <a href="" data-target="#modalm" data-toggle="modal"><span class="label label-success"><i class="fa fa-fw  fa-plus"> </i></span></a></th>
                          <th>Nombre</th>
                         
              </thead>
                      <tbody>
                        @foreach($detalles as $det)
                        <tr >
                          <td><a href="" data-target="#modal-delete-{{$det->idarticulo}}" data-toggle="modal"><button class="btn btn-danger btn-sm">X</button></a>{{$det->codigo}}</td>
                          <td>{{$det->articulo}}</td>
                                                  
                        </tr>
						@include('metas.bloques.modaldelete')
                        @endforeach
                      </tbody> 
<tfoot><th>Total</th><th>{{$bloque->articulos}}</th></tfoot>					  
                  </table>
                 
                    </div>
                </div>   
               
                </div>
			
				
       </div>
	
@endsection
  @push('scripts')
<script>
$(document).ready(function(){
$("#pidarticulo").change(function(){
	document.getElementById('btnsubmit').style.display="";
	});
	});
	    function conMayusculas(field) {
            field.value = field.value.toUpperCase()
}

</script>
@endpush