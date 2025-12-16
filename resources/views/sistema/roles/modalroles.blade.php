

<div class="modal  modal-default" aria-hidden="true"
role="dialog" tabindex="-1" id="roles{{$q->id}}">

 	{!!Form::open(array('url'=>'/sistema/actroles','method'=>'POST','autocomplete'=>'off','id'=>'formulario','files'=>'true'))!!}
            {{Form::token()}}
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h3 class="modal-title">Actualizar Privilegios de Usuario  </h3>
			</div>
			<div class="modal-body">
<p align="center">Usuario: <label>{{ $q->name}} </label> @if($q->nivel=="L") *Usuario Limitado para Ventas* @endif 
				</p>
        <div class="row">
		<div class="col-md-12">

						<div class="nav-tabs-custom">
							<ul class="nav nav-tabs">
							<li class="active">
							<a href="#tab_1{{$q->id}}" data-toggle="tab">Archivo</a></li>
							<li><a href="#tab_2{{$q->id}}" data-toggle="tab">Ingresos y Egresos</a></li>
							<li><a href="#tab_3{{$q->id}}" data-toggle="tab">Informes</a></li>
							<li><a href="#tab_4{{$q->id}}" data-toggle="tab">Caja</a></li>
							<li><a href="#tab_5{{$q->id}}" data-toggle="tab">Comisiones y Metas</a></li>
							<li><a href="#tab_6{{$q->id}}" data-toggle="tab">Sistema</a></li>
							<li><a href="#tab_7{{$q->id}}" data-toggle="tab">Impuestos</a></li>
							</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="tab_1{{$q->id}}">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						 <div class="form-group">
						 <input type="hidden" value="{{$q->idrol}}" name="rol"></input>
						 <label>Crear Cliente: </label><label>
						  <input type="checkbox" name="op1" class="minimal" @if($q->newcliente==1) checked @endif ></label>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Editar Cliente: </label><label>
					  <input type="checkbox" name="op2" class="minimal" @if($q->editcliente==1) checked @endif ></label>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Estado de Cuenta Cliente: </label><label>
					  <input type="checkbox" name="op39" class="minimal" @if($q->edocta==1) checked @endif ></label>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Activar/Desactivar Cliente: </label><label>
					  <input type="checkbox" name="op40" class="minimal" @if($q->actcliente==1) checked @endif ></label>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Proveedor:</label><label>
					  <input type="checkbox" name="op3" class="minimal" @if($q->newproveedor==1) checked @endif ></label>

					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Editar Proveedor: </label><label>
					  <input type="checkbox" name="op4" class="minimal" @if($q->editproveedor==1) checked @endif ></label>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Estado de Cuenta Proveedor: </label><label>
					  <input type="checkbox" name="op42" class="minimal" @if($q->edoctap==1) checked @endif ></label>
					</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Vendedor: </label><label>
					  <input type="checkbox" name="op5" class="minimal" @if($q->newvendedor==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Editar Vendedor: </label><label>
					  <input type="checkbox" name="op6" class="minimal"@if($q->editvendedor==1) checked @endif ></label>

					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Activar/Desactivar Vendedor: </label><label>
					  <input type="checkbox" name="op43" class="minimal" @if($q->actvendedor==1) checked @endif ></label>
					</div>
					</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Articulo: </label><label>
					  <input type="checkbox" name="op7" class="minimal" @if($q->newarticulo==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Editar Articulo: </label><label>
					  <input type="checkbox" name="op8" class="minimal" @if($q->editarticulo==1) checked @endif ></label>
					</div>
				</div>
							</div>
							<div class="tab-pane" id="tab_2{{$q->id}}">
								  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Compras: </label><label>
					  <input type="checkbox" name="op9" class="minimal" @if($q->crearcompra==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Anular Compras: </label><label>
					  <input type="checkbox" name="op10" class="minimal" @if($q->anularcompra==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Importar N/E a Compras: </label><label>
					  <input type="checkbox" name="op44" class="minimal" @if($q->importarne==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Venta: </label><label>
					  <input type="checkbox" name="op11" class="minimal" @if($q->crearventa==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Anular Venta: </label><label>
					  <input type="checkbox" name="op12" class="minimal" @if($q->anularventa==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Forma Libre: </label><label>
					  <input type="checkbox" name="op45" class="minimal" @if($q->crearfl==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Importar Docs. a Formal LIbre: </label><label>
					  <input type="checkbox" name="op46" class="minimal" @if($q->importarfl==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Anular Formal LIbre: </label><label>
					  <input type="checkbox" name="op47" class="minimal" @if($q->anularfl==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Factura Externa: </label><label>
					  <input type="checkbox" name="op48" class="minimal" @if($q->crearfe==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Editar Factura Externa: </label><label>
					  <input type="checkbox" name="op49" class="minimal" @if($q->editarfe==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Anular Factura Externa: </label><label>
					  <input type="checkbox" name="op50" class="minimal" @if($q->anularfe==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Gasto: </label><label>
					  <input type="checkbox" name="op13" class="minimal" @if($q->creargasto==1) checked @endif ></label>

					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Anular Gasto: </label><label>
					  <input type="checkbox" name="op14" class="minimal"@if($q->anulargasto==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Abonar Compras: </label><label>
					  <input type="checkbox" name="op15" class="minimal" @if($q->abonarcxp==1) checked @endif ></label>			
					</div>
				</div>		
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Ajuste: </label><label>
					  <input type="checkbox" name="op16" class="minimal" @if($q->crearajuste==1) checked @endif ></label>			
					</div>
				</div>		
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Abonar Gastos: </label><label>
					  <input type="checkbox" name="op17" class="minimal" @if($q->abonargasto==1) checked @endif ></label>			
					</div>
				</div>					
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Abonar Ventas: </label><label>
					  <input type="checkbox" name="op18" class="minimal" @if($q->abonarcxc==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Pedidos: </label><label>
					  <input type="checkbox" name="op19" class="minimal" @if($q->crearpedido==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Anular Pedido: </label><label>
					  <input type="checkbox" name="op20" class="minimal" @if($q->anularpedido==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Importar Pedido: </label><label>
					  <input type="checkbox" name="op21" class="minimal" @if($q->importarpedido==1) checked @endif ></label>
					</div>
				</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Modificar Pedido: </label><label>
					  <input type="checkbox" name="op22" class="minimal" @if($q->editpedido==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Acceso Control Vacios: </label><label>
					  <input type="checkbox" name="op51" class="minimal" @if($q->vacios==1) checked @endif ></label>
					</div>
				</div>
							</div>

			<div class="tab-pane" id="tab_3{{$q->id}}">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Resumen de Ventas: </label><label>
						<input type="checkbox" name="op23" class="minimal" @if($q->rventas==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Corte de Caja: </label><label>
						<input type="checkbox" name="op24" class="minimal" @if($q->ccaja==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Detalle de Ingresos: </label><label>
						<input type="checkbox" name="op25" class="minimal" @if($q->rdetallei==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Cuentas por Cobrar: </label><label>
						<input type="checkbox" name="op26" class="minimal" @if($q->rcxc==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Resumen de Compras: </label><label>
						<input type="checkbox" name="op27" class="minimal" @if($q->rcompras==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Detalle de Pagos: </label><label>
						<input type="checkbox" name="op28" class="minimal" @if($q->rdetallec==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Cuentas por Pagar: </label><label>
						<input type="checkbox" name="op29" class="minimal" @if($q->rcxp==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Inventario Valorizado: </label><label>
						<input type="checkbox" name="op58" class="minimal" @if($q->rinventario==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Lista de Precio: </label><label>
						<input type="checkbox" name="op55" class="minimal" @if($q->listap==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Resumen Gerencial: </label><label>
						<input type="checkbox" name="op56" class="minimal" @if($q->resumeng==1) checked @endif ></label>
						</div>
						</div>
							</div>
			<div class="tab-pane" id="tab_4{{$q->id}}">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Banco: </label><label>
					  <input type="checkbox" name="op30" class="minimal" @if($q->newbanco==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Acceso Banco: </label><label>
					  <input type="checkbox" name="op31" class="minimal" @if($q->accesobanco==1) checked @endif ></label>
					</div>
				</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Estado de Cuenta: </label><label>
					  <input type="checkbox" name="op57" class="minimal" @if($q->edoctabanco==1) checked @endif ></label>
					</div>
				</div>
							</div>
			<div class="tab-pane" id="tab_5{{$q->id}}">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Crear Comision: </label><label>
					  <input type="checkbox" name="op32" class="minimal" @if($q->comision==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Pagar Comision: </label><label>
					  <input type="checkbox" name="op33" class="minimal" @if($q->pcomision==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Metas Empresa: </label><label>
					  <input type="checkbox" name="op34" class="minimal" @if($q->metae==1) checked @endif ></label>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					 <div class="form-group">
					 <label>Metas Vendedor: </label><label>
					  <input type="checkbox" name="op35" class="minimal" @if($q->metav==1) checked @endif ></label>
					</div>
				</div>
							</div>
			<div class="tab-pane" id="tab_6{{$q->id}}">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Actualizar tasa: </label><label>
						<input type="checkbox" name="op36" class="minimal" @if($q->acttasa==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Actualizar Roles: </label><label>
						<input type="checkbox" name="op37" class="minimal" @if($q->actroles==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Actualizar Contraseñas: </label><label>
						<input type="checkbox" name="op38" class="minimal" @if($q->updatepass==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Sincronizar datos : </label><label>
						<input type="checkbox" name="op41" class="minimal" @if($q->web==1) checked @endif ></label>
						</div>
						</div>
							</div>
			<div class="tab-pane" id="tab_7{{$q->id}}">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Libro de Ventas: </label><label>
						<input type="checkbox" name="op52" class="minimal" @if($q->lventas==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Libro de Compras: </label><label>
						<input type="checkbox" name="op53" class="minimal" @if($q->lcompras==1) checked @endif ></label>
						</div>
						</div>
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="form-group">
						<label>Valorizado: </label><label>
						<input type="checkbox" name="op54" class="minimal" @if($q->valorizado==1) checked @endif ></label>
						</div>
						</div>
							</div>	
						</div>

						</div>

					</div>

        

	
			</div>
			<div class="modal-footer">
			 <div class="form-group">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				<button type="submit" class="btn btn-primary" id="Nenviar">Confirmar</button>
				</div>
			</div>
			</div>
			
		</div>
	
		{!!Form::close()!!}		

</div>
