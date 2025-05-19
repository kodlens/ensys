<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AcademicYear;
use App\Models\Enroll;

class AdminDashboardController extends Controller
{
    //

    public function index(){
        return view('administrator.admin-dashboard');
    }

    public function countEnrolls(){
        $ay = AcademicYear::where('is_active', 1)->first();

        return Enroll::where('academic_year_id', $ay->academic_year_id)
            ->count();
    }




}
