<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learner extends Model
{
    use HasFactory;


    protected $table = 'learners';
    protected $primaryKey = 'learner_id';

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'grade_level',
        'learner_status',
        'balik_aral',
        'psa',
        'lrn',
       
        'lname',
        'fname',
        'mname',
        'extension',
        'sex',
        'birthdate',
        'birthplace',
        'age',

        'mother_tongue',

        'is_indigenous',
        'if_yes_indigenous',

        'is_4ps',
        'household_4ps_id_no',

        //'last_school_attended',
        
        'current_country_id',
        'current_country',
        'current_province_id',
        'current_province',
        'current_city_id',
        'current_city',
        'current_barangay_id',
        'current_barangay',
        'current_street',
        'current_zipcode',

        'permanent_country_id',
        'permanent_country',
        'permanent_province_id',
        'permanent_province',
        'permanent_city_id',
        'permanent_city',
        'permanent_barangay_id',
        'permanent_barangay',
        'permanent_street',
        'permanent_zipcode',

        'email',
        'contact_no',
        'religion',

        'mother_tongue',
        
        'father_lname',
        'father_fname',
        'father_mname',
        'father_extension',
        'father_contact_no',
        
        'mother_maiden_lname',
        'mother_maiden_fname',
        'mother_maiden_mname',
        'mother_maiden_contact_no',

        'guardian_lname',
        'guardian_fname',
        'guardian_mname',
        'guardian_extension',
        'guardian_contact_no',
        'guardian_relationship',


        'last_grade_level',
        'last_year_completed',
        'last_school_attended',
        'last_school_id',

        'semester_id',
        'senior_high_school_id',
        'track_id',
        'strand_id',

        'administer_by',
        'ip',

    ];


    public function semester(){
        return $this->hasOne(Semester::class, 'semester_id', 'semester_id');
    }

    public function strand(){
        return $this->hasOne(Strand::class, 'strand_id', 'strand_id');
    }

    public function track(){
        return $this->hasOne(Track::class, 'track_id', 'track_id');
    }

    public function section(){
        return $this->hasOne(Section::class, 'section_id', 'section_id');
    }

    public function grade_level(){
        return $this->hasOne(GradeLevel::class, 'grade_level', 'grade_level');
    }



    public function current_province(){
        return $this->hasOne(Province::class, 'id', 'current_province_id');
    }
    public function current_city(){
        return $this->hasOne(City::class, 'id', 'current_city_id');
    }
    public function current_barangay(){
        return $this->hasOne(Barangay::class, 'id', 'current_barangay_id');
    }

    
    public function permanent_province(){
        return $this->hasOne(Province::class, 'id', 'permanent_province_id');
    }
    public function permanent_city(){
        return $this->hasOne(City::class, 'id', 'permanent_city_id');
    }
    public function permanent_barangay(){
        return $this->hasOne(Barangay::class, 'id', 'permanent_barangay_id');
    }


    public function credentials(){
        return $this->hasMany(EnrolleeCredential::class, 'learner_id', 'learner_id');
    }





}
