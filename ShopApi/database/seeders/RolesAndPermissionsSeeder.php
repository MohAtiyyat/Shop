<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // roles
        DB::table('roles')->insert([
            'name' => 'admin',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'user',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('roles')->insert([
            'name' => 'guest',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //permissions
        DB::table('permissions')->insert([
            'name' => 'read_products',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('permissions')->insert([
            'name' => 'update_cart',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);DB::table('permissions')->insert([
            'name' => 'crud_products',
            'guard_name' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Role has permissions
        DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 2
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 1,
            'role_id' => 3
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 2,
            'role_id' => 2
        ]);
        DB::table('role_has_permissions')->insert([
            'permission_id' => 3,
            'role_id' => 1
        ]);
        // model_has_roles
        DB::table('model_has_roles')->insert([
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1
        ]);DB::table('model_has_roles')->insert([
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 2
        ]);
    }
}
