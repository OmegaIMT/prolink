<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = 'admin@bs.com';

        if (!User::where('email', $email)->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'username' => 'admin',
                'password' => bcrypt('bs1234'),
            ]);
        }
    }
}
