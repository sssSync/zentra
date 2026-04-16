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
                'name' => 'NextPointer',
                'email' => 'test@crm.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$tcev4BC9QJ4Wedq4qOyNC.jM7l3ASlpCCsQ.5MkOO0oX6fY1uMMMq',
                'role' => 'Rep',
                'remember_token' => NULL,
                'created_at' => '2026-03-20 14:08:23',
                'updated_at' => '2026-03-20 14:08:23',
            ),
        ));
        
        
    }
}