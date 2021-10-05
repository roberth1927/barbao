<?php

use Illuminate\Database\Seeder;
use App\Models\Sistema\Empresas;
use App\Models\Sistema\Permisos\Rol;
use App\User;

class DatosInicialesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresas::create([
            'nombre' => 'Motoreste',
            'activa' => 1,
            'email' => 'sistemas@motoreste.com.co'
        ]);

        Rol::create([
            'name' => 'Administrador',
            'guard_name' => 'api'
        ]);

        User::create([
            'name' => 'Administrador del Sistema',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'activo' => 1,
            'id_empresa' => 1,
            'rol_id' => 1
        ]);

        $user = User::find(1);
        $user->assignRole('Administrador');
    }
}