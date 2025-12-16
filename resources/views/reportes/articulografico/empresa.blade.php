<div class="row">

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
						<label >{{$empresa->direccion}}</label></br>
            			<label >{{$empresa->rif}}</label>	
            	 </div>  
	    </div>	<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
		    <h3 align="center">REPORTE DE VENTAS POR ARTICULO</h3> 
			<?php if($busqueda){?><h6 align="center"> Ruta: {{$busqueda->nombre}}</h6><?php } ?>
			<?php if($rutasu){?><h6 align="center"> Rutas: {{$rutasu}}</h6><?php } ?>
			</div>
</div>