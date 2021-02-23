<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(PermissionSeeder::class);
        $permissions = Permission::where('guard_name', 'admin')->pluck('id');
        $this->command->info('permission seeder finished');
        $role = Role::factory()->create(['name' => 'admin', 'label_en' => 'admin', 'label_ar' => 'admin']);
        $this->command->info('super admin creation finished');
        $this->command->info('adding all permissions to role');

        $role->first()->syncPermissions($permissions);
        $this->command->info('finish adding all permissions to role');

        $this->command->info('create admin ');

        $admin = Admin::factory()->create();


        $this->command->info('add role to admin');
        $this->command->table(['email', 'password'], [[$admin->email, 'password']]);
        $admin->first()->syncRoles($role->id);
        $this->command->info('done');

        // \App\Models\User::factory(10)->create();
    }
}
