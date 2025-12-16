	<div class="col-sm-12 invoice-col">
				NOMBRES O RAZÓN SOCIAL: <b>{{$empresa->nombre}}</b>
                  <address>
                  DOMICILIO FISCAL:  <b>{{$empresa->direccion}} </b><br>
				 RIF:  <strong>{{$empresa->rif}}</strong><br>
                 ENTRADAS Y SALIDAS CORRESPONDIENTES AL PERIODO:  <b> del <?php echo date("d-m-Y",strtotime($searchText)); ?> al <?php echo date("d-m-Y",strtotime($searchText2)); ?> </b><br>
                  </address>
	</div>
             
