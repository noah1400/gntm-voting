<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
// Hash
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
        // create new User
        // email: robin.sauerzapf@web.de
        // password: Ledersessel1234!
        // name: Robin Sauerzapf

        //check if user already exists
        if (User::where('email', '=', 'robin.sauerzapf@web.de')->exists()) {
            return;
        }

        $user = new User();
        $user->name = 'Robin Sauerzapf';
        $user->email = 'robin.sauerzapf@web.de';
        $user->password = Hash::make('Ledersessel1234!');
        $user->save();

    }
}
