<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $data = [
            [
                'role' => 'admin'
            ],
            [
                'role' => 'user'
            ],

        ];
        foreach ($data as $role) {
            \App\Models\Role::create(
                $role
            );
        }

        \App\Models\User::create([
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('@Admin123'),
            'role_id' => 1
        ]);
    }
}
