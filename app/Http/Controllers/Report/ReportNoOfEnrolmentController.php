<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;

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
        $ay = AcademicYear::where('is_active', 1)->first();

        $reports = \DB::select("
            SELECT
                CASE 
                    WHEN sex = 'MALE' THEN 'MALE'
                    WHEN sex = 'FEMALE' THEN 'FEMALE'
                    ELSE 'TOTAL'
                END AS legends,
                COUNT(CASE WHEN grade_level = 'GRADE 7' THEN learner_id END) AS 'grade_7',
                COUNT(CASE WHEN grade_level = 'GRADE 8' THEN learner_id END) AS 'grade_8',
                COUNT(CASE WHEN grade_level = 'GRADE 9' THEN learner_id END) AS 'grade_9',
                COUNT(CASE WHEN grade_level = 'GRADE 10' THEN learner_id END) AS 'grade_10',
                COUNT(CASE WHEN grade_level = 'GRADE 11' THEN learner_id END) AS 'grade_11',
                COUNT(CASE WHEN grade_level = 'GRADE 12' THEN learner_id END) AS 'grade_12'
            FROM (
                SELECT enrolls.learner_id, 'MALE' AS sex, enrolls.grade_level 
                FROM enrolls JOIN learners ON enrolls.learner_id = learners.learner_id
                JOIN academic_years ON enrolls.academic_year_id = academic_years.academic_year_id 
                WHERE learners.sex = 'MALE'
                AND academic_years.is_active = 1
                UNION ALL
                SELECT enrolls.learner_id, 'FEMALE' AS sex, enrolls.grade_level 
                FROM enrolls JOIN learners ON enrolls.learner_id = learners.learner_id
                JOIN academic_years ON enrolls.academic_year_id = academic_years.academic_year_id 
                AND academic_years.is_active = 1
                WHERE learners.sex = 'FEMALE'
            ) AS sex_counts
            GROUP BY sex WITH ROLLUP;
        ");

        return response()->json([
            'reports' => $reports,
            'ay' => $ay
        ], 200);
    }


    public function reportCountByStrand(Request $req){

       
        $ay = AcademicYear::where('is_active', 1)->first();

        $reports = \DB::select("
            CALL report_by_strand;
        ");

        return response()->json([
            'reports' => $reports,
            'ay' => $ay
        ], 200);
    }
}
