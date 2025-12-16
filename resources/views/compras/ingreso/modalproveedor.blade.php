
<div class="modal modal-primary" aria-hidden="true"
	role="dialog" tabindex="-1" id="modalproveedor">
  	{!!Form::open(array('url'=>'/compras/proveedor','method'=>'POST','autocomplete'=>'off','id'=>'formularioproveedor','files'=>'true'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header ">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Nuevo Proveedor </h3>
			</div>

			<div class="modal-body">
				<div class="row">
					<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Nombres o Razon</label>
							<input type="text" name="cnombre" id="cnombre" required onchange="conMayusculas(this)" value="" class="form-control" placeholder="Nombre...">
						</div>
					</div>
					<div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
						 <div class="form-group">
							    <label for="nombre">Contacto</label>
							<input type="text" name="contacto"  onchange="conMayusculas(this)" value="" class="form-control" placeholder="Nombre Contacto...">
						</div>
					</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <div class="form-group">
                    <label for="rif">Rif</label>
                    <input type="text" name="rif" id="rif" class="form-control" placeholder="V00000000">
                </div>
            </div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
					  <div class="form-group">
					<label for="descripcion">Telefono</label>
					<input type="text" name="ctelefono" class="form-control" placeholder="0000-000000">
				</div>
				</div>

				<div class="col-lg-12 col-sm-6 col-md-12 col-xs-12">
					 <div class="form-group">
				 <label for="direccion">Direccion</label>
				<input type="text" name="cdireccion" class="form-control" placeholder="Direccion...">
			   </div>
				</div>
				</div>  <!-- del row -->

	
			</div>  <!-- del modal body-->
		
			<div class="modal-footer">
			 <div class="form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="button" class="btn btn-primary" id="Nenviar2">Confirmar</button>
				</div>
			</div>
		
		</div>
			
	</div>

			
	{!!Form::close()!!}		
</div>

@push('scripts')
  <script>
$(document).ready(function(){
document.getElementById('Nenviar2').style.display="none";
 
		      $("#rif").on("change",function(){
         var form2= $('#formularioproveedor');
        var url2 = '/proveedores/proveedor/validar';
        var data2 = form2.serialize();
    $.post(url2,data2,function(result2){  
      var resultado2=result2;
         console.log(resultado2); 
         rows=resultado2.length; 
      if (rows > 0){
            var nombre=resultado2[0].nombre;
          var rif=resultado2[0].rif; 
          var telefono=resultado2[0].telefono;   
          alert ('Rif ya existe!!, Nombre: '+nombre+' Rif: '+rif+' Telefono: '+telefono);   
           $("#rif").val("");
}    else{
	document.getElementById('Nenviar2').style.display="";
}
          });
     });
});
  function conMayusculas(field) {
            field.value = field.value.toUpperCase();
}

  </script>
	@endpush
   