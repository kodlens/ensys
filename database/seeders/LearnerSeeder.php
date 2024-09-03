<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LearnerSeeder extends Seeder
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
            //JHS
            [
                'student_id' => '20240001',
                'academic_year_id' => 1,
                'grade_level' => 'GRADE 11',
                'balik_aral' => 'NO',
                'lrn' => '20221123231',
                'psa' => '',
                'lname' => 'AMPARADO',
                'fname' => 'ESHEN',
                'mname' => '',
                'extension' => '',
                'sex' => 'MALE',
                'birthdate' => '2000-01-20',
                'birthplace' => 'TANGUB, MISAMIS OCCIDENTAL',
                'age' => '22',

                'current_province' => '1602',
                'current_city' => '160203',
                'current_barangay' => '160203010',
                'current_street' => '',
                'current_zipcode' => null,

                'permanent_province' => '1602',
                'permanent_city' => '160203',
                'permanent_barangay' => '160203010',
                'permanent_street' => '',
                'permanent_zipcode' => null,

                'father_lname' => 'AMPZ',
                'father_fname' => 'JOHN',
                'father_mname' => '',
                'father_extension' => '',
                'father_contact_no' => '09161231234',

                'mother_maiden_lname' => 'MAIDEN AMPZ',
                'mother_maiden_fname' => 'JANE',
                'mother_maiden_mname' => '',
                'mother_maiden_contact_no' => '09161231235',

                'guardian_lname' => 'DELA CRUZ',
                'guardian_fname' => 'JUAN',
                'guardian_mname' => '',
                'guardian_contact_no' => '09161231235',

                'semester_id' => 1,
                'track_id' => 1,
                'strand_id' => 4,
                'administer_by' => 'ADMIN',
            ],

            [
                'student_id' => '20240001',
                'academic_year_id' => 1,
                'grade_level' => 'GRADE 12',
                'balik_aral' => 'NO',
                'lrn' => '202211343231',
                'psa' => '',
                'lname' => 'CAGADAS',
                'fname' => 'JOHN MICHAEL',
                'mname' => '',
                'extension' => '',
                'sex' => 'MALE',
                'birthdate' => '2000-01-20',
                'birthplace' => 'TANGUB CITY, MISAMIS OCCIDENTAL',
                'age' => '22',

                'current_province' => '1602',
                'current_city' => '160203',
                'current_barangay' => '160203010',
                'current_street' => '',
                'current_zipcode' => null,

                'permanent_province' => '1602',
                'permanent_city' => '160203',
                'permanent_barangay' => '160203010',
                'permanent_street' => '',
                'permanent_zipcode' => null,

                'father_lname' => 'CAGADAS',
                'father_fname' => 'JUAN',
                'father_mname' => '',
                'father_extension' => '',
                'father_contact_no' => '09161231234',

                'mother_maiden_lname' => 'CLARA',
                'mother_maiden_fname' => 'JANE',
                'mother_maiden_mname' => '',
                'mother_maiden_contact_no' => '09161231235',

                'guardian_lname' => 'DELA CRUZ',
                'guardian_fname' => 'JUAN',
                'guardian_mname' => '',
                'guardian_contact_no' => '09161231235',

                'semester_id' => 1,
                'track_id' => 1,
                'strand_id' => 4,
                'administer_by' => 'ADMIN',
            ],

        ];

        \App\Models\Learner::insertOrIgnore($data);
    }
}
