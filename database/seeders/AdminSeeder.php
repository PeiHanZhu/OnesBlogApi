<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Menu;
use Encore\Admin\Auth\Database\Permission;
use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminMenuSeeder::class,
            AdminPermissionSeeder::class,
            AdminRoleSeeder::class,
        ]);

        $rolePermissions = [
            'administrator' => ['*'],
            'assistant' => [
                'dashboard',
                'auth.login',
                'auth.setting',
                'assistant',
            ],
        ];
        $permissions = Permission::whereIn(
            'slug',
            array_unique(Arr::flatten(array_values($rolePermissions)))
        )->pluck('id', 'slug');
        $roles = Role::whereIn('slug', array_keys($rolePermissions))->get();
        foreach ($rolePermissions as $roleSlug => $permissionSlugs) {
            is_null($role = $roles->firstWhere('slug', $roleSlug))
                ?: $role->permissions()->syncWithoutDetaching($permissions->only($permissionSlugs));
        }

        $menuRoles = [
            'auth' => ['administrator'],
        ];
        $roles = Role::whereIn(
            'slug',
            array_unique(Arr::flatten(array_values($menuRoles)))
        )->pluck('id', 'slug');
        $menus = Menu::whereIn('uri', array_keys($menuRoles))->get();
        foreach ($menuRoles as $menuUri => $roleSlugs) {
            is_null($menu = $menus->firstWhere('uri', $menuUri))
                ?: $menu->roles()->syncWithoutDetaching($roles->only($roleSlugs));
        }
    }
}
