<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportNoOfEnrolmentController extends Controller
{
    
    public function index(){
        return view('report.report.report-no-of-enrolment');
    }


    public function getReportClassList(Request $req){

        return Section::with(['enrollees', 
            'enrollees.subjects.subject',
            'enrollees.academic_year',
            'enrollees.track',
            'enrollees.strand',
            'enrollees.semester',
            'enrollees.grades'])
            ->get();
    }
}
