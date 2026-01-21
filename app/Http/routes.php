 <?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::get('/', function () {
    return view('auth/login');
});


Route::resource('almacen/categoria/grafico','CategoriaController@grafico');
Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/categoria/recalcular','CategoriaController@recalcular');
Route::resource('almacen/articulo/detallekardex','ArticuloController@detallekardex');
Route::resource('almacen/articulo/detallekardexajuste','ArticuloController@detallekardexajuste');
Route::resource('/almacen/articulo/validar','ArticuloController@validar');
Route::resource('/almacen/articulo/actstock','ArticuloController@actstock');
Route::resource('/almacen/articulo/grafico','ArticuloController@grafico');

Route::resource('almacen/newcreate','ArticuloController@newcreate');
// almacen
Route::resource('almacen/deposito','DepositoController');
Route::resource('almacen/deposito/aggdebe','DepositoController@aggdebe');
Route::resource('almacen/deposito/aggdebo','DepositoController@aggdebo');
Route::resource('almacen/deposito/recepdebe','DepositoController@recepdebe');
Route::resource('almacen/deposito/recepdebo','DepositoController@recepdebo');
Route::resource('almacen/deposito/gestion','DepositoController@gestion');
Route::resource('deposito/deposito','DepositoController@deposito');
Route::resource('deposito/regalmacen','DepositoController@regalmacen');
//traslado
Route::resource('deposito/traslado','TrasladoController');
Route::resource('/deposito/traslado/listar','TrasladoController@listar');
//vendedores
Route::resource('vendedor/vendedor','VendedoresController');
Route::resource('vendedor/cobrar','VendedoresController@porcobrar');
Route::resource('vendedor/clientes','VendedoresController@clientes');

//dep vendedor
Route::resource('depositos/deposito','DepvendedorController');

//proveedor
Route::resource('proveedores/proveedor/historico','ProveedorController@historico');
Route::resource('proveedores/pagar','CxpagarController');
Route::resource('proveedores/proveedor','ProveedorController');
Route::resource('/proveedores/proveedor/validar','ProveedorController@validar');
Route::resource('/proveedores/proveedor/notasadm','ProveedorController@notasadm');


Route::resource('/cxp/pago','CxpagarController@pago');
Route::resource('/cxp/retencion','CxpagarController@retencion');
Route::resource('/cxp/retenciongas','CxpagarController@retenciongas');
Route::resource('/cxp/listaretenciones','CxpagarController@listaretenciones');
Route::resource('/cxp/verretencion','CxpagarController@verretencion');
Route::resource('/cxp/proveedor/anular','CxpagarController@destroyretencion');
Route::resource('/cxp/proveedor/ajustecorre','CxpagarController@ajustecorre');
Route::resource('proveedores/cobrar/nc','CxpagarController@aplicanc');


Route::resource('almacen/articulo','ArticuloController');
Route::resource('compras/articulo','ArticuloController@almacena');
//comisiones
Route::resource('comisiones/comision/pagadas','ComisionesController@pagadas');
Route::resource('comisiones/comision/pendiente','ComisionesController@comixpagar');
Route::resource('comisiones/comision','ComisionesController');
Route::resource('comisiones/comision/mostrar','ComisionesController@mostrar');
Route::resource('comisiones/comision/pagar','ComisionesController@pagar');
Route::resource('comisiones/comision/recibo','ComisionesController@ver_recibo');
Route::resource('comisiones/comision/listarecibos','ComisionesController@lista');
Route::resource('comisiones/comision/detallecomision','ComisionesController@detallecomision');


// gastos
Route::resource('gastos/gasto','GastosController');

// compras
Route::resource('compras/ajuste/loadcsv','AjusteController@loadcsv');
Route::resource('compras/ingreso','IngresoController');
Route::resource('compras/ajuste','AjusteController');

