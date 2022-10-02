<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Permission;
use Illuminate\Database\Seeder;

class AdminPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ([
            '*' => [
                'name' => 'All permission',
                'http_method' => '',
                'http_path' => '*',
            ],
            'dashboard' => [
                'name' => 'Dashboard',
                'http_method' => 'GET',
                'http_path' => '/',
            ],
            'auth.login' => [
                'name' => 'Login',
                'http_method' => '',
                'http_path' => implode("\r\n", ['/auth/login', '/auth/logout']),
            ],
            'auth.setting' => [
                'name'  => 'User setting',
                'http_method' => 'GET,PUT',
                'http_path' => '/auth/setting',
            ],
            'auth.management' => [
                'name' => 'Auth management',
                'http_method' => '',
                'http_path' => implode("\r\n", ['/auth/roles', '/auth/permissions', '/auth/menu', '/auth/logs']),
            ],
            'assistant' => [
                'name' => 'Assistant',
                'http_method' => '',
                'http_path' => implode("\r\n", ['/users*', '/locations*', '/posts*', '/comments*', '/cities*', '/media*']),
            ],
        ] as $slug => $data) {
            Permission::firstOrCreate([
                'slug' => $slug,
            ], $data);
        };
    }
}
