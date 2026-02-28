<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Brand;
use App\Models\Permission;
use App\Models\RoleBrandPermission;

class InitialDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Roles
        $roles = [
            'admin' => 'Administrador de Sistemas',
            'gestor' => 'Gestor de Operaciones',
            'tecnico' => 'Personal Técnico',
            'consultor' => 'Consultor Externo',
            'm-project' => 'Project Manager',
        ];

        foreach ($roles as $slug => $name) {
            Role::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // 2. Brands
        $brands = [
            'marca1' => 'Marca 1',
            'marca2' => 'Marca 2',
            'marca3' => 'Marca 3',
            'marca4' => 'Marca 4',
            'marca5' => 'Marca 5',
            'marca6' => 'Marca 6',
        ];

        foreach ($brands as $slug => $name) {
            Brand::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // 3. Permissions (Slugs match HTML IDs)
        $permissions = [
            'permiso-nube' => 'Acceso Cloud Storage',
            'permiso-vpn' => 'Acceso VPN Corporativa',
            'permiso-ventas' => 'Acceso a aplicación de ventas',
            'permiso-laboral' => 'Acceso a aplicación de gestión laboral',
            'telefono-movil' => 'Teléfono Movil',
            'correo-electronico' => 'Correo Electrónico',
            'v-empresa' => 'Vehículo empresa',
            'o-empresa' => 'Ordenador de sobremesa',
            'o-portatil' => 'Ordenador portátil',
            'monitor' => 'Monitor',
            'impresora' => 'Impresora',
        ];

        foreach ($permissions as $slug => $name) {
            Permission::firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        // 4. Matrix (Initial Configuration)
        // 'admin':
        //    'marca1': ['permiso-nube', 'permiso-vpn', 'permiso-ventas', 'permiso-laboral', 'correo-electronico', 'o-portatil'],
        //    'marca2': ['permiso-nube', 'permiso-vpn']

        $matrix = [
            'admin' => [
                'marca1' => ['permiso-nube', 'permiso-vpn', 'permiso-ventas', 'permiso-laboral', 'correo-electronico', 'o-portatil'],
                'marca2' => ['permiso-nube', 'permiso-vpn']
            ],
            'gestor' => [
                'marca1' => ['permiso-ventas', 'permiso-laboral'],
                'marca2' => ['permiso-ventas']
            ],
            'tecnico' => [
                'marca1' => ['permiso-vpn', 'permiso-laboral'],
                'marca3' => ['permiso-vpn']
            ],
            'consultor' => [
                'marca1' => ['permiso-nube'],
                'marca2' => ['permiso-nube']
            ],
            'm-project' => [
                'marca1' => ['permiso-nube', 'permiso-ventas'],
                'marca2' => ['permiso-nube']
            ]
        ];

        foreach ($matrix as $roleSlug => $brandsConfig) {
            $role = Role::where('slug', $roleSlug)->first();
            if (!$role)
                continue;

            foreach ($brandsConfig as $brandSlug => $permSlugs) {
                $brand = Brand::where('slug', $brandSlug)->first();
                if (!$brand)
                    continue;

                foreach ($permSlugs as $permSlug) {
                    $permission = Permission::where('slug', $permSlug)->first();
                    if (!$permission)
                        continue;

                    RoleBrandPermission::firstOrCreate([
                        'role_id' => $role->id,
                        'brand_id' => $brand->id,
                        'permission_id' => $permission->id,
                    ]);
                }
            }
        }
    }
}
