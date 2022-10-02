<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Menu;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $maxOrder = Menu::max('order');
        foreach ([
            '/' => [
                'title' => 'Dashboard',
                'icon' => 'fa-bar-chart',
            ],
            'auth' => [
                'title' => 'Admin',
                'icon' => 'fa-tasks',
            ],
            'auth/users' => [
                'parent_id' => 2,
                'title' => 'Users',
                'icon' => 'fa-users',
            ],
            'auth/roles' => [
                'parent_id' => 2,
                'title' => 'Roles',
                'icon' => 'fa-user',
            ],
            'auth/permissions' => [
                'parent_id' => 2,
                'title' => 'Permission',
                'icon' => 'fa-ban',
            ],
            'auth/menu' => [
                'parent_id' => 2,
                'title' => 'Menu',
                'icon' => 'fa-bars',
            ],
            'auth/logs' => [
                'parent_id' => 2,
                'title' => 'Operation log',
                'icon' => 'fa-history',
            ],
            'users' => [
                'icon' => 'fa-group',
            ],
            'locations' => [
                'icon' => 'fa-map-marker',
            ],
            'posts' => [
                'icon' => 'fa-newspaper-o'
            ],
            'comments' => [
                'icon' => 'fa-align-left',
            ],
            'cities' => [
                'icon' => 'fa-info-circle',
            ],
            'media' => [
                'icon' => 'fa-file',
            ],
        ] as $uri => $data) {
            Menu::firstOrCreate([
                'uri' => $uri,
            ], array_merge($data, [
                'order' => ++$maxOrder,
                'title' => $data['title'] ?? ucfirst($uri),
            ]));
        }
    }
}
