@extends('template')

@section('title','Crear compra')

@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .table {
    --bs-table-color: initial;
  }
</style>
@endpush

@section('content')
<div class="container-fluid px-5">
    <h1 class="mt-4 text-center">Crear Compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Compra</a></li>
        <li class="breadcrumb-item active"> Crear Compra</li>
    </ol>
</div>
<form action="" method="post">
    @csrf
    <div class="container mt-4">
        <div class="row gy-4">
             <!--Compra producto-->
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la compra
                </div>
                <!--Producto-->
                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" title="Busque un producto aqui">
                                @foreach ($productos as $item)
                                    <option value="{{$item->id}}">{{$item->codigo.' '.$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                
                <!--Cantidad-->
                <div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>
                         <!--Precio de compra-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_compra" class="form-label">Precio de compra:</label>
                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">

                    </div>
                     <!--Precio de venta-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">

                        </div>
                        <!--boton agregar-->
                        <div class="col-md-12 mt-2 mb-2 text-end">
                            <button id="btn_agregar" type="button" class="btn btn-primary">Agregar</button>
                        </div>
                        <!--tabla para detalle de la compra-->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio Compra</th>
                                            <th>Precio venta</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        
                                    </thead>
                                    <tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">Sumas</th>
                                                <th><span id="sumas">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">IVA %</th>
                                                <th><span id="iva">0</span></th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th colspan="4">Total</th>
                                                <th><span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Boton para cancelar la compra-->
                        <div class="col-md-12 mb-2">
                            <button type="button"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Cancelar compra</button>
                        </div>
                    </div>
                    </div>
                </div>
               
               
                </div>
                <div class="col-md-4">
                    <!--Producto-->
                     <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row">
                        <!--Proveedor-->
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Proveedor:</label>
                            <select name="proveedore_id" id="proveedore_id" class="form-control selectpicker show-tick data-live-search=true" title="Selecciona" data-size="2">
                                @foreach ($proveedores as $item)
                                   <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--Comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick  title="Selecciona" >
                                @foreach ($comprobantes as $item)
                                   <option value="{{$item->id}}">{{$item->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--numero comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="numero_comprobante" class="form-label">Numero Comprobante:</label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                        </div>
                        <!--Impuesto-->
                         <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">Impuesto (IVA):</label>
                            <input readonly type="text" name="impuesto" id="impuesto" class="form-control border-success">
                        </div>
                        <!--Fecha-->
                         <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">Fecha:</label>
                            <input readonly type="date" name="impuesto" id="impuesto" class="form-control border-success" value="<?php echo date("Y-m-d")?>">
                        </div>

                        <!--Botones-->
                        <div class="col-md-12 m-2 text-center">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </div>
                </div>
                </div>
            
        </div>
    </div>
    <!-- Modal cancelar compra -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmacion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Seguro que deseas cancelar la compra?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button  id="btnCancelarCompra" type="button" class="btn btn-danger"  data-bs-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>
</form>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>
    $(document).ready(function(){
        $('#btn_agregar').click(function(){
            agregarProducto();
        });
        $('#btnCancelarCompra').click(function(){
            cancelarCompra();
        });

        disableButtons();

        $('#impuesto').val(impuesto + '%');
    });
    //variable
    let cont =0;
    let subTotal=[];
    let sumas = 0;
    let iva = 0;
    let total =0;

    //constantes
    const impuesto =18;
    function cancelarCompra(){
        $('#tabla_detalle > tbody').empty();
        //anadir una nueva fila a la tabla
    let fila = '<tr>' +
                '<th></th>' +
               '<td></td>' +
               '<td></td>' +
               '<td></td>' +
               '<td></td>' +
               '<td></td>' +
               '<td></td>' +
               '</tr>';
               $('#tabla_detalle').append(fila);
        //Reiniciar el valor de todas las variables
         let cont =0;
    let subTotal=[];
    let sumas = 0;
    let iva = 0;
    let total =0;
    //Mostrar los datos calculados
                    $('#sumas').html(sumas);
                    $('#iva').html(iva);
                    $('#total').html(total);
    limpiarCampos();
               }
    function agregarProducto(){
        let idProducto = $('#producto_id').val();
        let nameProducto = ($('#producto_id option:selected').text().split(' ')[1]);
        let cantidad =$('#cantidad').val();
        let precioCompra = $('#precio_compra').val();
        let precioVenta = $('#precio_venta').val();

        //Validaciones
        //1.Para que los campos no esten vacios
        if (nameProducto !='' && cantidad !='' && precioCompra !='' && precioVenta != '') {
         //2. Para que los valores ingresados sea los correctos
            if(parseInt(cantidad)>0 && (cantidad%1==0) && parseFloat(precioCompra) && parseFloat(precioVenta)){
        //3.Para que el precio de compra sea menor al precio de venta
        if(parseFloat(precioVenta)> parseFloat(precioCompra)){
           //Calcular valores
        subTotal[cont]= round(cantidad*precioCompra);
        sumas +=subTotal[cont];
        iva =round(sumas/100 * impuesto);
        total = round(sumas + iva);
        let fila = '<tr id="fila'+ cont + '">' +
                    '<th>'+ (cont +1)  +'</th>' +
                    '<td>'+ nameProducto +'</td>' +
                    '<td>'+ cantidad +'</td>' +
                    '<td>'+precioCompra+'</td>' +
                    '<td>'+precioVenta+'</td>' +
                    '<td>'+subTotal[cont]+'</td>' +
                    '<td><button class="btn btn-danger" type="button" onClick="eliminarProducto('+cont+')"><i class="fa-solid fa-trash"></i></button></td>' +
                    '</tr>';

                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont++;

                    //Mostrar los campos calculados en la tabla
                    $('#sumas').html(sumas);
                    $('#iva').html(iva);
                    $('#total').html(total);
        }else{
            showModal('precio de compra incorrecto');
        }
      
            }else{
                showModal('valores incorrectos');
            }
           

        } else {
            showModal('Le faltan campos por llenar');
        }

           }


     function eliminarProducto(indice){
        //calcular valores
        sumas -= round(subTotal[indice]);
        iva = round(sumas / 100 * impuesto);
        total = round(sumas + iva);
        //Mostrar los campos calculados
                    $('#sumas').html(sumas);
                    $('#iva').html(iva);
                    $('#total').html(total);
        //eliminar la fila de la tabla
        $('#fila'+indice).remove();
         limpiarCampos();
                    cont++;
     }  
     

    function limpiarCampos(){
        let select = $('#producto_id');
        select.selectpicker();
        select.selectpicker('val','');
        $('#cantidad').val('');
        $('#precio_compra').val('');
        $('#precio_venta').val('');
    }
    function round(num, decimales = 2) {
    var signo = (num >= 0 ? 1 : -1);
    num = num * signo;
    if (decimales === 0) //con 0 decimales
        return signo * Math.round(num);
    // round(x * 10 ^ decimales)
    num = num.toString().split('e');
    num = Math.round(+(num[0] + 'e' + (num[1] ? (+num[1] + decimales) : decimales)));
    // x * 10 ^ (-decimales)
    num = num.toString().split('e');
    return signo * (num[0] + 'e' + (num[1] ? (+num[1] - decimales) : -decimales));
}
function showModal(message,icon='error'){
    const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});
Toast.fire({
  icon: icon,
  title: message
});
}
</script>
@endpush