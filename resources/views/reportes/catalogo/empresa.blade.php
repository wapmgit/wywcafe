<div class="row">
		<div class="col-lg-8 col-sm-8 col-md-8 col-xs-8">
            	 <div class="form-group">
            			<h1 >{{$empresa->nombre}}</h1>
						<label >{{$empresa->rif}}</label></br>	
						<label >{{$empresa->direccion}}. Tel: {{$empresa->telefono}}</label>
            	 </div>  
	    </div>
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
				<div align="center">  
				<img class="img-thumbnail" src="{{ asset('dist/img/'.$empresa->logo)}}" width="60%" height="90%" title="NKS"></div>
	    </div>
</div>