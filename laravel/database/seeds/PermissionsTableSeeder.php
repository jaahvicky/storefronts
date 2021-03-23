<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    protected $permissionRoles = [
        'superadmin' => [
            'admin.stores',
            'admin.moderator.products'
        ],
        'storeowner' => [
            'admin.account',
            'admin.store',
            'admin.product',
            'admin.products',
            'admin.orders'
        ],
        'storemoderator' => [
            'admin.stores'
        ],
        'productmoderator' => [
            'admin.moderator.products'
        ]
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $this->createPermissions();
        $this->assignToRoles();
    }
    
    private function createPermissions() {
        
        //Get unique permissions into one flat array
        $allPermissions = [];
        foreach($this->permissionRoles As $roleName => $permissions) {
            foreach($permissions As $permission) {
                if (!in_array($permission, $allPermissions)) {
                    $allPermissions[] = $permission;
                }
            }
        }
        
        //Create permissions
        foreach($allPermissions As $permission) {
            
            $label = ucwords(str_replace(".", " ", $permission));
            
            factory('App\Models\Permission')->create([
                'name' => $permission,
                'label' => $label
            ]);    
        }
    }
    
    private function assignToRoles() {
        
        foreach($this->permissionRoles As $roleName => $permissions) {
            
            $role = App\Models\Role::where('name', $roleName)->first();
            
            if ($role != null) {
                foreach($permissions As $permissionName) {

                    $permission = App\Models\Permission::where('name', $permissionName)->first();
                    if ($permission != null) {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}
