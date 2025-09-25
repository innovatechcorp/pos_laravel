@extends('template')

@section('title','productos')

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
    <h1 class="mt-4 text-center">Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">inicio</a></li>
        <li class="breadcrumb-item active">Producto</li>

    </ol>
    <div class="mb-4">
<a href="{{route('productos.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button> </a>
</div>
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Productos
    </div>
    <div class="card-body">
        <table id="datatablesSimple" class="table table-striped">
            <thead>
                <tr>
                    <th>Codigo</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Presentacion</th>
                    <th>Categoria</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $item)
                    <tr>
                        <td>{{$item->codigo}}</td>
                        <td>{{$item->nombre}}</td>
                        <td>{{$item->marca->caracteristica->nombre}}</td>
                        <td>{{$item->presentacione->caracteristica->nombre}}</td>
                        <td>
                            @foreach ($item->categorias as $category )
                                <div class="container">
                                    <div class="row">
                                        <span class="m-1 rounded-pill p-1 bg-secondary text-white text-center">{{$category->caracteristica->nombre}}</span>
                                    </div>
                                </div>
                            @endforeach
                        </td>
                        <td>
                            @if ($item->estado==1)
                                <span class="fw-bolder rounded p-1 bg-success text-white">ACTIVO</span>
                            @else
                                <span class="fw-bolder rounded p-1 bg-danger text-white">ELIMINADO</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('productos.edit',['producto'=>$item])}}" method="get">
                            <button type="submit" class="btn btn-warning">Editar</button>
                            </form>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#verModal-{{$item->id}}">Ver</button>
                            @if ($item->estado==1)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Eliminar</button>
                            @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Restaurar</button>
                            @endif
                            
                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                <div class="modal fade" id="verModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Detalles del producto</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="descripcion"><span class="fw-bolder"> Descripcion:</span>   {{$item->descripcion}}</label>
                        </div>
                        <div class="row mb-3">
                        <label for="fecha_vencimiento"><span class="fw-bolder"> Fecha de vencimiento:</span> {{$item->fecha_vencimiento=='' ? 'No posee' : $item->fecha_vencimiento}}</label>
                        </div>
                        <div class="row mb-3">
                            <label for=""><span class="fw-bolder">Stock:</span> {{$item->stock}}</label>
                        </div>
                        <div class="row mb-3">
                            <label  class="fw-bolder">Imagen:</label>
                            <div>
                                @if ($item->img_path != null)
                                    <img src="{{Storage::url('public/productos/'.$item->img_path)}}" alt="$item->nombre" class="img-fluid img-thumbnail border border-4 rounded">
                                @else
                                    <img src="" alt="{{$item->nombre}}">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                    </div>
                </div>
                </div>
                
                                                   <!-- Modal -->
<div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$item->estado==1 ? '¿Seguro  que quieres eliminar este producto?' : 'Seguro  que quieres restaurar este producto?' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <form action="{{route('productos.destroy',['producto'=>$item->id])}}" method="POST">
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('js/datatables-simple-demo.js')}}"></script>
@endpush