<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Administrador',    
            'email' => 'administrador@projeto_18.com',
            'email_verified_at' => now(),
            'password' => Hash::make('102030'),            
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
