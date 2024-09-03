<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Learner;
use Illuminate\Validation\Rule;
use App\Models\AcademicYear;

use Auth;


class ManageLearnerController extends Controller
{
    //


    public function index(){
        return view('administrator.manage-learner.manage-learner');
    }


    public function getLearners(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Learner::with(['track', 'strand'])
            ->where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function create(){
        return view('administrator.manage-learner.manage-learner-create-edit')
            ->with('id', 0)
            ->with('data', '');
    }

    public function edit($id){

        $data = Learner::with([
            'grade_level',
            'current_province', 
            'current_city',
            'current_barangay',
            'permanent_province', 
            'permanent_city',
            'permanent_barangay',
            'track', 
            'strand'])
            ->where('learner_id', $id)
            ->first();

        return view('administrator.manage-learner.manage-learner-create-edit')
            ->with('id', $data->learner_id)
            ->with('data', $data);
    }


    public function store(Request $req){
       
        //return $req;

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

            // 'guardian_lname' => ['required', 'string'],
            // 'guardian_fname' => ['required', 'string'],
            // 'guardian_contact_no' => ['required', 'regex:/^(09|\+639)\d{9}$/'],

            'last_grade_level' => ['required_if:balik_aral,YES'],
            'last_year_completed' => ['required_if:balik_aral,YES'],
            'last_school_attended' => ['required_if:balik_aral,YES'],
            'last_school_id' => ['required_if:balik_aral,YES'],

            'semester_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'track_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'strand_id' => ['required_if:grade_level.curriculum_code,SHS'],

        ],[
            'if_yes_indigenous.required'=> 'This field is required since you are indigenous.',
            'household_4ps_id_no.required'=> 'This field is required since you are a 4ps member.',

            'guardian_contact_no.regex' => 'Please enter a valid Philippines mobile phone number.',

            'semester_id.required_if' => 'Curriculum is SHS, semester is required.',
            'track_id.required_if' => 'Curriculum is SHS, track is required.',
            'strand_id.required_if' => 'Curriculum is SHS, strand is required.',
                        
            'last_grade_level_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_year_completed.required' => 'This field is required since you are a returnee student.',
            'last_school_attended.required' => 'This field is required since you are a returnee student.',
            'last_schoold_id.required' => 'This field is required since you are a returnee student.'

        ]);

   

        $ay = AcademicYear::where('is_active', 1)->first();
        $user = Auth::user();
        /*inserting data to database*/
        $data = Learner::create([

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
            'guardian_relationship' => strtoupper($req->guardian_relationship),
    
            
      
            'last_grade_level' =>  $req->last_grade_level,
            'last_year_completed' => $req->last_year_completed,
            'last_school_attended' => strtoupper($req->last_school_attended),
            'last_school_id' => strtoupper($req->last_school_id),


            'senior_high_school_id' => strtoupper($req->senior_high_school_id),
            'semester_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->semester_id : null,
            'track_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->track_id : null,
            'strand_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->strand_id : null,

            'administer_by' => $user->username,
        ]);

        //STUDENT ID GENERATION
        $updateData = Learner::find($data->learner_id);
        $id = date('Y') . '-' . str_pad($data->learner_id, 6, '0', STR_PAD_LEFT);
        $updateData->student_id = $id;
        $updateData->save();

   
        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    
    public function update(Request $req, $id){
        
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

            // 'guardian_lname' => ['required', 'string'],
            // 'guardian_fname' => ['required', 'string'],
            // 'guardian_contact_no' => ['required', 'regex:/^(09|\+639)\d{9}$/'],

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


        $semesterId = 0;
        $trackId = 0;
        $strandId = 0;
        $seniorHighSchoolId = '';
        if($req->grade_level == 'GRADE 11' || $req->grade_level == 'GRADE 12'){
            $semesterId = $req->semester_id;
            $trackId = $req->track_id;
            $strandId = $req->strand_id;
            $seniorHighSchoolId = $req->senior_high_school_id;
        }
        
        $user = Auth::user();
        /* if not a senior high, set default value */
        /*inserting data to database*/
        $data = Learner::where('learner_id', $id)
            ->update([
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
                'guardian_relationship' => strtoupper($req->guardian_relationship),

                'last_grade_level' =>  $req->balik_aral == 'YES' ? $req->last_grade_level : null,
                'last_year_completed' => $req->balik_aral == 'YES' ? $req->last_year_completed : null,
                'last_school_attended' => $req->balik_aral == 'YES' ? strtoupper($req->last_school_attended) : null,
                'last_school_id' => $req->balik_aral == 'YES' ? strtoupper($req->last_school_id) : null,

                'senior_high_school_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->senior_high_school_id : null,
                'semester_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->semester_id : null,
                'track_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->track_id : null,
                'strand_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->strand_id : null,
            
                'last_update_by' => $user->username
            ]);

        return response()->json([
            'status' => 'updated'
        ],200);
    }


    //for modal browse
    public function getBrowseLearners(Request $req){
        $sort = explode('.', $req->sort_by);
        $ayId = $req->ayid;
        $studentId = $req->student;

        $learners = Learner::with(['track', 'strand', 'grade_level', 'section', 'semester'])
            //->where('academic_year_id', $ayId)
            ->where('student_id', 'like', $studentId . '%')
            ->where('lname', 'like', $req->lname . '%')
            ->where('fname', 'like', $req->fname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $learners;

    }


    public function destroy($id){
        Learner::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


}
