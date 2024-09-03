<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChangeAdmissionController extends Controller
{
    //

    public function index(){
        return view('administrator.change-admission.change-admission-index');
    }
}
