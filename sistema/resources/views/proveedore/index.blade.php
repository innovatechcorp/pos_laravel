@extends('template')

@section('title','proveedores')

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
                        <h1 class="mt-4 text-center">Proveedores</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
                            <li class="breadcrumb-item active">Proveedores</li>
                        </ol>
                        <div class="mb-4">
    <a href="{{route('proveedores.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button> </a>
    </div>
     <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Proveedores
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Direccion</th>
                                        <th>Tipo_documento</th>
                                        <th>Nro Documento</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                   </thead>
                                   <tbody>
                                    @foreach ($proveedores as $item)
                                        <tr>
                                            <td>{{$item->persona->razon_social}}</td>
                                            <td>{{$item->persona->direccion}}</td>
                                            <td>{{$item->persona->documento->tipo_documento}}</td>
                                            <td>{{$item->persona->numero_documento}}</td>
                                            <td>{{$item->persona->tipo_persona}}</td>
                                            <td>
                                        @if ($item->persona->estado==1)
                                            <span class="badge bg-success d-inline text-white">Activo</span>
                                        @else
                                             <span class="badge bg-danger d-inline text-white">Elimado</span>
                                        @endif
                    </td>
                    <td><div class="btn-group" role="group" aria-label="Basic mixed styles example">
                            <form action="{{route('proveedores.edit',['proveedore'=>$item])}}" method="GET">
                                <button type="submit" class="btn btn-warning">Editar</button>
                            </form>
                            @if ($item->persona->estado==1)
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Eliminar</button>
                            @else
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}">Restaurar</button>
                            @endif
                        
                        
                        </div>
                    </td>
                                        </tr>
                                                                                           <!-- Modal -->
<div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$item->persona->estado==1 ? '¿Seguro  que quieres eliminar este cliente?' : 'Seguro  que quieres restaurar este cliente?' }}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <form action="{{route('clientes.destroy',['cliente'=>$item->persona->id])}}" method="POST">
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