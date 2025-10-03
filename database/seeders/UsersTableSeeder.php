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
                'password' => '$2y$10$SNVEgwt1nv2JYskgBjhpyOo5sRfaZd.Un9GEIoWS41izZFTUOHXXG',
                'remember_token' => NULL,
                'settings' => '{"locale":"es"}',
                'created_at' => '2021-06-01 21:05:11',
                'updated_at' => '2022-05-08 17:21:53',
            ),
            1 => 
            array (
                'id' => 2,
                'role_id' => 2,
                'name' => 'EL CORRAL',
                'email' => 'corral@gmail.com',
                'avatar' => 'users/default.png',
                'email_verified_at' => NULL,
                'password' => '$2y$10$Yph2qZ1vE7E/4nSMtGEjkeQbe7kgvLEQ5nVDPWngCDH0HA2WVtit.',
                'remember_token' => NULL,
                'settings' => '{"locale":"es"}',
                'created_at' => '2022-05-08 17:25:20',
                'updated_at' => '2022-05-08 17:31:35',
            ),
        ));
        
        
    }
}