Route::resource('compras/proveedor','IngresoController@almacena');
Route::resource('compras/articulo','ArticuloController@almacena');
Route::resource('compras/ingreso/etiquetas','IngresoController@etiquetas');
Route::resource('compras/ajuste/etiquetas','AjusteController@etiquetas');
Route::resource('compras/ingreso/notas','IngresoController@notas');
Route::resource('ingreso/pnotas','PrecioController');
//pedidos
Route::resource('pedido/pedido','PedidoController');
Route::resource('/pedido/pedido/facturar','PedidoController@facturar');
Route::resource('pedido/devolucion','PedidoController@devolucion');
Route::resource('pedido/devolucionfac','PedidoController@devolucionfac');
Route::resource('pedido/devolucionpedido','PedidoController@devolucionpedido');
Route::resource('pedido/pedido/destruir','PedidoController@destruir');
Route::resource('pedido/reporte/reporte','PedidoController@reporte');
Route::resource('pedido/reporte/sector','PedidoController@sector');
Route::resource('pedido/pedido/ajuste','PedidoController@ajuste');
Route::resource('pedido/addarticulo','PedidoController@addart');
Route::resource('agregargastoadm','PedidoController@agregargastoadm');
Route::resource('pedido/descargados','PedidoController@descargados');
Route::resource('pedido/bajar','PedidoController@bajar');

//ventas

Route::resource('ventas/venta','VentaController');
Route::resource('/ventas/indeximportar','VentaController@indimportar');
Route::resource('ventas/ventacaja','VentaController@ventacaja');
Route::resource('ventas/cliente','VentaController@almacena');
Route::resource('/ventas/ventas/refrescar','VentaController@refrescar');
Route::resource('/ventas/recibo','VentaController@ver');
Route::resource('/ventas/formalibre','VentaController@formal');
//Route::resource('/ventas/procesarnota','VentaController@pnota');
Route::resource('/clientes/cliente/nc','PacientesController@notac');
//Route::resource('/ventas/ventasf','VentaController@ventasf');
Route::resource('/ventas/recargo','VentaController@recargos');
Route::resource('/ventas/addrecargo','VentaController@addrecargos');

// ventas formna libre
Route::resource('ventas/ventaf','VentafController');
Route::resource('/ventasf/indeximportar','VentafController@indimportar');
Route::resource('/ventasf/formalibre','VentafController@formal');
Route::resource('/ventasf/procesarnota','VentafController@pnota');
Route::resource('/ventas/ventasf','VentafController@ventasf');
Route::resource('/ventasf/anular','VentafController@anular');

// externas
Route::resource('/ventas/fexterna','FexternaController');	
Route::resource('reportes/ventas','ReportesController');
//excel reports

Route::resource('/cxc/excel', 'ExcelController@reportecxc');
Route::resource('/reportes/excel/inventariofisico', 'ExcelController@inventariof');

     
Route::resource('reportes/compras','ReportesController@caja');
Route::resource('reportes/valorizado','ReportesController@valorizado');
Route::resource('reportes/inventario','ReportesController@inventario');
Route::resource('reportes/listaprecio','ReportesController@listaprecio');
Route::resource('reportes/novendido','ReportesController@novendido');
Route::resource('reportes/cero','ReportesController@cero');
Route::resource('reportes/devolucion','ReportesController');
Route::resource('reportes/utilidad','ReportesController@utilidad');
Route::resource('reportes/kardex','ArticuloController@kardex');
Route::resource('reportes/corte','ReportesController@corte');
Route::resource('reportes/cortecaja','ReportesController@cortecaja');
Route::resource('reportes/ventasarticulo','ReportesController@ventasarticulo');
Route::resource('reportes/comprasarticulo','ReportesController@comprasarticulo');
Route::resource('reportes/catalogo','ArticuloController@catalogo');
Route::resource('reportes/info','ReportesController@info');
Route::resource('reportes/resumen','ReportesController@resumen');
Route::resource('reportes/cobranza','ReportesController@cobranza');
Route::resource('reportes/pagos','ReportesController@pagos');
Route::resource('/reportes/cobrar','CxcobrarController@cuentascobrar');
Route::resource('/reportes/pagar','CxpagarController@cuentaspagar');
Route::resource('/reportes/gastos','ReportesController@gastos');
Route::resource('/reportes/ruta','ReportesController@ruta');
Route::resource('/reportes/rutasvacio','ReportesController@rutasvacio');
Route::resource('/reportes/vacios','ReportesController@vacios');
Route::resource('/reportes/clientesectores','ReportesController@csectores');
Route::resource('/reportes/seguimientoclientes','ReportesController@seguimiento');
Route::resource('/reportes/ventacobranza','ReportesController@analisiscobros');
Route::resource('/reportes/detallecobranza','ReportesController@detallecobranza');
Route::resource('/reportes/produccion','ReportesController@produccion');
//clientes
Route::resource('pacientes/cobrar','CxcobrarController@detallesxcobrar');
Route::resource('pacientes/cobrar','CxcobrarController');
Route::resource('pacientes/paciente','PacientesController');
Route::resource('pacientes/cobrar/nc','CxcobrarController@aplicanc');
Route::resource('/clientes/cliente/validar','PacientesController@validar');
Route::resource('/clientes/cliente/notasadm','PacientesController@notasadm');
Route::resource('clientes/cliente/detalleventa','PacientesController@detalleventa');
Route::resource('clientes/cliente/detallenc','PacientesController@detallenc');
Route::resource('paciente/notasadm','PacientesController@detanota');
Route::resource('paciente/retencion','PacientesController@retencion');
Route::resource('pacientes/pago','CxcobrarController@pago');
Route::resource('pacientes/pago/nd','CxcobrarController@pagond');
Route::resource('/reportes/clientes','PacientesController@reporte');
Route::resource('/clientes/cliente/municipio','PacientesController@obtmunicipio');
Route::resource('pacientes/pasarfl','CxcobrarController@pasarfl');
Route::resource('/cxc/retencion','CxcobrarController@retencion');
Route::resource('pacientes/anular','PacientesController@anularnota');
Route::resource('/reportes/listaclientes','PacientesController@listaclientes');
Route::resource('/pacientes/actfecha','PacientesController@actfecha');
//metas
Route::resource('metas/metas','MetasController');
Route::resource('metas/save','MetasController');
//bloques
Route::resource('/metas/bloques','BloquesController');
Route::resource('bloques/addarticulo','BloquesController@addart');
//metas vendedor
Route::resource('metas/vendedor','MetasVendedorController');
Route::resource('metas/vendedor/cerrar','MetasVendedorController@cerrar');
Route::resource('metas/vendedor/ajustar','MetasVendedorController@ajustar');
Route::resource('detallemeta/bloque','MetasVendedorController@metabloque');
Route::resource('detallemeta/obsmetavendedor','MetasVendedorController@obsmetavendedor');
Route::resource('detallemeta/obsmetavendedors','MetasVendedorController@obsmetavendedors');
// sistema

