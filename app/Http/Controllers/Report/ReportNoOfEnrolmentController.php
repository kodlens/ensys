<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportNoOfEnrolmentController extends Controller
{
    
    public function index(){
        return view('report.report.report-no-of-enrolment');
    }


    public function getReportEnrolmentList(Request $req){

        // return Section::with(['enrollees', 
        //     'enrollees.subjects.subject',
        //     'enrollees.academic_year',
        //     'enrollees.track',
        //     'enrollees.strand',
        //     'enrollees.semester',
        //     'enrollees.grades'])
        //     ->get();

        return \DB::select("
            SELECT
            a.grade_level,
            b.sex,
            COUNT(a.learner_id) AS by_sex,
            (SELECT COUNT(aa.learner_id) FROM enrolls aa WHERE aa.grade_level = a.grade_level) AS total
            FROM
            enrolls a
            LEFT JOIN learners b ON a.learner_id = b.learner_id
            WHERE a.academic_year_id = 3
            GROUP BY a.grade_level, b.sex
            ORDER BY a.grade_level DESC
        ");
    }
}
