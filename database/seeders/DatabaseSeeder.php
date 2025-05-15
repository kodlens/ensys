<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserSeeder::class,
            AcademicYearSeeder::class,
            TrackSeeder::class,
            SemesterSeeder::class,
            StrandSeeder::class,
            GradeLevelSeeder::class,
            ReligionSeeder::class,
            SubjectSeeder::class,
            SectionSeeder::class,
            CurriculumSeeder::class,
            GradeLevelSubjectSeeder::class,
            LearnerSeeder::class,
            OtherFeeSeeder::class,
            GroupSeeder::class
        ]);
    }
}
