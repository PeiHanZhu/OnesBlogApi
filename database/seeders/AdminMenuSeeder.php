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
            'users' => [
                'icon' => 'fa-group',
            ],
            'posts' => [
                'icon' => 'fa-newspaper-o'
            ],
            'comments' => [
                'icon' => 'fa-align-left',
            ],
        ] as $uri => $data) {
            Menu::firstOrCreate([
                'uri' => $uri,
            ], array_merge($data, [
                'order' => ++$maxOrder,
                'title' => ucfirst($uri),
            ]));
        }
    }
}
