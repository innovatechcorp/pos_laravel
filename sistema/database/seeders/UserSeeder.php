<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
       $user = User::create([
    // ¡SIN el array externo!
    'name' => 'prueba',
    'email' => 'admin@gmail.com',
    'password' => bcrypt('password')
]);


$rol = Role::create(['name' => 'administrador']);
$permisos = Permission::pluck('id', 'id')->all();
$rol->syncPermissions($permisos);
$user->assignRole('administrador');
    }
}
