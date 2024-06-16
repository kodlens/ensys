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
        'is_4ps',

        //'last_school_attended',
        
        'current_country',
        'current_province',
        'current_city',
        'current_barangay',
        'current_street',
        'current_zipcode',

        'permanent_country',
        'permanent_province',
        'permanent_city',
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



    public function province(){
        return $this->hasOne(Province::class, 'provCode', 'province');
    }
    public function city(){
        return $this->hasOne(City::class, 'citymunCode', 'city');
    }
    public function barangay(){
        return $this->hasOne(Barangay::class, 'brgyCode', 'barangay');
    }


    public function credentials(){
        return $this->hasMany(EnrolleeCredential::class, 'learner_id', 'learner_id');
    }





}
