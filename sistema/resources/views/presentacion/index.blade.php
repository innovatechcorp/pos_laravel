@extends('template')

@section('title','Crear Presentaciones')

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
                        <h1 class="mt-4 text-center">Presentaciones</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('panel')}}">inicio</a></li>
                            <li class="breadcrumb-item active">Presentaciones</li>

                        </ol>
                        <div class="mb-4">
    <a href="{{route('presentaciones.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button> </a>
    </div>
    <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Presentaciones
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripcion</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         @foreach ($presentaciones as $presentacion)
                                      <tr>
                                        <td>
                                           {{$presentacion->caracteristica->nombre}}
                                        </td>
                                        <td>
                                           {{$presentacion->caracteristica->descripcion}}
                                        </td>
                                        <td>
                                            @if ($presentacion->caracteristica->estado==1)
                                                <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                                            @else
                                                <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                                            @endif
                                        </td>

                                       <td><div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                        <td><div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            
                                                   <form action="{{route('presentaciones.edit',['presentacione'=>$presentacion])}}">
                                                        <button type="submit" class="btn btn-warning">Editar</button>
                                                    </form>
                                                    @if ($presentacion->caracteristica->estado==1)
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$presentacion->id}}">Eliminar</button>
                                                    @else
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$presentacion->id}}">Restaurar</button>
                                                    @endif
</div></td>
                                      </tr>
                                      <!-- Modal -->
<div class="modal fade" id="confirmModal-{{$presentacion->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$presentacion->caracteristica->estado==1 ? '¿Seguro  que quieres eliminar esta presentación?' : 'Seguro  que quieres restaurar esta presentación?' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <form action="{{route('presentaciones.destroy',['presentacione'=>$presentacion->id])}}" method="POST">
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