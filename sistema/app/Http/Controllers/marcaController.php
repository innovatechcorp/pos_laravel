<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;

use App\Models\Caracteristica;
use App\Models\Marca;

class MarcaController extends Controller
{
     function __construct(){
        $this->middleware('permission:ver-marca|crear-marca|editar-marca|eliminar-marca',['only'=>'index']);
        $this->middleware('permission:crear-marca',['only'=>'create','store']);
        $this->middleware('permission:editar-marca',['only'=>'edit','update']);
        $this->middleware('permission:eliminar-marca',['only'=>'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $marcas = Marca::with('caracteristica')->latest()->get();
        return view('marca.index',['marcas'=>$marcas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request)
    {
        //
        
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->marca()->create([
                'caracteristica_id'=>$caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        return redirect()->route('marcas.index')->with('success','Marca registrada');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Marca $marca)
    {
        //
        return view('marca.edit',['marca'=>$marca]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        //
         Caracteristica::where('id',$marca->caracteristica->id)->update($request->validated());
       return redirect()->route('marcas.index')->with('success','Marca editada');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $message="";
        $marca = Marca::find($id);
       if($marca->caracteristica->estado==1){
         Caracteristica::where('id',$marca->caracteristica->id)
        ->update([
            'estado'=>0
        ]);
        $message = 'Marca Eliminada';
       }else{
         Caracteristica::where('id',$marca->caracteristica->id)
        ->update([
            'estado'=>1
        ]);
        $message = 'Marca Restaurada';
       }

        return redirect()->route('marcas.index')->with('success',$message);
    }
    }
