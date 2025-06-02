<?php

namespace App\Http\Controllers\Administrator;
use App\Http\Controllers\Controller;
use App\Models\Enroll;

use Illuminate\Http\Request;

class EnrolleeController extends Controller
{

    public function index(){
        return view('administrator.enrollee.enrollee-page');
    }

 
    public function getEnrollees(Request $req){
        
        $sort = explode('.', $req->sort_by);

        $data = Enroll::with(['academic_year', 'learner', 
                'semester', 'track', 'strand', 
                'section', 'section_subjects.subject'
            ])
            ->whereHas('learner', function($q) use ($req){
                $q->where('lname', 'like', '%' . $req->name . '%')
                    ->orWhere('fname', 'like', '%' . $req->name . '%');
            })
            ->where('grade_level', 'like', $req->grade. '%')
            ->where('academic_year_id', $req->ayid)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }

    public function create(){
        return view('administrator.enrollee.enrollee-create-edit')
            ->with('id', 0);
    }


    public function edit($id){
        
        $data = Enroll::with(['academic_year', 'learner', 
            'grade_level',
            'semester', 'track', 'strand', 
            'section', 'section_subjects.subject'
        ])
        ->find($id);

        return view('administrator.enrollee.enrollee-create-edit')
            ->with('data', $data)
            ->with('id', $id); 
    }

    public function update(Request $req, $id){
        //return $req;

        $req->validate([
            'grade_level' => 'required',
            'section_id' => 'required',
            'semester_id' => 'required_if:grade_level.curriculum_code,SHS',
            'academic_year_id' => 'required',
            'track_id' => 'required_if:grade_level.curriculum_code,SHS',
            'strand_id' => 'required_if:grade_level.curriculum_code,SHS',
        ],
        [

            'semester_id.required_if' => 'Curriculum is SHS, semester is required.',
            'track_id.required_if' => 'Curriculum is SHS, track is required.',
            'strand_id.required_if' => 'Curriculum is SHS, strand is required.',

        ]);

       

        $currCode = $req->grade_level['curriculum_code'];
        $gradeLevel = $req->grade_level['grade_level'];

        $data = Enroll::find($id);
        $data->learner_status = $req->learner_status;
      
        $data->grade_level = $gradeLevel;
        $data->section_id = $req->section_id;
        $data->academic_year_id = $req->academic_year_id;

        $data->semester_id = $currCode == 'SHS' ? $req->semester_id : null;
        $data->track_id = $currCode == 'SHS' ? $req->track_id : null;
        $data->strand_id = $currCode == 'SHS' ? $req->strand_id : null;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);

    }

    public function destroy($id){
        Enroll::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ], 200);
    }


    public function getBrowseEnrollees(Request $req){
        $sort = explode('.', $req->sort_by);
        $ayId = $req->ayid;
        $studentId = $req->student;

        $data = Enroll::with(['learner', 'semester', 'track', 'strand', 
            'section', 
            'grade_level', 
            'section_subjects.subject'

            ])
            ->where('academic_year_id', $ayId)
            ->whereHas('learner', function($q) use ($req){
                $q->where('student_id', 'like', $req->student_id . '%')
                    ->where('lname', 'like', $req->lname . '%')
                    ->where('fname', 'like', $req->fname . '%');
            })
            //->where('is_enrolled', 0)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);   
            
        return $data;
    }





    

    public function coeIndex($learnerId, $ayId){
        return view('administrator.enrollee.report.coe-index')
            ->with('learnerId', $learnerId)
            ->with('ayId', $ayId);
    }

    public function getReportLearner($learnerId, $ayId){
        $data = Enroll::with(['academic_year', 'learner', 
            'semester', 'track', 'strand', 
            'billing.billing_payment',
            'section', 'section_subjects.subject'
        ])
        ->where('academic_year_id', $ayId)
        ->where('learner_id', $learnerId)
        ->first();


        return $data;
    }


    public function enrolleeUpdateStatusIndex($id){
        $enroll = Enroll::find($id);
        return view('administrator.enrollee.enrollee-update-status')
            ->with('enroll', $enroll)
            ->with('id', $id);
    }


    public function enrolleeUpdateStatusUpdate(Request $req, $id){

        $data = Enroll::find($id);
        $dateStatus = date('Y-m-d', strtotime($req->date_transfered));

        $data->status = $req->status;
        $data->date_transfered = $dateStatus;
        $data->reason = $req->reason;
        $data->school_transfered = $req->school_transfered;
        $data->save();
        
        return response()->json([
            'status' => 'saved'
        ], 200);
    }


}