<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'Anonymous' user should never be logged in
        $randomPassword = bin2hex(random_bytes(16));

        User::firstOrCreate([
            'name' => 'Anonymous',
            'email' => 'anonymous@quickblog.local',
            'password' => Hash::make($randomPassword)
        ]);
    }
}
