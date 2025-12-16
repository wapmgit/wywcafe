@extends ('layouts.admin')
@section ('contenido')
<?php $mingreso=$megreso=0; $bc=0;?>
<?php
$ceros=5;
function add_ceros($numero,$ceros,$bco) {
  $numero=$numero+1;
$digitos=strlen($numero);
  $recibo=" ";
  for ($i=0;$i<8-$digitos;$i++){
    $recibo=$recibo."0";
  }
return $insertar_ceros = $bco.$recibo.$numero;
};
$idv=0;
$fserver=date('Y-m-d');
?> 
 @foreach ($contador as $p)
              <?php  $idv=$p -> id_mov; ?> 
			  @endforeach
<div class="row">             
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
<h3>MODULO DE CAJA</h3>
<table class="table table-striped table-bordered table-condensed table-hover">
  <tr>
     <td><label>Codigo:</label> {{$banco->codigo}} <?php $bco=$banco->codigo; ?>  </td> 
    <td><label>Nombre Caja:</label> {{$banco->nombre}} </td>
    <td><label>Simbolo:</label> {{$banco->simbolo}} </td>

</table>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="center">
<table class="table table-striped table-bordered table-condensed table-hover">
  <tr>
                               @foreach ($movimiento as $mov)
                               <?php 
                                  if ($mov->tipo_mov == "N/C") $mingreso=$mingreso+$mov->monto;   
                                  if ($mov->tipo_mov == "N/D") $megreso=$megreso+$mov->monto; ?>
                              @endforeach 
     <td align="center"><label>Ingresos:</label> <h4><?php echo number_format( $mingreso, 2,',','.'); ?></h4></td>
    <td align="center"><label>Egresos:</label> <h4><?php echo number_format( $megreso, 2,',','.'); ?></h4> </td>
    <td align="center"><label> Saldo:</label>{!! Form::open(array('url'=>'/caja/movimientos','method'=>'GET','autocomplete'=>'off','role'=>'search')) !!}
<div class="form-group">
<input type="hidden" class="form-control" name="searchText"  value="">
  </div>
  <div class="form-group">
   <input type="hidden" class="form-control" name="searchText2" value="">
  </div>    <div class="form-group">
  <input type="hidden" name="id" value="{{$banco->codigo}} " >
</div>
  <div class="input-group">
  
    <label><button type="submit" class="btn btn-primary"><h4><?php echo number_format( ($mingreso-$megreso), 2,',','.'); ?> </h4></button></label>
  
    </div>
{{Form::close()}}
 </td>
  </tr>
</table>
</div>

<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
  @include('caja.caja.modalcredito')
    <div class="title-card-categoria-app"><h4 align="center">NOTA CREDITO</h4></div>
      <div class="card-categoria-app" align="center">     
      <a href="" data-target="#modalcredito" data-toggle="modal">
        <img  src="/img/caja/compras.png" width="80" height="80">
        <div class="footer-card-categoria-app"></div>   </a>
        <a href="/caja/consulta/CRE{{$banco->idcaja}}"><img  src="/img/caja/lupa.png"  width="25" height="25"></a>
    </div> <!-- final de la card -->
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
   @include('caja.caja.debito')
   <div class="title-card-categoria-app"><h4 align="center">NOTA DEBITO</h4></div>
      <div class="card-categoria-app" align="center">     
      <a href="" data-target="#modaldebito" data-toggle="modal">
        <img  src="/img/caja/compras.png" width="80" height="80">
        <div class="footer-card-categoria-app"></div>   </a>
        <a href="/caja/consulta/DEB{{$banco->idcaja}}"><img  src="/img/caja/lupa.png"  width="25" height="25"></a>
    </div> <!-- final de la card -->
</div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" >
    <div class="title-card-categoria-app"><h4 align="center">DETALLE SALDO</h4></div>
      <div class="card-categoria-app" align="center">     
      <a href="/caja/detalle/{{$banco->idcaja}}">
        <img  src="/img/caja/compras.png" width="80" height="80">
        <div class="footer-card-categoria-app"></div>   </a>

    </div> <!-- final de la card -->
</div>
</div>
@endsection