<?php

namespace App\Http\Controllers;

use App\Models\AcademicYear;
use App\Models\Enrol;
use App\Models\Section;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;



use App\Models\Learner;

class RegistrationController extends Controller
{
    //
    public function index(){
        return view('registration');
    }


    public function store(Request $req){
        $req->validate([

            'grade_level' => ['required'],
            'balik_aral' => ['required', 'string'],
            'psa' => ['required', 'string', 'max:15'],
            'lrn' => ['string', 'max:15'],

            'lname' => ['required', 'string', 'max:50'],
            'fname' => ['required', 'string', 'max:50'],
            'sex' => ['required', 'string', 'max:10'],
            'birthdate' => ['required'],
            
            'age' => ['required'],

            'mother_tongue' => ['required', 'string', 'max:50'],

            'is_indigenous' => ['required'],
            'if_yes_indigenous' => ['required_if:is_indigenous,1'],

            'is_4ps' => ['required'],
            'household_4ps_id_no' => ['required_if:is_4ps,1'],

            'current_province' => ['required', 'string'],
            'current_city' => ['required', 'string'],
            'current_barangay' => ['required', 'string'],
            //'current_zipcode' => ['max:15', 'string'],

            'permanent_province' => ['required', 'string'],
            'permanent_city' => ['required', 'string'],
            'permanent_barangay' => ['required', 'string'],
            //'permanent_zipcode' => ['max:15', 'string'],

            'guardian_lname' => ['required', 'string'],
            'guardian_fname' => ['required', 'string'],
            'guardian_contact_no' => ['required', 'regex:/^(09|\+639)\d{9}$/'],

            'last_grade_level' => ['required_if:balik_aral,YES'],
            'last_year_completed' => ['required_if:balik_aral,YES'],
            'last_school_attended' => ['required_if:balik_aral,YES'],
            'last_school_id' => ['required_if:balik_aral,YES'],

            'semester_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'track_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'strand_id' => ['required_if:grade_level.curriculum_code,SHS'],

        ],[
            'guardian_contact_no.regex' => 'Please enter a valid Philippines mobile phone number.',

            'semester_id.required_if' => 'Curriculum is SHS, semester is required.',
            'track_id.required_if' => 'Curriculum is SHS, track is required.',
            'strand_id.required_if' => 'Curriculum is SHS, strand is required.',
                        
            'last_grade_level_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_year_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_attended.required' => 'This field is required since you are a returnee student.',
            'last_schoold_id.required' => 'This field is required since you are a returnee student.'

        ]);
        
        /* adding other validation checking for fullname duplicate */
        $existLearner = Learner::where('lname', $req->lname)
            ->where('fname', $req->fname)
            ->where('mname', $req->mname)
            ->exists();

        if($existLearner){
            return response()->json([
                'errors' => [
                    'exist' => ['Learner already exist/registered on the system.']
                ]
            ], 422);
        }

        DB::beginTransaction();

        try {

            $data = Learner::where('learner_id', $id)
            ->update([

                'academic_year_id' => $ay->academic_year_id,
                'grade_level' => $req->grade_level['grade_level'],
                'balik_aral' => $req->balik_aral,
                'psa' => $req->psa,
                'lrn' => $req->lrn,
                'lname' => strtoupper($req->lname),
                'fname' => strtoupper($req->fname),
                'mname' => strtoupper($req->mname),
                'extension' => strtoupper($req->suffix),
                'sex' => $req->sex,
                'birthdate' => date('Y-m-d', strtotime($req->formatted_bdate)),
                'age' => $req->age,
                'birthplace' => strtoupper($req->birthplace),
                
                'mother_tongue' => strtoupper($req->mother_tongue),
        
                'is_indigenous' => $req->is_indigenous,
                'if_yes_indigenous' => strtoupper($req->if_yes_indigenous),

                'is_4ps' => $req->is_4ps,
                'household_4ps_id_no' => strtoupper($req->household_4ps_id_no),

                'current_province' => $req->current_province,
                'current_city' => $req->current_city,
                'current_barangay' => $req->current_barangay,
                'current_street' => strtoupper($req->current_street),
                'current_zipcode' => $req->current_zipcode,
                // 'religion' => $req->religion,
                // 'email' => $req->email,
                // 'contact_no' => $req->contact_no,
                'permanent_province' => $req->permanent_province,
                'permanent_city' => $req->permanent_city,
                'permanent_barangay' => $req->permanent_barangay,
                'permanent_street' => strtoupper($req->permanent_street),
                'permanent_zipcode' => $req->permanent_zipcode,

                'father_lname' => strtoupper($req->father_lname),
                'father_fname' => strtoupper($req->father_fname),
                'father_mname' => strtoupper($req->father_mname),
                'father_extension' => strtoupper($req->father_extension),
                'father_contact_no' => $req->father_contact_no,
        
                'mother_maiden_lname' => strtoupper($req->mother_maiden_lname),
                'mother_maiden_fname' => strtoupper($req->mother_maiden_fname),
                'mother_maiden_mname' => strtoupper($req->mother_maiden_mname),
                'mother_maiden_contact_no' => $req->mother_maiden_contact_no,
        

                'guardian_lname' => strtoupper($req->guardian_lname),
                'guardian_fname' => strtoupper($req->guardian_fname),
                'guardian_mname' => strtoupper($req->guardian_mname),
                'guardian_extension' => strtoupper($req->guardian_mname),
                'guardian_contact_no' => $req->guardian_contact_no,

                'last_grade_level' =>  $req->last_grade_level,
                'last_year_completed' => $req->last_year_completed,
                'last_school_attended' => strtoupper($req->last_school_attended),
                'last_school_id' => strtoupper($req->last_school_id),


                'senior_high_school_id' => strtoupper($req->senior_high_school_id),
                'semester_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->semester_id : null,
                'track_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->track_id : null,
                'strand_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->strand_id : null,

                'administer_by' => 'SELF',

            ]);

        return response()->json([
            'status' => 'updated'
        ],200);

            // If all operations are successful, commit the transaction
            DB::commit();

            return response()->json([
                'status' => 'saved'
            ],200);

        }catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }



}
