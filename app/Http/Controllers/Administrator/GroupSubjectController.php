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
        return Group::find($id);
    }


    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = GroupSubject::with(['group', 'subject'])
            ->whereHas('group', function($q) use ($req){
                $q->where('group_name', 'like', $req->subject . '%');
            })
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
            'group_id' => ['required'],
        ],
        [
            'group_id.required' => 'Please select a group'
        ]);

       foreach($req->subjects as $item){
            GroupSubject::updateOrCreate([
                //'academic_year_id' => $req->academic_year_id,
                'group_id' => $req->group_id,
                'subject_id' => $item['subject_id']
            ],[
                //'academic_year_id' => $req->academic_year_id,
                'subject_id' => $item['subject_id'],
            ]);
        }
        

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function destroy($id){
        GroupSubject::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
