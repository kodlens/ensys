<?php

namespace Database\Seeders;

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
        //
        $data = [
            [
                'username' => 'admin',
                'lname' => 'LABAJO',
                'fname' => 'MAYISEL',
                'mname' => 'P',
                'sex' => 'FEMALE',
                //'email' => 'mayesel@dev.com',
                'role' => 'ADMINISTRATOR',
                'password' => Hash::make('ensys!2023')
            ],

   



     
        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
