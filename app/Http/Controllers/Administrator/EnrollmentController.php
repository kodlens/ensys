<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enroll;
use App\Models\AcademicYear;
use App\Models\EnrollSubject;
use Auth;
use App\Models\Group;
use App\Models\Section;

class EnrollmentController extends Controller
{
    //

    public function index(){
        return view('administrator.admission.admission-index');
    }

    public function store(Request $req){

        $req->validate([
            'learner_id' => ['required'],
            'grade_level' => ['required'],
            'section_id' => ['required'],
            'semester_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'track_id' => ['required_if:grade_level.curriculum_code,SHS'],
            'strand_id' => ['required_if:grade_level.curriculum_code,SHS'],
        ],[
            'learner_id.required' => 'Please select learner.',
            'section_id.required' => 'Section is required.',
            'semester_id.required_if' => 'Curriculum is SHS, semester is required.',
            'track_id.required_if' => 'Curriculum is SHS, track is required.',
            'strand_id.required_if' => 'Curriculum is SHS, strand is required.',
        ]);
        //return $req;
        
        $ay = AcademicYear::where('is_active', 1)->first();
        
        $user = Auth::user();

        //check if maximum no of students
        $maxNo = Section::where('section_id', $req->section_id)->first()->max;
        //return $maxNo;

        $countAdmitted = Enroll::where('section_id', $req->section_id)
            ->where('academic_year_id', $ay->academic_year_id)
            ->count();
        
        //check if no of enrolled is lesser than max no of section
        if($countAdmitted >= $maxNo){
            return response()->json([
                'errors' => [
                    'max' => ['Section is already full.']
                ],
                'max' => $maxNo,
                'count' => $countAdmitted,
                'message' => 'Section is already full.'
            ], 422);
        }
      
        //check if already enrol
        $exist = Enroll::where('learner_id', $req->learner_id)
            ->where('academic_year_id', $ay->academic_year_id)
            ->exists();
        if($exist){
            return response()->json([
                'errors' => [
                    'exists' => ['This learner is already admitted/enrolled in this semester."']
                ],
                'message' => 'This learner is already admitted/enrolled in this semester."'
            ], 422);
        }


        $enroll = Enroll::create([
            'academic_year_id' => $ay->academic_year_id,
            'grade_level' => $req->grade_level['grade_level'],
            'learner_status' => $req->learner_status,
            'learner_id' => $req->learner_id,
            'semester_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->semester_id : null,
            'track_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->track_id : null,
            'strand_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->strand_id : null,
            'section_id' => $req->section_id,
            'status' => 'ADMITTED',
            'admission_date' => date('Y-m-d', strtotime($req->admission_date)),
            'administer_by' => $user->username
        ]);

        $arr=[];
        foreach($req->subjects as $subj){
            array_push($arr,[
                'subject_id' => $subj['subject_id'],
                'enroll_id' => $enroll['enroll_id'],
            ]);
        }

        EnrollSubject::insert($arr);

        //return 'saved';
         return response()->json([
            'status' => 'saved',
            'max' => $maxNo,
            'count' => $countAdmitted,

        ], 200);

       
    }


    public function getModalBrowseGroupsWithSubjects(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Group::with(['group_subjects.subject'])
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }
}
