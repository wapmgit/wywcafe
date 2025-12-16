<div class="row">

		<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<label >{{$empresa->nombre}}</label></br>
            			<label >{{$empresa->rif}}</label>	
            	 </div>  
	    </div>
				<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            	 <div class="form-group">
            			<h2 align="center">  PEDIDO 00{{$empresa->idempresa}}-{{$venta->num_comprobante}} <?php if($venta->devolu==1){ echo "*Anulado*";} ?></h2>
            	 </div>  
	    </div>
</div>