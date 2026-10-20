@extends('layouts.admin')

@section('contenido')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 align-items-center">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Editar Artículo: <strong>{{ $articulo->nombre }}</strong></h1>
            </div>
            <div class="col-sm-6 text-right">
                @if(($articulo->imagen) != "")
                    <img src="{{ asset('imagenes/articulos/'.$articulo->imagen) }}" class="img-thumbnail" style="max-height: 80px;" alt="Imagen del artículo">
                @endif
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        @if (count($errors) > 0)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {!! Form::model($articulo, ['method' => 'PATCH', 'id' => 'formulario', 'route' => ['almacen.articulo.update', $articulo->idarticulo], 'files' => 'true']) !!}
            {{ Form::token() }}
            <input type="hidden" name="mutil" id="mutil" value="{{ $empresa->calc_util }}">

            <!-- Datos Generales -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-info-circle mr-1"></i> Información General</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" onchange="conMayusculas(this)" required value="{{ $articulo->nombre }}" class="form-control" placeholder="Nombre del artículo...">
                        </div>

                        <div class="col-md-4 col-sm-6 form-group">
                            <label for="idcategoria">Categoría</label>
                            <select name="idcategoria" id="idcategoria" class="form-control">
                                @foreach ($categorias as $cat)
                                    <option value="{{ $cat->idcategoria }}" {{ $cat->idcategoria == $articulo->idcategoria ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="codigo">Código</label>
                            <input type="text" name="codigo" id="codigo" required value="{{ $articulo->codigo }}" class="form-control" placeholder="Código...">
                        </div>

                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" required value="{{ $articulo->descripcion }}" class="form-control" placeholder="Descripción...">
                        </div>

                        <div class="col-md-6 col-sm-12 form-group">
                            <label for="imagen">Imagen Destacada</label>
                            <input type="file" name="imagen" id="imagen" class="form-control-file">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="stock">Stock</label>
                            <input type="text" disabled value="{{ $articulo->stock }}" class="form-control">
                            <input type="hidden" name="stock" value="{{ $articulo->stock }}">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="unidad">Unidad de Medida</label>
                            <select name="unidad" id="unidad" class="form-control">
                                <option value="UND" {{ $articulo->unid == 'UND' ? 'selected' : '' }}>Unidad</option>
                                <option value="BTO" {{ $articulo->unid == 'BTO' ? 'selected' : '' }}>Bulto</option>
                                <option value="SCO" {{ $articulo->unid == 'SCO' ? 'selected' : '' }}>Saco</option>
                                <option value="CJA" {{ $articulo->unid == 'CJA' ? 'selected' : '' }}>Caja</option>
                                <option value="KG"  {{ $articulo->unid == 'KG'  ? 'selected' : '' }}>Kg</option>
                                <option value="DISP" {{ $articulo->unid == 'DISP' ? 'selected' : '' }}>Display</option>
                                <option value="PR"  {{ $articulo->unid == 'PR'  ? 'selected' : '' }}>Par</option>
                                <option value="LTR" {{ $articulo->unid == 'LTR' ? 'selected' : '' }}>Litros</option>
                                <option value="MNGA" {{ $articulo->unid == 'MNGA' ? 'selected' : '' }}>Manga</option>
                                <option value="PAQ" {{ $articulo->unid == 'PAQ' ? 'selected' : '' }}>Paquete</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="peso">Peso (Gms)</label>
                            <input type="number" name="peso" id="peso" min="0.1" step="any" required value="{{ $articulo->pesogr }}" class="form-control">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="fraccion">Fracción</label>
                            <input type="number" name="fraccion" id="fraccion" min="0.1" step="any" required value="{{ $articulo->fraccion }}" class="form-control" placeholder="1, 0.25, 0.5">
                        </div>

                        <div class="col-md-4 col-sm-12 form-group d-flex align-items-center pt-3">
                            <div class="form-check form-check-inline mr-3">
                                <input class="form-check-input" type="checkbox" name="mprima" id="cbx2" value="1" {{ $articulo->mprima == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="cbx2">¿Materia Prima?</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="sevende" id="cbxv" value="1" {{ $articulo->sevende == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="cbxv">¿Disponible Venta?</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Producción y Comisión -->
            <div class="card card-secondary card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-cogs mr-1"></i> Configuración de Producción y Comisión</h3>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 col-sm-6 form-group">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="produ" id="cbx3" value="1" {{ $articulo->nivelp > 0 ? 'checked' : '' }}>
                                <label class="form-check-label font-weight-bold" for="cbx3">¿Afecta Producción?</label>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 form-group">
                            <label for="nivelp">Nivel Producción</label>
                            <select name="nivelp" id="nivelp" class="form-control" {{ $articulo->nivelp == 0 ? 'disabled' : '' }}>
                                <option value="0" {{ $articulo->nivelp == 0 ? 'selected' : '' }}>Sin Nivel</option>
                                <option value="1" {{ $articulo->nivelp == 1 ? 'selected' : '' }}>Tostado</option>
                                <option value="2" {{ $articulo->nivelp == 2 ? 'selected' : '' }}>Molido</option>
                                <option value="3" {{ $articulo->nivelp == 3 ? 'selected' : '' }}>Empaquetado</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 form-group">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="comi" id="cbx1" value="{{ $articulo->comi == 1 ? 1 : 0 }}" {{ $articulo->comi == 1 ? 'checked' : '' }}>
                                <label class="form-check-label font-weight-bold" for="cbx1">¿Aplica Comisión?</label>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 form-group">
                            <label for="porcentaje">% Comisión</label>
                            <input type="number" min="0.01" step="0.01" name="porcentaje" id="porcentaje" class="form-control" placeholder="%"
                                value="{{ $articulo->comi == 1 ? $articulo->pcomision : 0 }}"
                                {{ $articulo->comi == 1 ? '' : 'disabled' }}>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Costos y Precios -->
            <div class="card card-success card-outline">
                <div class="card-header">
                    <h3 class="card-title"><i class="fa fa-dollar-sign mr-1"></i> Costos y Estructura de Precios</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="costo">Costo Base</label>
                            <input type="number" name="costo" id="costo" step="0.01" value="{{ $articulo->costo }}" class="form-control" placeholder="0.00">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="impuesto">Impuesto (IVA %)</label>
                            <input type="text" name="impuesto" id="impuesto" value="{{ $articulo->iva }}" class="form-control" placeholder="0%">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="utilidad">% Utilidad 1</label>
                            <input type="number" name="utilidad" id="utilidad" step="0.01" value="{{ $articulo->utilidad }}" class="form-control" placeholder="%">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="precio1">Precio Venta 1</label>
                            <input type="text" name="precio1" id="precio1" value="{{ $articulo->precio1 }}" class="form-control" placeholder="0.00">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="util2">% Utilidad 2</label>
                            <input type="number" name="util2" id="util2" step="0.01" value="{{ $articulo->util2 }}" class="form-control" placeholder="%">
                        </div>

                        <div class="col-md-2 col-sm-6 form-group">
                            <label for="precio2">Precio Venta 2</label>
                            <input type="text" name="precio2" id="precio2" value="{{ $articulo->precio2 }}" class="form-control" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Productos Agrupados -->
            <div class="card card-info card-outline">
                <div class="card-header">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="usap" id="cbx4" value="{{ $articulo->usap == 1 ? 1 : 0 }}" {{ $articulo->usap == 1 ? 'checked' : '' }}>
                        <label class="form-check-label font-weight-bold" for="cbx4">¿Es un Producto Agrupado / Presentaciones?</label>
                    </div>
                </div>
                <div class="card-body" id="tagrupado" style="{{ $articulo->usap == 0 ? 'display:none;' : '' }}">
                    <div class="row align-items-end mb-3 bg-light p-2 rounded">
                        <div class="col-md-3 form-group mb-0">
                            <label>Nombre Presentación</label>
                            <input type="text" id="ngrupo" class="form-control form-control-sm" placeholder="Ej: Pack x 6">
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label>Cantidad</label>
                            <input type="number" id="cantidadg" min="0" class="form-control form-control-sm" placeholder="Cant.">
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <label>Utilidad (%)</label>
                            <input type="number" id="utilg" min="0" class="form-control form-control-sm" placeholder="%">
                        </div>
                        <div class="col-md-3 form-group mb-0">
                            <label>Precio</label>
                            <input type="number" id="preciog" min="0" class="form-control form-control-sm" placeholder="Precio">
                        </div>
                        <div class="col-md-2 form-group mb-0">
                            <button type="button" id="bt_grp" class="btn btn-info btn-sm btn-block">
                                <i class="fa fa-plus-circle"></i> Agregar
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover text-center" id="detalles_out">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Presentación</th>
                                    <th>Cantidad</th>
                                    <th>Utilidad (%)</th>
                                    <th>Precio Venta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($presentacion as $p)
                                    <tr class="selected">
                                        <td>
                                            <input type="hidden" name="vidgrupo[]" value="{{ $p->id }}">
                                            <input type="text" class="form-control form-control-sm" name="vngrupo[]" value="{{ $p->descripcion }}">
                                        </td>
                                        <td><input type="number" class="form-control form-control-sm text-center" name="vgcant[]" value="{{ $p->cantidad }}"></td>
                                        <td><input type="number" class="form-control form-control-sm text-center" name="vgutil[]" value="{{ $p->utilidad }}"></td>
                                        <td><input type="number" class="form-control form-control-sm text-center" name="vgpre[]" value="{{ $p->preciov }}"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="row my-4">
                <div class="col-12 text-right">
                    <button class="btn btn-primary btn-lg" type="button" id="btnguardar">
                        <i class="fa fa-save"></i> Guardar Cambios
                    </button>
                    <a class="btn btn-danger btn-lg text-white" href="javascript:history.back()" id="btncancelar">
                        <i class="fa fa-times-circle"></i> Cancelar
                    </a>
                    <div style="display: none;" id="loading" class="mt-2">
                        <img src="{{ asset('imagenes/sistema/loading30.gif') }}" alt="Cargando..."> Cargando...
                    </div>
                </div>
            </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){
    $('#bt_grp').click(function(){   
        agregar();  
    });
    
    $("#utilg").change(calculog); 
    $("#costo").change(calculo); 
    $("#costo").change(calculo2); 
    $("#utilidad").change(calculo); 
    $("#impuesto").change(calculo); 
    $("#util2").change(calculo2); 
    $("#precio1").change(reverso); 
    $("#precio2").change(reverso2); 

    $('#btnguardar').click(function(){    
        document.getElementById('loading').style.display = ""; 
        document.getElementById('btnguardar').style.display = "none"; 
        document.getElementById('btncancelar').style.display = "none"; 
        document.getElementById('formulario').submit(); 
    });

    $("#cbx1").click(function() {
        if ($(this).is(":checked")){
            $("#cbx1").val(1);
            $("#porcentaje").attr("disabled", false).focus();
        } else {
            $("#cbx1").val(0);
            $("#porcentaje").val(0).attr("disabled", true);
            $("#costo").focus();
        }
    });

    $("#cbx2").click(function() {
        $("#cbx2").val($(this).is(":checked") ? 1 : 0);
    });

    $("#cbx4").click(function() {
        if ($(this).is(":checked")){
            $("#cbx4").val(1);
            $('#tagrupado').slideDown(); 
        } else {
            $("#cbx4").val(0);
            $('#tagrupado').slideUp();
        }
    });

    $("#cbxv").click(function() {
        $("#cbxv").val($(this).is(":checked") ? 1 : 0);
    });

    $("#cbx3").click(function() {
        const element = document.getElementById('nivelp');
        if ($(this).is(":checked")){
            element.disabled = false;
        } else {
            element.disabled = true;
            $("#nivelp").val(0);
        }
    });
});

var cont = 0;

function agregar(){
    var gnombre = $("#ngrupo").val();
    var gcantidad = $("#cantidadg").val();
    var gutil = $("#utilg").val();
    var gprecio = $("#preciog").val();

    if (gnombre !== "" && gcantidad !== "" && gprecio !== "" && gutil !== ""){          
        var fila = '<tr class="selected">' +
            '<td><input type="hidden" name="vidgrupo[]" value="0"><input type="text" class="form-control form-control-sm" name="vngrupo[]" value="'+gnombre+'"></td>' +
            '<td><input type="number" class="form-control form-control-sm text-center" name="vgcant[]" value="'+gcantidad+'"></td>' +
            '<td><input type="number" class="form-control form-control-sm text-center" name="vgutil[]" value="'+gutil+'"></td>' +
            '<td><input type="number" class="form-control form-control-sm text-center" name="vgpre[]" value="'+gprecio+'"></td>' +
            '</tr>';
        cont++;
        limpiar();
        $('#detalles_out').append(fila);
    } else {
        alert("Error al ingresar los datos de la presentación");
    }
}

function limpiar(){
    $("#cantidadg").val("");
    $("#utilg").val("");
    $("#ngrupo").val("");
    $("#preciog").val("");
}

function calculo(){
    var mutil = $("#mutil").val();
    $("#precio1").val("");
    var costo = $("#costo").val();
    var impuesto = $("#impuesto").val();
    var utilidad = $("#utilidad").val();
    var p1 = parseFloat(utilidad / 100);
    var p2 = (mutil == 1) ? (parseFloat(costo) + parseFloat(p1 * costo)) : (costo / ((100 - utilidad) / 100));
    var iva = p2 * (impuesto / 100);
    var pt = trunc(parseFloat(p2) + parseFloat(iva), 2);
    $("#precio1").val(pt);
}

function calculo2(){
    var mutil = $("#mutil").val();
    $("#precio2").val("");
    var costo = $("#costo").val();
    var impuesto = $("#impuesto").val();
    var utilidad = $("#util2").val();
    var p1 = parseFloat(utilidad / 100);
    var p2 = (mutil == 1) ? (parseFloat(costo) + parseFloat(p1 * costo)) : (costo / ((100 - utilidad) / 100));
    var iva = p2 * (impuesto / 100);
    var pt = trunc(parseFloat(p2) + parseFloat(iva), 2);
    $("#precio2").val(pt);
}

function reverso(){
    var p30 = $("#precio1").val();
    var mutil = $("#mutil").val();
    var costo = $("#costo").val();
    var impuesto = $("#impuesto").val();       
    var p31 = parseFloat(impuesto / 100);  
    var p32 = parseFloat(costo) + parseFloat(p31 * costo);     
    var util = (mutil == 1) ? (((p30 / p32) - 1) * 100) : (100 - ((p32 * 100) / p30));
    $("#utilidad").val(parseFloat(trunc(util, 2)));
}

function reverso2(){
    var p302 = $("#precio2").val();
    var mutil = $("#mutil").val();
    var costo = $("#costo").val();
    var impuesto = $("#impuesto").val();       
    var p312 = parseFloat(impuesto / 100);  
    var p322 = parseFloat(costo) + parseFloat(p312 * costo);     
    var util2 = (mutil == 1) ? (((p302 / p322) - 1) * 100) : (100 - ((p322 * 100) / p302));
    $("#util2").val(parseFloat(trunc(util2, 2)));
}

function calculog(){
    var mutil = $("#mutil").val();
    $("#preciog").val("");
    var costo = $("#costo").val() * $("#cantidadg").val();
    var impuesto = $("#impuesto").val();
    var utilidad = $("#utilg").val();
    var p1 = parseFloat(utilidad / 100);
    var p2 = (mutil == 1) ? (parseFloat(costo) + parseFloat(p1 * costo)) : (costo / ((100 - utilidad) / 100));
    var iva = p2 * (impuesto / 100);
    var pt = trunc(parseFloat(p2) + parseFloat(iva), 2);
    $("#preciog").val(pt);
}

function conMayusculas(field) {
    field.value = field.value.toUpperCase();
}

function trunc(x, posiciones = 0) {
    var s = x.toString();
    var decimalLength = s.indexOf('.') + 1;
    if (decimalLength === 0) return Number(s);
    var numStr = s.substr(0, decimalLength + posiciones);
    return Number(numStr);
}
</script>
@endpush