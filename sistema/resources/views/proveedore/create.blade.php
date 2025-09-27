@extends('template')
 
@section('title','Crear proveedores')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
   #box-razon-social{
    display: none;
   }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Proveedores</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('proveedores.index')}}">Proveedores</a></li>
        <li class="breadcrumb-item active"> Crear Proveedores</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
<form action="{{route('proveedores.store')}}" method="post">
    @csrf
    <div class="row g-3">
        <!--Tipo de persona-->
        <div class="col-md-6">
            <label for="tipo_persona" class="form-label">Tipo de proveedor:</label>
            <select class="form-select" name="tipo_persona" id="tipo_persona">
                <option selected disable value="">Selecciona una opcion</option>
                <option  value="natural" {{old('tipo_persona')=='natural' ? 'selected' : ''}}>Persona natural</option>
                <option  value="juridica" {{old('tipo_persona')=='juridica' ? 'selected' : ''}}>Persona juridica</option>
            </select>
            @error('tipo_persona')
                <small class="text-danger">{{'*'.$message}}</small>
            @enderror
        </div>
                <!--Razon social-->
                <div class="col-md-12 mb-2" id="box-razon-social">
                    <label id="label-natural" name='razon_social' class="form-label" for="">Nombres y apellidos</label>
                    <label id="label-juridica" name='razon_social' class="form-label" for="">Nombre de la empresa</label>

                    <input type="text" name="razon_social" id="razon_social" class="form-control" value="{{old('razon_social')}}">
                    @error('razon_social')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
            
            <!--Direccion-->
            <div class="col-md-12 mb-2">
                <label for="direccion" class="form-label">Direccion:</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="{{old('direccion')}}">
                @error('direccion')
                <small class="text-danger">{{'*'.$message}}</small>
                @enderror
            </div>
            <!--tipo de dodumento-->
            <div class="col-md-6">
            <label for="documento_id" class="form-label">Tipo de Documento:</label>
            <select class="form-select" name="documento_id" id="documento_id">
                <option value="" selected disabled>Seleccione una opcion</option>
                @foreach ( $documentos as $item )
                    <option value="{{$item->id}}">{{$item->tipo_documento}}</option>
                @endforeach
            </select>
            @error('documento_id')
                <small class="text-danger">{{'*'.$message}}</small>
            @enderror
        </div>

        <div class="col-md-6">
            <label for="numero_documento" class="form-label">Nro Documento:</label>
            <input class="form-control" name="numero_documento" id="numero_documento" value="{{old('numero_documento')}}">
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
<script>
$(document).ready(function(){
    $('#tipo_persona').on('change',function(){
        let SelectValue = $(this).val();
        if(SelectValue=='natural'){
            $('#label-juridica').hide();
            $('#label-natural').show();
        }else{
            $('#label-natural').hide();
             $('#label-juridica').show();
        }
        $('#box-razon-social').show();
    });
});
</script>
@endpush