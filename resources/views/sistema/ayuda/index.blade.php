@extends ('layouts.admin')
@section ('contenido')

      <!-- START ACCORDION & CAROUSEL-->
      <h2 class="page-header">Ayuda</h2>

      <div class="row">
        <div class="col-md-6">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Menus del sistema</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        Registrar Cliente
                      </a>
                    </h4>
                  </div>
                  <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="box-body">
    Desde este modulo se registraran los Clientes del sistema. 1) menu principal Archivo. 2) submenu clientes. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/cliente.png')}}" alt="First slide"></div>
		Se debe indicar los datos que exige el formulario, si se tiene vendedores se debe seleccionar el vendedor para quien estara asignada dicho cliente.<div>
			    <img src="{{asset('imagenes/sistema/ncliente.png')}}" alt="First slide"></div>
				Luego se preciona click en el boton Guardar.
                    </div>
                  </div>
                </div>
                <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                       Registrar Proveedor
                      </a>
                    </h4>
                  </div>
                  <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="box-body">
   Desde este modulo se registraran los Proveedores del sistema. 1) menu principal Archivo. 2) submenu Proveedores. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/proveedor.png')}}" alt="First slide"></div>
		Se debe indicar los datos que exige el formulario.<div>
			    <img src="{{asset('imagenes/sistema/nproveedor.png')}}" alt="First slide"></div>
				Luego se preciona click en el boton Guardar.
                    </div>
                  </div>
                </div>
                <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                   Registrar Vendedor
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThree" class="panel-collapse collapse">
                    <div class="box-body">
   Desde este modulo se registraran los Vendedores del sistema. 1) menu principal Archivo. 2) submenu Vendedores. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/vendedor.png')}}" alt="First slide"></div>
		Se debe indicar los datos que exige el formulario. el porcentaje de Comision aplica para las facturas emitidas por los clientes del vendedor y que estas esten cobradas en su totalidad, el calculo de la comision se basa en el monto total de la venta.<div>
			    <img src="{{asset('imagenes/sistema/nvendedor.png')}}" alt="First slide"></div>
				Luego se preciona click en el boton Guardar.
                    </div>
                  </div>
                </div>
				           <div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThird">
                       Registrar Articulo
                      </a>
                    </h4>
                  </div>
                  <div id="collapseThird" class="panel-collapse collapse">
                    <div class="box-body">
 Desde este modulo se registraran los articulo del inventario en el sistema. 1) menu principal Archivo. 2) submenu Articulos. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/articulo.png')}}" alt="First slide"></div>
		Se debe indicar los datos que exige el formulario. el sistema valida que no exista el codigo indicado, si se posee imagen del articulo se debe indicar la ruta donde se encuentra. si el articulo no aplica para impuesto se debe indicar "cero" 0,el calculo para el precio se defino como precio=Costo+(costo*Impuesto)+utilidad. <div>
			    <img src="{{asset('imagenes/sistema/narticulo.png')}}" alt="First slide"></div>
				Luego se preciona click en el boton Guardar.
                    </div>
                  </div>
                </div>
				               <div class="panel box box-danger">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapsecuatro">
                       Registrar Compra
                      </a>
                    </h4>
                  </div>
                  <div id="collapsecuatro" class="panel-collapse collapse">
                    <div class="box-body">
   Desde este modulo se registraran las Compras del sistema. 1) menu principal Ingresos y Egresos. 2) submenu Compras. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/compra.png')}}" alt="First slide"></div>
		Se deben ingresar los datos que exige el formulario. primero se debe indicar el proveedor a quien se le va a procesar la compra,asi como el numero de documento y numero de control para identificar la compra en el sistema. luego empezamos a registrar los articulos incluidos en la factura de compra, desde el select que muestra la linea de articulos presente en el stock se selecciona el articulo, indicamos la cantidad y el precio de compra luego click en el boton " + " y procedemos a seleccionar el siguiente articulo. <div>
			    <img src="{{asset('imagenes/sistema/compra1.png')}}" alt="First slide"></div>
				Una vez registrados todos los articulos pasamos al desglose de pago de la factura.
		    <img src="{{asset('imagenes/sistema/compra2.png')}}" alt="First slide">
                    </div>
                  </div>
                </div>
				
				               <div class="panel box box-success">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapsecinco">
                       Registrar Venta
                      </a>
                    </h4>
                  </div>
                  <div id="collapsecinco" class="panel-collapse collapse">
                    <div class="box-body">
   Desde este modulo se registraran las ventas en el sistema. 1) menu principal Ingresos y Egresos. 2) submenu Ventas. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/venta.png')}}" alt="First slide"></div>
		Se deben ingresar los datos que exige el formulario. primero se debe indicar el cliente a quien se le va a procesar la venta. luego empezamos a registrar los articulos incluidos en la factura de Venta, desde el select que muestra la linea de articulos presente en el stock se selecciona el articulo, indicamos la cantidad y el precio de venta luego click en el boton " + " y procedemos a seleccionar el siguiente articulo. <div>
			    <img src="{{asset('imagenes/sistema/venta1.png')}}" alt="First slide"></div>
				Una vez registrados todos los articulos pasamos al desglose de pago de la factura.
		    <img src="{{asset('imagenes/sistema/venta2.png')}}" alt="First slide">
                    </div>
                  </div>
                </div>
				<div class="panel box box-primary">
                  <div class="box-header with-border">
                    <h4 class="box-title">
                      <a data-toggle="collapse" data-parent="#accordion" href="#collapseseis">
                       Registrar Ajuste de Inventario
                      </a>
                    </h4>
                  </div>
                  <div id="collapseseis" class="panel-collapse collapse">
                    <div class="box-body">
   Desde este modulo se registraran las ventas en el sistema. 1) menu principal Ingresos y Egresos. 2) submenu Ajuste de Inventario. 3) Boton nuevo.<div>
	    <img src="{{asset('imagenes/sistema/ajuste.png')}}" alt="First slide"></div>
		Se deben ingresar los datos que exige el formulario. primero se debe indicar el concepto del ajuste y el responsable, luego empezamos a registrar los articulos afectados en el ejuste desde el select que muestra la linea de articulos, indicamos el tipo de ajuste cargo para incluir, descargo para excluir y luego  la cantidad. click en el boton agregar y procedemos a seleccionar el siguiente articulo. <div>
			    <img src="{{asset('imagenes/sistema/ajuste1.png')}}" alt="First slide"></div>
				Una vez registrados todos los articulos realizamos click en el boton guardar.
		    
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-6">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">SysVent@s</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1" class=""></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2" class=""></li>
				  <li data-target="#carousel-example-generic" data-slide-to="3" class=""></li>
				<li data-target="#carousel-example-generic" data-slide-to="4" class=""></li>
				<li data-target="#carousel-example-generic" data-slide-to="5" class=""></li>
				<li data-target="#carousel-example-generic" data-slide-to="6" class=""></li>
				</ol>
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="{{asset('imagenes/sistema/compras.png')}}" alt="First slide">
                    <div class="carousel-caption">
                     Manten el control de tus ingresos
                    </div>
                  </div>
                  <div class="item">
                    <img src="{{asset('imagenes/sistema/cobrar.png')}}" alt="Second slide">

                    <div class="carousel-caption">
                     Control de Caja en Ventas
                    </div>
                  </div>
                  <div class="item">
                    <img src="{{asset('imagenes/sistema/busca.jpeg')}}" alt="Third slide">

                    <div class="carousel-caption">
                     Seguimiento a los articulos de tu inventario
                    </div>
                  </div>
				    <div class="item">
                    <img src="{{asset('imagenes/sistema/lista.jpg')}}" alt="Third slide">

                    <div class="carousel-caption">
                     Incrementa tus ganacias
                    </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- END ACCORDION & CAROUSEL-->
@endsection