@extends('template')

@section('title','compra')

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
                        <h1 class="mt-4 text-center">Compra</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('panel')}}">inicio</a></li>
                            <li class="breadcrumb-item active">Compra</li>

                        </ol>
                        <div class="mb-4">
    <a href="{{route('compras.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button> </a>
    </div>
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-table me-1"></i>
                                Compra
                            </div>
                            <div class="card-body">
                                <table id="datatablesSimple" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Comprobante</th>
                                            <th>Proveedor</th>
                                            <th>Fecha y hora</th>
                                            <th>Total</th>
                                            <th>Acciones</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                    @foreach ($compras as $item)
                                        <tr>
                                            <td>
                                            <p class="fw-semibold mb-1">{{$item->comprobante->tipo_comprobante}}</p>
                                            <p class="text-muted mb-0">{{$item->numero_comprobante}}</p>
                                            </td>
                                            
                                            <td>
                                            <p class="fw-semibold mb-1">{{ucfirst($item->proveedore->persona->tipo_persona)}}</p>
                                                <p class="text-muted mb-0">{{$item->proveedore->persona->razon_social}}</p>
                                        </td>

                                        <td>
                                        {{
                                            \Carbon\Carbon::parse($item->fecha_hora)->format('d-m-Y').' '.
                                            \Carbon\Carbon::parse($item->fecha_hora)->format('H:i')
                                        }}
                                        </td>
                                        <td>
                                            {{$item->total}}
                                        </td>
                                        
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <button type="button" class="btn btn-danger">Left</button>
                                            <button type="button" class="btn btn-warning">Middle</button>
                                            <button type="button" class="btn btn-success">Right</button>
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