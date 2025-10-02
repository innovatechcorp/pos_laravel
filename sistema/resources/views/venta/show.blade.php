@extends('template')

@section('title','Ver venta')


@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
    .table {
    --bs-table-color: initial;
  }
</style>
@endpush

@section('content')
<div class="container-fluid px-5">
    <h1 class="mt-4 text-center">Ver Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('ventas.index')}}">Ver Venta</a></li>
        <li class="breadcrumb-item active"> Ver Venta</li>
    </ol>
</div>

<div class="container w-100 border-3 border-primary rounded p-4 mt-3">

    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input  disabled type="text" class="form-control" value="Tipo de comprobante:">
            </div>
        </div>
        <div class="col-sm-8">
            <input disabled type="text" class="form-control" value="{{$venta->comprobante->tipo_comprobante}}">
        </div>
    </div>
<!--numero comprobante-->
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input  disabled type="text" class="form-control" value="Numero comprobante:">
            </div>
        </div>
        <div class="col-sm-8">
            <input disabled type="text" class="form-control" value="{{$venta->numero_comprobante}}">
        </div>
    </div>
<!--proveedor-->
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input  disabled type="text" class="form-control" value="Cliente:">
            </div>
        </div>
        <div class="col-sm-8">
            <input disabled type="text" class="form-control" value="{{$venta->cliente->persona->razon_social}}">
        </div>
    </div>
    <!--usuario-->
     <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input  disabled type="text" class="form-control" value="Vendedor:">
            </div>
        </div>
        <div class="col-sm-8">
            <input disabled type="text" class="form-control" value="{{$venta->user->name}}">
        </div>
    </div>
<!--fecha-->
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input  disabled type="text" class="form-control" value="Fecha:">
            </div>
        </div>
        <div class="col-sm-8">
            <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('d-m-Y')}}">
        </div>
    </div>
    <!--hora-->
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-file"></i></span>
                <input  disabled type="text" class="form-control" value="Hora:">
            </div>
        </div>
        <div class="col-sm-8">
            <input disabled type="text" class="form-control" value="{{\Carbon\Carbon::parse($venta->fecha_hora)->format('H:i')}}">
        </div>
    </div>
    <!--Impuesto-->
    <div class="row mb-2">
        <div class="col-sm-4">
            <div class="input-group mb-3">
                <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                <input  disabled type="text" class="form-control" value="Impuesto:">
            </div>
        </div>
        <div class="col-sm-8">
            <input  id="input-impuesto" disabled type="text" class="form-control" value="{{$venta->impuesto}}">
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Detalle venta
        </div>
        <div class="card-body table-responsive">
            <table class="table table-striped">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio de venta</th>
                        <th>Descuento</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->productos as $item)
                        <tr>
                            <td>
                                {{$item->nombre}}
                            </td>
                            <td>
                                {{$item->pivot->cantidad}}
                            </td>
                            <td>
                                {{$item->pivot->precio_venta}}
                            </td>
                            <td>
                                {{$item->pivot->descuento}}
                            </td>
                            <td class="td-subtotal">
                                {{($item->pivot->cantidad)*($item->pivot->precio_venta)-($item->pivot->descuento)}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="5"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Sumas:</th>
                        <th id="th-suma"></th>
                    </tr>
                    <tr>
                        <th colspan="4">IVA:</th>
                        <th id="th-iva"></th>
                    </tr>
                    <tr>
                        <th colspan="4">Total:</th>
                        <th id="th-total"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    let filasSubtotal = document.getElementsByClassName('td-subtotal');
    let cont = 0;
    let impuesto = $('#input-impuesto').val();

    $(document).ready(function(){
        calcularValores();
    });
    
    function calcularValores(){
        for (let i = 0; i < filasSubtotal.length; i++) {
            cont += parseFloat(filasSubtotal[i].innerHTML);    
        }
        $('#th-suma').html(cont);
        $('#th-iva').html(impuesto);
        $('#th-total').html(cont+parseFloat(impuesto));
        
        
    }
</script>
@endpush

