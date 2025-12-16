@extends ('layouts.admin')
@section ('contenido')
@include('reportes.ventas.empresa')
<div class="panel panel-primary">
<div class="panel-body">
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
  
        <h3 align="center">TASA DE CAMBIO</h3>
</div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" align="center">  
<label>Monto actual Bs.</label></br><label><h3>{{ $empresa->tc}}</h3></label>
  </div>  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" align="center">  
<label>Monto actual peso</label></br><label><h3>{{ $empresa->peso}}</h3></label>
  </div>
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" align="center">  
    {!!Form::open(array('url'=>'/sistema/tasa/act/','method'=>'POST','autocomplete'=>'off','id'=>'actasa'))!!}
            {{Form::token()}}
            <div class="form-group"><label>Actualizar Bs.</label></br>
    <label><input type="number" name="act_tasa" step="0.0001" value="{{ $empresa->tc}}"></label>
			</div>
      </div>
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12" align="center">  
            <div class="form-group"><label>Actualizar Peso</label></br>
    <label><input type="number" step="0.0001" name="act_peso" value="{{ $empresa->peso}}"></label>
        </div>
      </div>
  </div>

<div class="modal-footer" >
       <div class="form-group">

          <input name="_token" value="{{ csrf_token() }}" type="hidden" ></input>
        <button type="submit" id="" class="btn btn-primary" >Confirmar</button> 
        </div>
      </div>  {!!Form::close()!!}   
  </div>
</div>

@push ('scripts')
<script>
$(document).ready(function(){
    $("#Cenviar").on("click",function(){
      
         var form1= $('#actasa');
        var url1 = form1.attr('action');
        var data1 = form1.serialize();
  
    $.post(url1,data1,function(result){  
      var resultado=result;
          console.log(resultado); 
     $("#actasa")[0].reset();
        });
  
          });

});

</script>

@endpush
         
@endsection