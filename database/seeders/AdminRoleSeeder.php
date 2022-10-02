<?php

namespace Database\Seeders;

use Encore\Admin\Auth\Database\Role;
use Illuminate\Database\Seeder;

class AdminRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach([
            'administrator' => [
                'name' => 'Administrator',
            ],
            'assistant' => [
                'name' => 'Assistant',
            ]
        ] as $slug => $data) {
            Role::firstOrCreate([
                'slug' => $slug,
            ], $data);
        };
    }
}
