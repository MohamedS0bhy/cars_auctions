<?php

use Illuminate\Database\Seeder;
use App\User;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'admin';
        $user->password = bcrypt('admin');
        $user->email = 'admin@mail.com';
        $user->role = '1';
        $user->save();

        $user = new User();
        $user->username = 'user';
        $user->password = bcrypt('user');
        $user->email = 'user@mail.com';
        $user->role = '0';
        $user->save();
    }
}
