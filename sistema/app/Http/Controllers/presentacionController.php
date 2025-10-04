<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StorePresentacionRequest;
use App\Http\Requests\UpdatePresentacionRequest;
use App\Models\Caracteristica;
use App\Models\Presentacione;

class presentacionController extends Controller
{
     function __construct(){
        $this->middleware('permission:ver-presentacione|crear-presentacione|editar-presentacione|eliminar-presentacione',['only'=>'index']);
        $this->middleware('permission:crear-presentacione',['only'=>'create','store']);
        $this->middleware('permission:editar-presentacione',['only'=>'edit','update']);
        $this->middleware('permission:eliminar-presentacione',['only'=>'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
       $presentaciones = Presentacione::with('caracteristica')->latest()->get();
     
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
    public function edit(Presentacione $presentacione)
    {
        //
         return view('presentacion.edit',['presentacione'=>$presentacione]);
  
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacionRequest $request, Presentacione $presentacione)
    {
        //
        Caracteristica::where('id',$presentacione->caracteristica->id)->update($request->validated());
       return redirect()->route('presentaciones.index')->with('success','Presentacion editada');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
         $message="";
        $presentacion = Presentacione::find($id);
       if($presentacion->caracteristica->estado==1){
         Caracteristica::where('id',$presentacion->caracteristica->id)
        ->update([
            'estado'=>0
        ]);
        $message = 'Presentacion Eliminada';
       }else{
         Caracteristica::where('id',$presentacion->caracteristica->id)
        ->update([
            'estado'=>1
        ]);
        $message = 'Presentacion Restaurada';
       }

        return redirect()->route('presentaciones.index')->with('success',$message);
    }
    }

