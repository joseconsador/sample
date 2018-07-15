<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $admin = Role::create(['name' => 'admin']);
        $owner = Role::create(['name' => 'owner']);
        $user = Role::create(['name' => 'user']);

        $createRestaurant = Permission::create(['name' => 'create-restaurant']);
        $createRestaurant->assignRole([$admin, $owner]);

        $editRestaurant = Permission::create(['name' => 'edit-restaurant']);
        $editRestaurant->assignRole([$admin, $owner]);

        $reviewRestaurant = Permission::create(['name' => 'review-restaurant']);
        $reviewRestaurant->assignRole([$admin, $user]);

        $deleteRestaurant = Permission::create(['name' => 'delete-restaurant']);
        $deleteRestaurant->assignRole([$admin, $owner]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
