<?php

namespace App\Http\Controllers;
use App\Models\Proveedore;
use App\Models\Documento;
use App\Models\Persona;
use Illuminate\Http\Request;
use App\Http\Requests\StorePersonaRequest;
use Illuminate\Support\Facades\DB;

class ProveedoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $proveedores= Proveedore::with('persona.documento')->get();
        return view('proveedore.index',compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $documentos=Documento::all();
        return view('proveedore.create',compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonaRequest $request)
    {
        //
        try{
            DB::beginTransaction();
            $persona = Persona::create($request->validated());
            $persona->proveedore()->create([
                'persona_id'=>$persona->id
            ]);
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
        return redirect()->route('proveedores.index')->with('success','Proveedor registrado');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
