<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enroll;
use App\Models\AcademicYear;

class ReportExtractClassListController extends Controller
{
    //

    public function index(){
        return view('report.extract-class-list');
    }

    public function get(Request $req){
        $ay = AcademicYear::where('is_active', 1)->first();

        // $data = Enroll::with(['learner', 'semester', 'track', 'strand', 
        //     'section', 
        //     'grade_level'
        //     ])
        //     ->where('academic_year_id', $ay->academic_year_id)
        //     ->where(function($q){
        //         $q->where('status', 'ADMITTED')
        //             ->orWhere('status', 'ENROLLED');
        //     })
        //     ->orderBy('learner.lname')
        //     ->paginate($req->perpage); 
        
        $data = Enroll::with(['learner', 'semester', 'track', 'strand', 'section', 'grade_level',
            'learner.current_province', 'learner.current_city', 'learner.current_barangay', 
            'learner.permanent_province', 'learner.permanent_city', 'learner.permanent_barangay'
            ])
            ->join('learners', 'learners.learner_id', '=', 'enrolls.learner_id') // join the learners table
            ->where('learners.academic_year_id', $ay->academic_year_id)
            ->where(function ($q) {
                $q->where('status', 'ADMITTED')
                ->orWhere('status', 'ENROLLED');
            })
            ->where('section_id', $req->section)
            ->orderBy('learners.sex')
            ->orderBy('learners.lname') // use actual table.column name here
            ->select('enrolls.*') // important: select enrolls.* to keep Eloquent model working
            ->get();
            
        return $data;
    }
}