Route::auth();
Route::resource('sistema/tasa','SistemaController');
Route::resource('sistema/roles/usuarios/','SistemaController@ususarios');
Route::resource('sistema/tasa/act/','SistemaController@almacena');
Route::resource('sistema/ayuda/','SistemaController@ayuda');
Route::resource('sistema/mensaje/','SistemaController@mensaje');
Route::resource('sistema/actroles/','SistemaController@actroles');
Route::resource('sistema/actpass/','SistemaController@updatepass');

//caja
Route::resource('caja/caja','CajaController');
Route::resource('/caja/consulta','CajaController@consulta');
Route::resource('/caja/credito','CajaController@credito');
Route::resource('/caja/debito','CajaController@debito');
Route::resource('/caja/detalle','CajaController@detalle');
Route::resource('/caja/detallef','CajaController@detallef');
Route::resource('/caja/movimientos','CajaController@movimientos');
Route::resource('caja/recibo','CajaController@recibo');
Route::resource('caja/saldo','CajaController@saldo');
Route::resource('caja/detalleventa','CajaController@detalleventa');
Route::get('/home', 'HomeController@index');
//impuestos
Route::resource('/informes/librov','ImpuestosController@librov');
Route::resource('/informes/libroc','ImpuestosController@libroc');
Route::resource('/informes/valorizado','ImpuestosController@valorizado');
Route::resource('/informes/licores','ImpuestosController@licores');
//rutas
Route::resource('rutas/rutas','RutasController');
//produccion
Route::resource('produccion/tostado','ProduccionController@indext');
Route::resource('tostado/create','ProduccionController@createt');
Route::resource('/produccion/tostado/save','ProduccionController@savetostado');
Route::resource('/produccion/molida/save','ProduccionController@savemolida');
Route::resource('/tostado/detalle','ProduccionController@dettostado');
Route::resource('produccion/molida','ProduccionController@indexm');
Route::resource('molida/create','ProduccionController@createm');
Route::resource('/molida/detalle','ProduccionController@detmolida');


//apis
Route::group(['middleware'=>['cors']],function(){
//Route::get('/clientes', 'ClientsApiController@index');
//Route::get('/articulos', 'ArticulosApiController@index');
Route::get('/enviar-clientes','ClientsApiController@sendData');
Route::get('/enviar-articulos','ArticulosApiController@sendData');
Route::get('/recibir-pedidos', 'PedidosApiController@sendData');
});