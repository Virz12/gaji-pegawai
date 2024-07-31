<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $data_Admin = [
            [
                'username' => 'admin',
                'password' => bcrypt('admin123')
            ]
        ];

        foreach($data_Admin as $data) {
            user::create($data);
        }
    }
}
