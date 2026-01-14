<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>NKS Softare | www.nks.com.ve</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
	
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
	  <link rel="stylesheet" href="{{asset('js/table.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/title.png')}}">
    <link rel="shortcut icon" href="{{asset('img/nks.ico')}}">

  </head>
     @if(Auth::user()->nivel=="A")
  <body class="hold-transition skin-blue sidebar-mini"> 
@else
	   <body class="hold-transition skin-blue sidebar-collapse">
 @endif
    <div class="wrapper" >

      <header class="main-header">

        <!-- Logo -->
        <a href="#" class="logo"  style="background-color:  #9c5c29">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SV</b>W</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SysVent@s&reg; Web</b></span>	
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation"  style="background-color:  #9c5c29">
          <!-- Sidebar toggle button-->
		    @if(Auth::user()->nivel=="A")
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
	  @endif
            <span class="sr-only">Navegación</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              
    
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
		  <!--     <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-dollar "></i>
              <span class="label label-warning">10</span>
            </a>-->
        
          </li>
		<li class="dropdown notifications-menu">
        <label>Usuario: <?Php  $foto=Auth::user()->foto; ?></label>
          </li>

              <!-- User Account: style can be found in dropdown.less -->
               <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('dist/img/'.$foto)}}" class="user-image" alt="User Image">
              <span class="hidden-xs"> {{ Auth::user()->name }}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('dist/img/'.$foto)}}" class="img-circle" alt="User Image">

                <p>
                   {{ Auth::user()->name }}
                  <small>Miembro desde {{ Auth::user()->created_at }}</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="/reportes/cortecaja">C. Caja</a>
                  </div>
				     <div class="col-xs-4 text-center">
                    <a href="/ventas/venta/create">Facturar</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="/ventas/ventacaja">Ventas</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                  <!--   <a href="#" class="btn btn-default btn-flat">Opciones</a>-->
                </div>
                    <div class="pull-right">
                      <a href="{{url('/logout')}}" class="btn btn-default btn-flat">Cerrar Sesión</a>
                    </div>
                  </li>
                </ul>
              </li>
              
            </ul>
          </div>

        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
	
        <section class="sidebar">
          <!-- Sidebar user panel -->
           <div class="user-panel">
        <div class="pull-left image">
          <img src="{{asset('dist/img/'.$foto)}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{ Auth::user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form 
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
   search form -->
                    
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu ">
            <li class="header">MENÚ DE NAVEGACIÓN</li>
       
            <li class="treeview">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Archivo</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
			  
                <li><a href="/pacientes/paciente"><i class="fa fa-circle-o"></i> Clientes</a></li>
                <li><a href="/proveedores/proveedor"><i class="fa fa-circle-o"></i> Proveedores</a></li>
				<li><a href="/vendedor/vendedor"><i class="fa fa-circle-o"></i> Vendedores</a></li>
                <li><a href="/almacen/categoria"><i class="fa fa-circle-o"></i> Grupos</a></li>
                <li><a href="/almacen/articulo"><i class="fa fa-circle-o"></i> Articulos</a></li>
                <li><a href="/rutas/rutas"><i class="fa fa-circle-o"></i> Rutas</a></li>
				
              </ul>
            </li>
                
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Pedidos</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				 <li><a href="/pedido/pedido"><i class="fa fa-circle-o"></i> Pedidos</a></li> 
				 <li><a href="/pedido/reporte/reporte"><i class="fa fa-circle-o"></i> Reporte Pedido</a></li> 
				 <!--<li><a href="/pedido/descargados"><i class="fa fa-circle-o"></i> Pedidos Descargados</a></li> -->
				 <li><a href="/pedido/reporte/sector"><i class="fa fa-circle-o"></i> Pedidos por Sector</a></li> 
				 </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Ingresos y Egresos</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/compras/ingreso"><i class="fa fa-circle-o"></i> Compras </a></li>
                <li><a href="/ventas/venta"><i class="fa fa-circle-o"></i> Ventas</a></li>
                <li><a href="/gastos/gasto"><i class="fa fa-circle-o"></i> Gastos</a></li>
				<!--<li><a href="/ventas/ventaf"><i class="fa fa-circle-o"></i> Forma Libre</a></li>
				<li><a href="/ventas/fexterna"><i class="fa fa-circle-o"></i> Factura Externa</a></li>
				<li><a href="/almacen/deposito"><i class="fa fa-circle-o"></i> Control Vacios</a></li> 	-->
                <li><a href="/compras/ajuste"><i class="fa fa-circle-o"></i> Ajuste de Inventario</a></li>
                <li><a href="/pacientes/cobrar"><i class="fa fa-circle-o"></i> Cuentas por Cobrar</a></li>
                <li><a href="/proveedores/pagar"><i class="fa fa-circle-o"></i> Cuentas por Pagar</a></li>				
				<li><a href="/ventas/recargo"><i class="fa fa-circle-o"></i> Recargos en Ventas</a></li> 
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Produccion Cafe</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
				 <li><a href="/produccion/tostado"><i class="fa fa-circle-o"></i> Tostado</a></li> 
				 <li><a href="/produccion/molida"><i class="fa fa-circle-o"></i>Molida/ Empaquetada</a></li> 
				<li><a href="/reportes/produccion"><i class="fa fa-circle-o"></i> Reporte Produccion</a></li> 
				 <!-- <li><a href="/pedido/reporte/sector"><i class="fa fa-circle-o"></i> Empaquetada</a></li> -->
				 </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-print"></i>
                <span>Informes de Ventas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/reportes/ventas"><i class="fa fa-circle-o"></i> Resumen de ventas</a></li>
				<!--<li><a href="/ventas/ventasf"><i class="fa fa-circle-o"></i> Correlativo Ventas FL</a></li>-->
                <li><a href="/reportes/corte"><i class="fa fa-circle-o"></i> Corte de Caja</a></li>
				       <li><a href="/reportes/cobranza"><i class="fa fa-circle-o"></i> Detalle de Ingresos</a></li>
				       <li><a href="/reportes/cobrar"><i class="fa fa-circle-o"></i>Cuentas por Cobrar</a></li>
				       <li><a href="/vendedor/cobrar"><i class="fa fa-circle-o"></i> Cuentas por Vendedor</a></li>
		        		<li><a href="/reportes/utilidad/"><i class="fa fa-circle-o"></i> Utilidad en Ventas</a></li>
						<li><a href="/reportes/ventasarticulo/"><i class="fa fa-circle-o"></i> Ventas de un Articulo</a></li>         
						<li><a href="/reportes/ventacobranza/"><i class="fa fa-circle-o"></i> Analisis de Cobranza</a></li>         
						<li><a href="/reportes/detallecobranza/"><i class="fa fa-circle-o"></i> Detalle de Cobranza</a></li>                     
			</ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-print"></i>
                <span>Informes de Compras</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/reportes/compras"><i class="fa fa-circle-o"></i> Resumen de Compras</a></li>
                <li><a href="/reportes/gastos"><i class="fa fa-circle-o"></i> Resumen de Gastos</a></li>
				<li><a href="/cxp/listaretenciones"><i class="fa fa-circle-o"></i> Retenciones</a></li>
				<li><a href="/reportes/pagar"><i class="fa fa-circle-o"></i>Cuentas por Pagar</a></li>     
               <li><a href="/reportes/pagos"><i class="fa fa-circle-o"></i> Detalle de Pagos</a></li>     
			    <li><a href="/reportes/comprasarticulo/"><i class="fa fa-circle-o"></i> Compras de un Articulo</a></li>
				<li><a href="/almacen/articulo/grafico/"><i class="fa fa-circle-o"></i>Grafico Venta Articulo</a></li>                     
              </ul>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-print"></i>
                <span>Otros Informes</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/reportes/ruta/"><i class="fa fa-circle-o"></i> Rutas Pedido</a></li>
				<!--<li><a href="/reportes/rutasvacio/"><i class="fa fa-circle-o"></i> Vacios por ruta</a></li>
                <li><a href="/reportes/vacios/"><i class="fa fa-circle-o"></i> Reporte Vacios</a></li> -->
                <li><a href="/reportes/inventario/"><i class="fa fa-circle-o"></i> Inventario fisico</a></li>
                <li><a href="/reportes/valorizado/"><i class="fa fa-circle-o"></i> Inventario Valorizado</a></li>
                <li><a href="/reportes/listaprecio/"><i class="fa fa-circle-o"></i> Lista de Precios</a></li>
				<li><a href="/reportes/novendido"><i class="fa fa-circle-o"></i> No Vendios</a></li>
				<li><a href="/reportes/cero"><i class="fa fa-circle-o"></i> Existencia Cero</a></li>
			    <li><a href="/reportes/catalogo/"><i class="fa fa-circle-o"></i> Catalago</a></li>
		      	<li><a href="/reportes/resumen/"><i class="fa fa-circle-o"></i>Resumen Gerencial</a></li>
		      	<li><a href="/reportes/clientes/"><i class="fa fa-circle-o"></i>Analisis de Clientes</a></li>
		      	<li><a href="/reportes/clientesectores/"><i class="fa fa-circle-o"></i>Clientes Sectores</a></li>
		      	<li><a href="/reportes/seguimientoclientes/"><i class="fa fa-circle-o"></i>Seguimiento de Clientes</a></li>
			    <li><a href="/reportes/listaclientes/"><i class="fa fa-circle-o"></i>Lista de Clientes</a></li>
				<li><a href="/almacen/categoria/grafico/"><i class="fa fa-circle-o"></i>Grafico </a></li>          
              </ul>
            </li>
		<li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Caja</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/caja/caja"><i class="fa fa-circle-o"></i> Caja</a></li>  			
                <li><a href="/caja/saldo"><i class="fa fa-circle-o"></i> Edo. Cuenta.</a></li>  			
              </ul>
            </li>	
                  <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Comisiones</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/comisiones/comision"><i class="fa fa-circle-o"></i> Comisiones</a></li>
                <li><a href="/comisiones/comision/pendiente/"><i class="fa fa-circle-o"></i> Comi. por Pagar</a></li>               
			   <li><a href="/comisiones/comision/pagadas/"><i class="fa fa-circle-o"></i> Comi. Pagadas</a></li>
              </ul>
            </li>  
            <!--    <li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Metas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/metas/metas"><i class="fa fa-circle-o"></i> Metas Empresa</a></li>
                <li><a href="/metas/vendedor/"><i class="fa fa-circle-o"></i> Metas Vendedor</a></li>               
              <li><a href="/metas/bloques/"><i class="fa fa-circle-o"></i> Bloques Metas</a></li>               
			  </ul>
            </li>  	 -->		
            <li class="treeview">
              <a href="#">
                <i class="fa fa-folder"></i> <span>Acceso</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>@if(Auth::user()->nivel=="A")
              <ul class="treeview-menu">
                <li><a href="/sistema/tasa/usuarios/"><i class="fa fa-circle-o"></i> Usuarios del Sistema</a></li>
                <li><a href="/sistema/tasa/"><i class="fa fa-circle-o"></i> Tasa de Cambio</a></li>
                
              </ul>@endif
            </li> <!-- 
			<li class="treeview">
              <a href="#">
                <i class="fa fa-money"></i>
                <span>Informes de Impuestos</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/informes/librov"><i class="fa fa-circle-o"></i> Libro de Ventas</a></li>  			
                <li><a href="/informes/libroc"><i class="fa fa-circle-o"></i> Libro de Compras</a></li>  			
                <li><a href="/informes/valorizado"><i class="fa fa-circle-o"></i> Valorizado</a></li> 
				<li><a href="/informes/licores"><i class="fa fa-circle-o"></i> Libro de Licores</a></li>  				
              </ul>
            </li>	-->
			  <li class="treeview">
              <a href="#">
                <i class="fa fa-plus-square"></i> <span>Ayuda</span> 
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li><a href="/sistema/ayuda/"><i class="fa fa-circle-o"></i>Sistema <small class="label pull-right bg-red">PDF</small></a></li>
                
              </ul>
            </li>
            <li>
              <a href="/reportes/info/">
                <i class="fa fa-info-circle"></i> <span>Acerca De...</span>
                <small class="label pull-right bg-yellow">IT</small>
              </a>
            </li>	
			<li>
			<div align="center">
			<img src="{{asset('dist/img/logosistema.png')}}" class="img-circle" width="70%" height="140" >
			</div>			</li>				 
          </ul>

    

        </section>     		
        <!-- /.sidebar -->
      </aside>




       <!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        
        <!-- Main content -->
        <section class="content" >
          
          <div class="row">
            <div class="col-md-12">
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title">Sistema de Ventas SysVent@s</h3>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body" style="background-color: #fff">
     
                  	<div class="row">
	                  	    <div class="col-md-12" >
		                          <!--Contenido-->
								
                              @yield('contenido')
               
		                          <!--Fin Contenido-->
                           </div>
                            
                        </div>
		                 
                       
                            
                        
                  		</div>       <div class="box-body" style="background-color: #fff">
                    <div class="row">
                          <div class="col-md-12" >@yield('reporte')   <!--Fin Contenido-->
                           </div>
                            
                        </div>
                     
                       
                            
                        
                      </div>  
                  	</div><!-- /.row -->
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!--Fin-Contenido-->
      <footer class="main-footer">
        <div class="pull-right hidden-xs">
          <b>Version</b> 1.2
        </div>
        <strong>Copyright &copy; 2015-2025 <a href="#">W&W Sistemas</a>.</strong> All rights reserved.
      </footer>

      
    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    @stack ('scripts')
    <!-- Bootstrap 3.3.5 -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
     <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
	 <script src="{{asset('js/chartjs/Chart.min.js')}}"></script>
	    <script src="{{asset('js/jquery.dataTables.min.js')}}"></script>

<!-- page script -->
<script src="{{asset('js/morris/morris.min.js')}}"></script>
<script src="{{asset('js/morris/raphael.min.js')}}"></script>
  <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    
  </body>
</html>
