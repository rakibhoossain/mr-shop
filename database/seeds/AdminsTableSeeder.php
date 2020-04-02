<?php

use App\Admin;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $admin = Admin::create([
            'name'      =>  $faker->name,
            'email'     =>  'super@admin.com',
            'password'  =>  bcrypt('12345678'),
        ]);

        $role = Role::create(['name' => 'Admin', 'guard_name' => 'admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $admin->assignRole([$role->id]);
    }
}
