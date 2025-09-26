@extends('template')

@section('title','clientes')

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
                        <h1 class="mt-4 text-center">Clientes</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
                            <li class="breadcrumb-item active">clientes</li>
                        </ol>
                        <div class="mb-4">
    <a href="{{route('clientes.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button> </a>
    </div>
     <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Clientes
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
                                    @foreach ($clientes as $item)
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
                                                    <form action="{{route('clientes.edit',['cliente'=>$item])}}" method="GET">
                                                        <button type="submit" class="btn btn-warning">Editar</button>
                                                    </form>
                                                    @if ($item->persona->estado==1)
                                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal">Eliminar</button>
                                                    @else
                                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmModal">Restaurar</button>
                                                    @endif
                                                
                                                
                                                </div>
                                            </td>
                                        </tr>
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