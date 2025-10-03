<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$ILLZfhsbwinK3235ceVa7O0mj3M5fr33wb3z28aDqiBWLwBfSUzYy',
                'remember_token' => NULL,
                'settings' => '{"locale":"es"}',
                'created_at' => '2021-06-01 21:05:11',
                'updated_at' => '2022-05-08 17:21:53',
            ),
        ));
        
        
    }
}