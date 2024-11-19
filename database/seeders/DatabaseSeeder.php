<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $usersData = [
            ['name' => 'Admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('11221122')],
            ['name' => 'Ari Zainal Fauziah', 'email' => 'arizainalf@gmail.com', 'password' => bcrypt('11221122')],
            ['name' => 'Ihsan Maulana', 'email' => 'ihsanm@gmail.com', 'password' => bcrypt('11221122')],
        ];
        DB::table('users')->insert($usersData);
    }
}
