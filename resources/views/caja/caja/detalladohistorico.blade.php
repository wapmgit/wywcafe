@extends ('layouts.admin')
<?php $mostrar=0; ?>
  @if(Auth::user()->nivel=="A")
@section ('contenido')
<?php $mostrar=1; ?> 
 <?php  $ctra= 0; $cche=0; $cdeb=0; $credito=0; $contado=0; $count=0; $ban=0; $tcompras=0;$mingreso=0;$megreso=0;?>
 @foreach ($banco as $b) <?php $ban=$b->idmoneda; ?>
	@endforeach 
 @include('caja.caja.searchm')
            <!-- /.box-body -->
@endsection
@endif
<?php $acumdebe=0;$acumhaber=0;$efe=0;$deb=0;$che=0;$tra=0;$banco=0;
$cefe=0;
?>      

@section('reporte')
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

 @include('reportes.compras.empresa')
    <h3 align="center">REPORTE DETALLADO</h3>
	@foreach ($saldo as $mov)
                               <?php 

                                  if ($mov->tipo_mov == "N/C"){ $mingreso=$mingreso+$mov->tmonto;   }
                                  if ($mov->tipo_mov == "N/D"){ $megreso=$megreso+$mov->tmonto; }
?>
                              @endforeach 
<label ></label>
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
          <th>FECHA</th>      
          <th>NUMERO</th>     
          <th>DESCRIPCION</th>  
          <th>DEBE</th>  
          <th>HABER</th>
		      <th>SALDO</th>		         
        </thead>
		        <?php $ctra= 0; $cche=0; $cdeb=0;$i=0; $saldoanterior=0; $credito=0; $contado=0; $count=0; $tcompras=0;?>
		<tr><td></td><td></td><td></td><td></td><td></td><td><?php $saldoanterior=($mingreso-$megreso);  echo number_format( ($mingreso-$megreso), 2,',','.'); ?></td></tr>
               @foreach ($movimiento as $q) 
        <tr >@include('caja.caja.modalelimina')
          <td><?php  echo $fecha=date_format(date_create($q->fecha_mov),'d-m-Y');?></td> 
        <td><?php if( $q->tipodoc=='VENT'){?>
				<a href="detalleventa/{{$ban}}_{{$q->iddocumento}}">{{$q->numero}}</a>
				<?php }else{ echo $q->numero; }
		?></td>
        <td>{{ $q->concepto }}</td>  
          <td>	  
		<?php      
         if ($q->tipo_mov == "N/D")  
		 { $acumdebe=$acumdebe+ $q->monto;  echo $q->tipo_mov."  ->  ".number_format($q->monto, 2,',','.'); ?>
	 <a href="" data-target="#modal-{{$q->id_mov}}" data-toggle="modal"><i class="fa fa-trash-o" style="color:red"></i></a> <?php  }     
 ?></td> 
 		  <td><?php 
             if ($q->tipo_mov == "N/C"){ $acumhaber=$acumhaber+ $q->monto;   echo $q->tipo_mov."  ->  ".number_format($q->monto, 2,',','.'); ?> <a href="" data-target="#modal-{{$q->id_mov}}" data-toggle="modal"><i class="fa fa-trash-o" style="color:red"></i></a> <?php }	  
		 ?> </td>
          <td><?php $credito=(($acumhaber+$saldoanterior) - $acumdebe);
echo number_format($credito, 2,',','.');
		  ?></td>

        </tr>
 
        @endforeach
   <tr><td></td><td></td><td></td><td>Total: <strong> <?php echo number_format($acumdebe, 2,',','.');?></strong></td>
  <td>Total:<strong><?php echo number_format($acumhaber, 2,',','.');?></strong></td> <td><?php echo "<strong>".number_format($credito, 2,',','.')."</strong>"; ?> </td></tr>  
      </table>
  </div>
	          <label>Usuario: {{ Auth::user()->name }}</label>                         
                  		</div>
             
                     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                    <div class="form-group" align="center">
                          <a ><button class="btn  pull-right" id="imprimir">Imprimir</button></a>
          <a href="/caja/caja/<?php echo $ban;?>" id="regresar"><button class="btn  pull-left" >Regresar</button></a> 

                    </div>
                </div>          
@push ('scripts')
<script>
$(document).ready(function(){
    $('#imprimir').click(function(){
  //  alert ('si');
  document.getElementById('imprimir').style.display="none";
  window.print(); 
  window.location="/caja/caja/<?php echo $ban;?>"
    });

});

</script>

@endpush
@endsection