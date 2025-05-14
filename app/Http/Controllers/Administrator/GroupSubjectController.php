<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GroupSubject;

class GroupSubjectController extends Controller
{
    public function index(){
        return view('administrator.group-subject.group-subject');
    }


    public function show($id){
    
    }


    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = GroupSubject::with(['subject', 'semester'])
            ->whereHas('subject', function($q)use($req){
                $q->where('subject_code', 'like', $req->subject . '%')
                    ->where('subject_description', 'like', $req->subject . '%');
            })
            ->where('name', 'like', $req->name . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function create(){ 
        return view('administrator.group-subject.group-subject-create-edit')
            ->with('id', 0);
    }


    public function store(Request $req){
        $req->validate([
            //'academic_year_id' => ['required'],
            'grade_level' => ['required'],
            'subjects' => ['required'],
            'semester_id' => ['required_if:grade_level.curriculum_code,SHS']
        ],[
            'semester_id.required_if' => 'Curriculum is SHS, semester is required.',
        ]);

        //return $req;

        foreach($req->subjects as $item){
            GradeLevelSubject::updateOrCreate([
                //'academic_year_id' => $req->academic_year_id,
                'grade_level' => $req->grade_level['grade_level'],
                'subject_id' => $item['subject_id']
            ],[
                //'academic_year_id' => $req->academic_year_id,
                'grade_level' => $req->grade_level['grade_level'],
                'curriculum_code' => $req->grade_level['curriculum_code'],
                'semester_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->semester_id : 0,
                // 'track_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->track_id : 0,
                // 'strand_id' => $req->grade_level['curriculum_code'] == 'SHS' ? $req->strand_id : 0,
                'subject_id' => $item['subject_id']
            ]);
        }
        

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function destroy($id){
        GradeLevelSubject::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
