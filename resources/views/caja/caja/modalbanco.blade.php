
<div class="modal fade modal-slide-in-right  " aria-hidden="true"
role="dialog" tabindex="-1" id="modalbanco">
  	{!!Form::open(array('url'=>'/bancos/banco','method'=>'POST','autocomplete'=>'off','id'=>'formulariocliente','files'=>'true'))!!}
 {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-success">
			<div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h5 class="modal-title">Nueva Cuenta Bancaria	 </h5>
			</div>
		</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Codigo</label>
							<input type="text" name="codigo" required value="" class="form-control" placeholder="codigo...">
						</div>
					</div>
					<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
					  <div class="form-group">
						<label for="saco">Naturaleza</label>
                             <select name="tipo"  class ="form-control">
                              <option value="1">Juridica</option> 
                              <option value="2">Persona Natural</option> 
                              </select>
						</div>
						</div>
						<div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Tipo de Cuenta</label>
							 <select name="tipoc" class ="form-control">
                              <option value="Ahorro">Ahorro</option> 
                              <option value="Corriente">Corriente</option> 
                              </select>
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Nombre</label>
							<input type="text" name="nombre"  required value="" class="form-control" placeholder="Nombre del banco...">
						</div>
					</div>
					
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Titular de la cuenta</label>
							<input type="text" name="titular"  required value="" class="form-control" placeholder="Representante...">
						</div>
					</div>
					<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Numero de Cuenta</label>
							<input type="text" name="cuenta" required value="" class="form-control" placeholder="N° cuenta...">
						</div>
					</div>
					<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Direccion</label>
							<input type="text" name="direccion" id="direccion" required value="" class="form-control" placeholder="Direcion...">
						</div>
					</div>
		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Email</label>
							<input type="text" name="mail" value="" class="form-control" placeholder="email...">
						</div>
					</div>
					<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Telefonos</label>
							<input type="text" name="telefono"  required value="" class="form-control" placeholder="Telefonos...">
						</div>
					</div>
   
							
				</div>  <!-- del row -->

	
			</div>  <!-- del modal body-->
			<div class="modal-success">
			<div class="modal-footer">
			 <div class="form-group">
				<button type="button" class="btn btn-default btn-outline pull-left" data-dismiss="modal">Cerrar</button>
				<button type="submit" id="btn_ncliente" class="btn btn-primary btn-outline pull-right">Confirmar</button>
				</div>
			</div>
				</div>
		</div>
			
	</div>
{!!Form::close()!!}	
			

</div>


  
	
   