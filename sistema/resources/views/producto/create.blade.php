@extends('template')

@section('title','Crear producto')

@push('css')
<style>
    #descripcion{
        resize:none;
    }
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@section('content')
<div class="container-fluid px-4">
     <h1 class="mt-4 text-center">Crear Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item"><a href="{{route('productos.index')}}">Productos</a></li>
        <li class="breadcrumb-item active"> Crear productos</li>
    </ol>

    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('productos.store')}}" method="post">
            @csrf
            <div class="row g-3">
                <!--Codigo-->
                <div class="col-md-6 mb-2">
                    <label for="nombre">Codigo</label>
                    <input type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo')}}">
                    @error('codigo')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre')}}">
                    @error('nombre')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-12 mb-2">
                    <label for="descripcion">Descripcion</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control">{{old('descripcion')}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--Fecha de venecimiento-->
                <div class="col-md-6 mb-2">
                    <label for="fecha_vencimiento">Fecha Vencimiento</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento')}}">
                    @error('fecha_vencimiento')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--Imagen-->
                <div class="col-md-6 mb-2">
                    <label for="img_path">Imagen</label>
                    <input type="file" name="img_path" id="img_path" class="form-control" value="{{old('img_path')}}" accept="Image/*">
                    @error('img_path')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="marca_id">Marca</label>
                    <select data-live-search="true" name="marca_id" id="marca_id" class="form-control selectpicker show-tick" title="Seleccione una marca" data-size="4">
                        @foreach ($marcas as $item)
                            <option value="{{$item->id}}">{{$item->caracteristica->nombre}}</option>
                        @endforeach
                    </select>
                    @error('marca_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>

                <div class="col-md-6 mb-2">
                    <label for="presentaciones_id">Presentaciones</label>
                    <select name="presentaciones_id" id="presentaciones_id" class="form-control selectpicker show-tick">
                        @foreach ($presentaciones as $item)
                            <option value="{{$item->id}}">{{$item->caracteristica->nombre}}</option>
                        @endforeach
                    </select>
                    @error('presentaciones_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="categorias_id">Categorias</label>
                    <select name="categorias[]" id="categorias" class="form-control selectpicker show-tick" multiple>
                        @foreach ($categorias as $item)
                            <option value="{{$item->id}}">{{$item->caracteristica->nombre}}</option>
                        @endforeach
                    </select>
                    @error('categorias_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--botones-->
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>                                 
</div>
@endsection

@push('js')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush