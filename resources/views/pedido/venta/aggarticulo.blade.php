<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modalm">
{!!Form::open(array('url'=>'/pedido/addarticulo','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Agregar Articulo a Pedido  {{$venta->num_comprobante}}</h4>
			</div>
			<div class="modal-body">
			<table align="center" width="100%">
			<tr><td colspan="2">     <label>Articulo</label>
			<select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true" >
                              <option value="1000" selected="selected">Seleccione..</option>
                             @foreach ($articulos as $articulo)
                              <option value="{{$articulo -> idarticulo}}_{{$articulo -> stock}}_{{$articulo -> precio_promedio}}_{{$articulo -> precio2}}_{{$articulo -> costo}}">{{$articulo -> articulo}}</option>
                             @endforeach
                              </select></td></tr>
			<tr><td><label>Cantidad:</label>
			<input type="number" name="pcantidad" id="pcantidad" class ="form-control" step="0.01" min="0.25" placeholder="Cantidad"></td>
			<td><label>Precio:</label> <input type="number" name="pprecio_venta" id="pprecio_venta" step="0.001" class ="form-control" placeholder="Precio de Venta" ></td></tr>
			</table>
			</div>
			<div class="modal-footer">
				<input type="hidden" value="0" name="pf" id="pf" class ="form-control" step="0.001" class ="form-control">
				<input type="hidden" value="0" name="pcostoarticulo" id="pcostoarticulo" step="0.001" class ="form-control" >
				<input type="hidden" value="0" name="idarticulo" id="idarticulo" class ="form-control" >
				<input type="hidden" value="{{$venta->idventa}}" name="idventa"  class ="form-control" >
				<button style="display:none" type="submit" id="btnsubmit" class="btn btn-default">Agregar</button>
				
			</div>
				
		</div>
	</div>{{Form::Close()}}
</div>