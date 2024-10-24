<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $admin_role = \Spatie\Permission\Models\Role::create(['name' => 'admin']);
        $user_role = \Spatie\Permission\Models\Role::create(['name' => 'user']);
        $guest_role = \Spatie\Permission\Models\Role::create(['name' => 'guest']);
        $read_product_permission = \Spatie\Permission\Models\Permission::create(['name' => 'read_product']);
        $update_cart_permission = \Spatie\Permission\Models\Permission::create(['name' => 'update_cart']);
        $crud_product_permission = \Spatie\Permission\Models\Permission::create(['name' => 'crud_product']);
        $admin_role->givePermissionTo($crud_product_permission);
        $user_role->givePermissionTo($update_cart_permission,$read_product_permission);
        $guest_role->givePermissionTo($read_product_permission);

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
