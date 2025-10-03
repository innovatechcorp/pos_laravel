@extends('template')
 
@section('title','Crear rol')

@push('css')
<style>
    #descripcion{
        resize:none;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
                        <h1 class="mt-4 text-center">Crear Nuevo Rol</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="{{route('roles.index')}}">Roles</a></li>
                            <li class="breadcrumb-item active">Crear Nuevo Rol</li>
                        </ol>
                        <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
                            <form action="{{route('roles.store')}}" method="post">
                                @csrf
                                <div class="row g-3">
                                    <!--Nombre del rol-->
                                    <div class=" row mb-4">
                                    <label for="name" class="col-sm-2 col-form-label">Nombre del rol</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                                    </div>
                                    <div class="col-sm-6">
                                        @error('name')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                        @enderror
                                    </div>
                                    </div>
                                   
                                </div>
                                <!--Permisos-->
                                <div class="col-12 mb-4">
                                    <label for="" class="form-label">Permisos para el rol</label>
                                    @foreach ($permisos as $item)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox" name="permission[]" id="
                                            {{$item->id}}" value="{{$item->id}}">
                                            <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                                        </div>
                                         @error('permission')
                                        <small class="text-danger">{{'*'.$message}}</small>
                                        @enderror
                                    @endforeach
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