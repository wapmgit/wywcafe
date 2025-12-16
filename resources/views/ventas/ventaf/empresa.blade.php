<div class="row">
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4">
		<div align="center">   <img src="{{asset('dist/img/logoempresa.jpg')}}" width="60%" height="80%" title="NKS"></div>
		</div>	
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
		<p><small> Licencia para el expendio de especies ascoholicas</br>
		Codigo de Registro: MAPS-MY-C-C V-066</br>
		N° de Autorizacion: MY-066</br>
		Fecha de Autorizacion: MAYO 2022</p></small>FECHA EMISION: <?php echo date("d-m-Y",strtotime($venta->fecha_emi)); ?>        
	    </div>		
		<div class="col-lg-4 col-sm-4 col-md-4 col-xs-4" style="line-height:72%">
				<p><small> MF-SENIAT</br>
		GRTI-RLA AUTORIZACION N° 10</br>
		SNTA/INTI/GRTI/RLA/SV/AR/ALIC/2022/10</br>
		DE FECHA: 21/09/2022</small></p><label><strong>NOTA DE ENTREGA N° <font size="3">{{$venta->idventa}}</font></strong></label> 
			<?php if($venta->devolu>0){ echo "**Devuelta**";} ?>
		</div>
	</div>  