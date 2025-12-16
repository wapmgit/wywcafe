<div class="modal fade modal-slide-in-right" aria-hidden="true"
role="dialog" tabindex="-1" id="modaldetallenc" >

	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" 
				aria-label="Close">
                     <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Detalle de Documento : <label id="det_documentonc"></label></h4>
			</div>
			<div class="modal-body">
		       <table id="detallenc" class="table table-striped table-bordered table-condensed table-hover">
                      <thead style="background-color: #54b279">
                          <th>Aplicado</th>
                          <th>Monto</th>
						  <th>Fecha</th>
                          <th>Usuario</th>
                          </thead>
                   
                      <tbody id="bodytable"></tbody>
					  <tfoot> <th colspan="8"> <div align="center"> Total Documento: <label id="det_totalnc"></label> </div></th> </tfoot>
                  </table>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn-cerrarnc" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>


</div>
