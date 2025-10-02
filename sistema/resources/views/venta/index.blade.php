@extends('template')

@section('title','Ventas')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css" rel="stylesheet" />
@endpush

@section('content')
@if (session('success'))
    <script> // script para que slaga la alerta 
        let message = "{{ session('success')}}";
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
            icon: "success",
            title: message
            });
    </script>
@endif
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">inicio</a></li>
        <li class="breadcrumb-item active">Venta</li>

    </ol>
    <div class="mb-4">
<a href="{{route('ventas.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button> </a>
</div>
<div class="card mb-4">
<div class="card-header">
    <i class="fas fa-table me-1"></i>
    Venta
</div>
<div class="card-body">
    <table id="datatablesSimple" class="table table-striped">
        <thead>
            <tr>
                <th>Comprobante</th>
                <th>Cliente</th>
                <th>Fecha y hora</th>
                <th>Usuario</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
        @foreach ($ventas as $item)
            <tr>
                <td>
                <p class="fw-semibold mb-1">{{$item->comprobante->tipo_comprobante}}</p>
                <p class="text-muted mb-0">{{$item->numero_comprobante}}</p>
                </td>
                
                <td>
                <p class="fw-semibold mb-1">{{ucfirst($item->cliente->persona->tipo_persona)}}</p>
                    <p class="text-muted mb-0">{{$item->cliente->persona->razon_social}}</p>
            </td>

            <td>
            {{
                \Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y').' '.
                \Carbon\Carbon::parse($item->fecha_hora)->format('H:i')
            }}
            </td>
            <td>
                {{$item->user->name}}
            </td>
            <td>
                {{$item->total}}
            </td>
            
            <td>
                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                    <form action="{{route('ventas.show',['venta'=>$item])}}" method="get">
                <button type="submit" class="btn btn-success">Ver</button>
                </form>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Eliminar</button>
                </div>
            </td>
            </tr>
            <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Seguro  que quieres eliminar este registro?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <form action="{{route('ventas.destroy',['venta'=>$item->id])}}" method="POST">
            @method('DELETE')
            @csrf
        <button type="submit" class="btn btn-danger">Confirmar</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endforeach
        </tbody>
        </table>
    </div>
</div>
</div>
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('js/datatables-simple-demo.js')}}"></script>
@endpush