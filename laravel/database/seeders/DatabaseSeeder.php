<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Sampah;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Admin',
            ],
            [
                'name' => 'User',
            ],
        ];

        Role::insert($data);

        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => 1,
            ],
            [
                'name' => 'User 1',
                'email' => 'user1@example.com',
                'password' => bcrypt('password'),
                'role_id' => 2,
            ],
            [
                'name' => 'User 2',
                'email' => 'user2@example.com',
                'password' => bcrypt('password'),
                'role_id' => 2,
            ],
        ];

        User::insert($data);

        $data = [
            [
                'name' => 'Plastik',
                'harga' => '500',
                'jumlah_satuan' => '1.00',
                'satuan' => 'kg',
            ],
            [
                'name' => 'Kertas',
                'harga' => '300',
                'jumlah_satuan' => '1.00',
                'satuan' => 'kg',
            ],
            [
                'name' => 'Logam',
                'harga' => '500',
                'jumlah_satuan' => '1.00',
                'satuan' => 'kg',
            ],
        ];

        Sampah::insert($data);
    }
}
