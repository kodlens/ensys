<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
           $data = [
            [
                'group_name' => 'GROUP 1',
                'active' => 1,
            ],
            [
                'group_name' => 'GROUP 1',
                'active' => 1,
            ],
            
           
        ];

        \App\Models\Group::insertOrIgnore($data);
    }
}
