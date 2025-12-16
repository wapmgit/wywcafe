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
Route::resource('/almacen/articulo/validar','ArticuloController@validar');

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
//vendedores
Route::resource('vendedor/vendedor','VendedoresController');
Route::resource('vendedor/cobrar','VendedoresController@porcobrar');
Route::resource('vendedor/clientes','VendedoresController@clientes');


Route::resource('proveedores/proveedor/historico','ProveedorController@historico');
Route::resource('proveedores/pagar','CxpagarController');
Route::resource('proveedores/proveedor','ProveedorController');
Route::resource('/proveedores/proveedor/validar','ProveedorController@validar');


Route::resource('/cxp/pago','CxpagarController@pago');
Route::resource('/cxp/retencion','CxpagarController@retencion');
Route::resource('/cxp/retenciongas','CxpagarController@retenciongas');
Route::resource('/cxp/listaretenciones','CxpagarController@listaretenciones');
Route::resource('/cxp/verretencion','CxpagarController@verretencion');
Route::resource('/cxp/proveedor/anular','CxpagarController@destroyretencion');
Route::resource('/cxp/proveedor/ajustecorre','CxpagarController@ajustecorre');


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
//pedidos
Route::resource('pedido/pedido','PedidoController');
Route::resource('/pedido/pedido/facturar','PedidoController@facturar');
Route::resource('pedido/devolucion','PedidoController@devolucion');
Route::resource('pedido/devolucionfac','PedidoController@devolucionfac');
Route::resource('pedido/devolucionpedido','PedidoController@devolucionpedido');
Route::resource('pedido/pedido/destruir','PedidoController@destruir');
Route::resource('pedido/reporte/reporte','PedidoController@reporte');
Route::resource('pedido/pedido/ajuste','PedidoController@ajuste');
Route::resource('pedido/addarticulo','PedidoController@addart');
Route::resource('agregargastoadm','PedidoController@agregargastoadm');


Route::resource('ventas/venta','VentaController');
Route::resource('ventas/ventacaja','VentaController@ventacaja');
Route::resource('ventas/cliente','VentaController@almacena');
Route::resource('/ventas/ventas/refrescar','VentaController@refrescar');
Route::resource('/ventas/recibo','VentaController@ver');



Route::resource('reportes/ventas','ReportesController');
//excel reports

Route::resource('/cxc/excel', 'ExcelController@reportecxc');
Route::resource('/reportes/excel/inventariofisico', 'ExcelController@inventariof');

     
Route::resource('reportes/compras','ReportesController@caja');
Route::resource('reportes/valorizado','ReportesController@valorizado');
Route::resource('reportes/inventario','ReportesController@inventario');
Route::resource('reportes/listaprecio','ReportesController@listaprecio');
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
Route::resource('/reportes/vacios','ReportesController@vacios');
Route::resource('/reportes/clientesectores','ReportesController@csectores');
Route::resource('/reportes/seguimientoclientes','ReportesController@seguimiento');
Route::resource('/reportes/ventacobranza','ReportesController@analisiscobros');
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
Route::resource('pacientes/pago','CxcobrarController@pago');
Route::resource('pacientes/pago/nd','CxcobrarController@pagond');
Route::resource('/reportes/clientes','PacientesController@reporte');
Route::resource('/clientes/cliente/municipio','PacientesController@obtmunicipio');

// sistema
Route::resource('sistema/tasa','SistemaController');
Route::resource('sistema/tasa/usuarios/','SistemaController@ususarios');
Route::resource('sistema/tasa/act/','SistemaController@almacena');
Route::resource('sistema/ayuda/','SistemaController@ayuda');
Route::auth();

//caja
Route::resource('caja/caja','CajaController');
Route::resource('/caja/consulta','CajaController@consulta');
Route::resource('/caja/credito','CajaController@credito');
Route::resource('/caja/debito','CajaController@debito');
Route::resource('/caja/detalle','CajaController@detalle');
Route::resource('/caja/movimientos','CajaController@movimientos');
Route::resource('caja/recibo','CajaController@recibo');
Route::resource('caja/saldo','CajaController@saldo');
Route::get('/home', 'HomeController@index');

Route::group(['middleware'=>['cors']],function(){
//Route::get('/clientes', 'ClientsApiController@index');
//Route::get('/articulos', 'ArticulosApiController@index');
Route::get('/enviar-clientes','ClientsApiController@sendData');
Route::get('/enviar-articulos','ArticulosApiController@sendData');
Route::get('/recibir-pedidos', 'PedidosApiController@sendData');
});