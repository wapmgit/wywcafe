<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalm">
{!!Form::open(array('url'=>'bloques/addarticulo','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Agregar Articulo a Bloque  {{$bloque->idbloque}}</h4>
			</div>
			<div class="modal-body">
			<table align="center" width="100%">
			<tr><td colspan="2">     <label>Articulo</label>
			<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true" >
                              <option value="1000" selected="selected">Seleccione..</option>
                             @foreach ($articulos as $articulo)
                              <option value="{{$articulo -> idarticulo}}">{{$articulo -> articulo}}</option>
                             @endforeach
                              </select></td></tr>
			</table>
			</div>
			<div class="modal-footer">
				<input type="hidden" value="{{$bloque->idbloque}}" name="idbloque"  class ="form-control" >
				<button style="display:none" type="submit" id="btnsubmit" class="btn btn-default">Agregar</button>
				
			</div>
				
		</div>
	</div>{{Form::Close()}}
</div>