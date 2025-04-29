<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Limpa cache de permissões
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'gerenciar eventos',
            'visualizar eventos',
            'realizar pagamentos',
            'gerenciar usuarios' 
            ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $produtor = Role::firstOrCreate(['name' => 'produtor']);
        $cliente = Role::firstOrCreate(['name' => 'cliente']);

        // Admin pode tudo
        $admin->syncPermissions(Permission::all());

        // Produtor pode gerenciar e visualizar eventos
        $produtor->syncPermissions([
            'gerenciar eventos',
            'visualizar eventos',
        ]);

        // Cliente pode apenas visualizar e comprar tickets
        $cliente->syncPermissions([
            'visualizar eventos',
            'realizar pagamentos',
        ]);
    }
}
