<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $permissions = [
      'role-list',
      'role-create',
      'role-edit',
      'role-delete',

      'admin-list',
      'admin-create',
      'admin-edit',
      'admin-delete',    

      'user-list',
      'user-create',
      'user-edit',
      'user-delete',     

      'post-list',
      'post-create',
      'post-edit',
      'post-delete',     

      'product-list',
      'product-create',
      'product-edit',
      'product-delete',

      'product-brand',
      'product-category',
      'product-varient',
      'product-tags',
      'label-print',
      'stock',
      'barcode',

      'order-list',
      'order-edit',
      'order-delete',

      'settings',
    ];

    foreach ($permissions as $permission) {
      Permission::create(['name' => $permission, 'guard_name' => 'admin']);
    }
  }
}
