<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; // ¡CLAVE: Importar esta clase!
class roleController extends Controller
{
     function __construct(){
        $this->middleware('permission:ver-role|crear-role|editar-proveedore|eliminar-role',['only'=>'index']);
        $this->middleware('permission:crear-role',['only'=>'create','store']);
        $this->middleware('permission:editar-role',['only'=>'edit','update']);
        $this->middleware('permission:eliminar-role',['only'=>'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('role.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $permisos = Permission::all();
        return view('role.create',compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // 1. Validar la solicitud
    $request->validate([
        'name' => 'required|unique:roles,name',
        'permission' => 'required|array', // Aseguramos que 'permission' sea un array
        'permission.*' => 'numeric' // Aseguramos que cada elemento sea numérico
    ]);
    
    // 2. Preparar los IDs de permiso
    // **SOLUCIÓN PRINCIPAL:** Convertimos los IDs de permiso (que vienen como strings del formulario) 
    // a enteros (integers) para evitar el error de Spatie.
    $permissions = collect($request->permission)
        ->map(fn($id) => (int)$id) // Convierte cada ID a entero
        ->toArray();

    try {
        DB::beginTransaction();
        
        // 3. Crear el rol
        $rol = Role::create(['name' => $request->name]);

        // 4. Asignar/Sincronizar permisos
        // Usamos el array de IDs de permiso convertidos
        $rol->syncPermissions($permissions);

        DB::commit();

        return redirect()->route('roles.index')->with('success', 'Rol registrado exitosamente.');

    } catch (Exception $e) {
        DB::rollBack();
        
        // Es buena práctica registrar el error para debugging
        \Log::error("Error al crear rol y asignar permisos: " . $e->getMessage());

        // Devolvemos al usuario con un mensaje de error
        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Hubo un error al registrar el rol. Inténtalo de nuevo.');
    }
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
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('role.edit',compact('role','permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, Role $role) // <-- Parámetro ajustado a $role
{
    // 1. Validar la solicitud
    $request->validate([
        'name' => [
            'required',
            // Solución: La regla 'unique' ignora el ID del rol actual ($role->id)
            Rule::unique('roles', 'name')->ignore($role->id), 
        ],
        'permission' => 'required|array',
        'permission.*' => 'numeric'
    ]);
    
    // 2. Preparar los IDs de permiso
    $permissions = collect($request->permission)
        ->map(fn($id) => (int)$id)
        ->toArray();

    try {
        DB::beginTransaction();
        
        // 3. Actualizar el rol
        $role->update(['name' => $request->name]); // Usamos $role en lugar de $rol

        // 4. Sincronizar permisos
        $role->syncPermissions($permissions); // Usamos $role en lugar de $rol

        DB::commit();

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');

    } catch (Exception $e) {
        DB::rollBack();
        
        \Log::error("Error al actualizar rol y sincronizar permisos: " . $e->getMessage());

        return redirect()->back()
                         ->withInput()
                         ->with('error', 'Hubo un error al actualizar el rol. Inténtalo de nuevo.');
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Role::where('id',$id)->delete();

        return redirect()->route('roles.index')->with('success','Rol eliminado');
    }
}
