@extends('template')
 
@section('title','Editar cliente')

@push('css')

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
    <h1 class="mt-4 text-center">Editar Cliente</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('clientes.index')}}">Cliente</a></li>
        <li class="breadcrumb-item active"> Editar Cliente</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
<form action="{{route('clientes.update',['cliente'=>$cliente])}}" method="post">
    @method('PATCH')
    @csrf
    <div class="row g-3">
        <!--Tipo de cliente-->
        <div class="col-md-6">
            <label for="tipo_persona" class="form-label">Tipo de cliente: <span class="fw-bold">{{strtoupper($cliente->persona->tipo_persona)}}</span></label>
            
            
        </div>
                <!--Razon social-->
                <div class="col-md-12 mb-2" id="box-razon-social">
                    @if ($cliente->persona->tipo_persona=='natural')
                       <label id="label-natural" name='razon_social' class="form-label" for="">Nombres y apellidos</label> 
                    @else
                        <label id="label-juridica" name='razon_social' class="form-label" for="">Nombre de la empresa</label>
                    @endif
                    
                    

                    <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social',$cliente->persona->razon_social)}}">
                    @error('razon_social')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
            
            <!--Direccion-->
            <div class="col-md-12 mb-2">
                <label for="direccion" class="form-label">Direccion:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion',$cliente->persona->direccion)}}">
                @error('direccion')
                <small class="text-danger">{{'*'.$message}}</small>
                @enderror
            </div>
            <!--Documento-->
            <div class="col-md-6">
            <label for="documento_id" class="form-label">Tipo de Documento:</label>
            <select class="form-select" name="documento_id" id="documento_id">
                @foreach ( $documentos as $item )
                @if ($cliente->persona->id ==$item->id)
                     <option selected value="{{$item->id}}" {{old('documento_id')==$item->id}}>{{$item->tipo_documento}}</option>
                @else
                     <option value="{{$item->id}}" {{old('documento_id')==$item->id}}>{{$item->tipo_documento}}</option>
                @endif
                   
                @endforeach
            </select>
            @error('documento_id')
                <small class="text-danger">{{'*'.$message}}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="numero_documento" class="form-label">Nro Documento:</label>
            <input class="form-control" name="numero_documento" id="numero_documento" value="{{old('numero_documento',$cliente->persona->numero_documento)}}">
                @error('numero_documento')
                <small class="text-danger">{{'*'.$message}}</small>
            @enderror
        </div>
            <br>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            
        </form>
    </div>
</div>
@endsection

@push('js')

@endpush