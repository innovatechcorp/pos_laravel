<?php

namespace App\Http\Controllers;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
class userController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = Role::all();
        return view('user.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
        try{
            DB::beginTransaction();
            //Escribir password
            $fieldHash = Hash::make($request->password);
            //Modificar el valor password del request
            $request->merge(['password'=>$fieldHash]);
           //Crear Usuario
          $user = User::create($request->all());
           //Asignar rol
           $user->assignRole($request->role);
            DB::commit();
        }catch(Exception $e){
            DB::RollBack();
        }
        return redirect()->route('users.index')->with('success','Usuario registrado');
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
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        return view('user.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
       try{
        DB::BeginTransaction();
        //Comprobar rl password y aplicar el hash
        if (empty($request->password)) {
            $request = Arr::except($request,array('password'));
        } else {
            $fieldHash = Hash::make($request->password);
            $request->merge(['password'=>$fieldHash]);
        }
        $user->update($request->all());
        //Actualizar rol
        $user->syncRoles([$request->role]);
        
        DB::commit();
       }catch(Exception $e ){
        DB::rollBack();
       }
       return redirect()->route('users.index')->with('success','Usuario editado');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        //eliminar rol
        $rolUser = $user->getRoleNames()->first();
        $user->removeRole($rolUser);

        //eliminar usuario
        $user->delete();
        return redirect()->route('users.index')->with('success','Usuario eliminado');
    }
}
