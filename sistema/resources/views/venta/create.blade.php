@extends('template')

@section('title','Ventas')

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
    <h1 class="mt-4 text-center">Crear Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('ventas.index')}}">Venta</a></li>
        <li class="breadcrumb-item active"> Crear Venta</li>
    </ol>
</div>
<form action="{{route('ventas.store')}}" method="post">
    @csrf
    <div class="container mt-4">
        <div class="row gy-4">
             <!--Compra producto-->
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la venta
                </div>
                <!-- Producto-->
                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker" data-live-search="true" title="Busque un producto aqui">
                                @foreach ($productos as $item)
                                    <option value="{{$item->id}}">{{$item->codigo.' '.$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    
                    <!--stock-->
                    {{-- <div class="col-md-6">

                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="row">
                        <label for="stock" class="form-label col-sm-4">En stock</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control">
                        </div>
                    </div>
                    </div>
                    </div> --}}
                    
                    <div class="d-flex justify-content-end">
                        <div class="col-md-6 mb-4 mt-2">
                            <div class="row">
                                <label for="stock" class="form-label col-sm-4">En stock</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control">
                            </div>
                        
                        </div>
                    </div>
                    </div>
                    </div>
                <!--Cantidad-->
                <div>
                    <div class="row">
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>
                        
                     <!--Precio de venta-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">

                        </div>
                        <!--descuento-->
                        <div class="col-md-4 mb-2">
                            <label for="descuento" class="form-label">Descuento:</label>
                            <input type="number" name="descuento" id="descuento" class="form-control">

                        </div>
                        <!--boton agregar-->
                        <div class="col-md-12 mt-2 mb-2 text-end">
                            <button id="btn_agregar" type="button" class="btn btn-primary">Agregar</button>
                        </div>
                        <!--tabla para detalle de la venta-->
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead class="bg-primary text-white">
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio venta</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
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
                                                <th colspan="2"><input type="hidden" name="total" value="0" id="inputTotal"><span id="total">0</span></th>
                                            </tr>
                                        </tfoot>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--Boton para cancelar la venta-->
                        <div class="col-md-12 mb-2">
                            <button type="button"  class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Cancelar venta</button>
                        </div>
                    </div>
                    </div>
                </div>
               
               
                </div>
                <div class="col-md-4">
                    <!--Venta-->
                     <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row">
                        <!--Cliente-->
                        <div class="col-md-12 mb-2">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick data-live-search=true" title="Selecciona" data-size="2">
                                @foreach ($clientes as $item)
                                   <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id');
                            <small small="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--Comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick  title="Selecciona" >
                                @foreach ($comprobantes as $item)
                                   <option value="{{$item->id}}">{{$item->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                             @error('comprobante_id');
                            <small small="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--numero comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="numero_comprobante" class="form-label">Numero Comprobante:</label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                            @error('numero_comprobante');
                            <small small="text-danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--Fecha-->
                         <div class="col-md-6 mb-2">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d")?>">
                            <?php
                            use Carbon\Carbon;
                            $fecha_hora =Carbon::now()->toDateTimeString()
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                            
                        </div>
                        <!--Impuesto-->
                         <div class="col-md-6 mb-2">
                            <label for="impuesto" class="form-label">Impuesto (IVA):</label>
                            <input readonly type="text" name="impuesto" id="impuesto" class="form-control border-success">
                            @error('impuesto');
                            <small small="text-danger">{{'*'.$message}}</small>
                            @enderror
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
    <!-- Modal cancelar venta -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmacion</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Seguro que deseas cancelar la venta?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button  id="btnCancelarVenta" type="button" class="btn btn-danger"  data-bs-dismiss="modal">Confirmar</button>
      </div>
    </div>
  </div>
</div>
</form>

@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush