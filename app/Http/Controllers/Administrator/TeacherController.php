<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Teacher;


class TeacherController extends Controller
{
    //

    public function index(){
        return view('administrator.teacher.teacher-index');
    }

    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = User::where(function ($query) use ($req) {
            $query->where('lname', 'like', $req->name . '%')
                ->orWhere('fname', 'like', $req->name . '%');
            })
            ->where('role', 'TEACHER')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function show($id){
        $data = Teacher::find($id);
        return $data;
    }


    public function store(Request $req){
        $req->validate([
            'reference_id' => ['max:20'],
            'lname' => ['required', 'string'],
            'fname' => ['required', 'string'],
            'sex' => ['required', 'string'],
        ]);

        Teacher::create([
            'reference_id' => strtoupper($req->reference_id),
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'sex' => strtoupper($req->sex)
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function update(Request $req, $id){
       
        $req->validate([
            'lname' => ['required', 'string'],
            'fname' => ['required', 'string'],
            'sex' => ['required', 'string'],
        ]);


        $data = Teacher::find($id);
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->sex = strtoupper($req->sex);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }





    public function destroy($id){
        Faculty::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
