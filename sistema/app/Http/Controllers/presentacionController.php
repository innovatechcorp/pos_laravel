<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePresentacionRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;

class presentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
       $presentaciones = Presentacione::with('caracteristica')->get();
     
         return view('presentacion.index',['presentaciones'=>$presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('presentacion.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionRequest $request)
    {
        //
        // dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentaciones()->create([
                'caracteristica_id'=>$caracteristica->id
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
        }
        return redirect()->route('presentaciones.index')->with('success','Presentacion registrada');
    
       
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
