@extends ('layouts.admin')

@section ('reporte')
<div class="row">
<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
      <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
          <th>Id venta</th>
          <th>comprobante</th>
          <th>Monto</th>
          <th>efectivo</th>
          <th>debito</th>
          <th>cheque</th>
          <th>transferencia</th>
        </thead>
              
        @endforeach
      </table>
    </div>
  
  </div>
  </div>
  </div>
</div>
@endsection 

