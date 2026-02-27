<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RbacSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1️⃣ Criar Roles (se não existirem)
        |--------------------------------------------------------------------------
        */

        $adminRole = Role::firstOrCreate(['name' => 'ADMIN']);
        $userRole  = Role::firstOrCreate(['name' => 'USER']);

        /*
        |--------------------------------------------------------------------------
        | 2️⃣ Criar Permissions
        |--------------------------------------------------------------------------
        */

        $createUser = Permission::firstOrCreate(['name' => 'create_user']);
        $deleteUser = Permission::firstOrCreate(['name' => 'delete_user']);
        $viewUser   = Permission::firstOrCreate(['name' => 'view_user']);

        /*
        |--------------------------------------------------------------------------
        | 3️⃣ Associar permissões ao ADMIN
        |--------------------------------------------------------------------------
        */

        $adminRole->permissions()->syncWithoutDetaching([
            $createUser->id,
            $deleteUser->id,
            $viewUser->id,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 4️⃣ Associar permissões básicas ao USER
        |--------------------------------------------------------------------------
        */

        $userRole->permissions()->syncWithoutDetaching([
            $viewUser->id
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5️⃣ Vincular role ADMIN ao usuário admin@teste.com
        |--------------------------------------------------------------------------
        */

        $adminUser = User::where('email', 'admin@teste.com')->first();

        if ($adminUser) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }
    }
}