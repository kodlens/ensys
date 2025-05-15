<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{
     public function index(){
        return view('administrator.group.group');
    }


    public function show($id){
        return Group::find($id);
    }


    public function getData(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Group::where('group_name', 'like', $req->name . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


     public function store(Request $req){
        $req->validate([
            //'academic_year_id' => ['required'],
            'group_name' => ['required'],
        ]);

        //return $req;

        Group::create([
            'group_name' => strtoupper($req->group_name),
            'active' => $req->active ? 1 : 0
        ]);
        

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){
        $req->validate([
            'group_name' => ['required', 'unique:groups,group_name,' .$id.',group_id'],
        ]);

        $data = Group::find($id);
        $data->group_name = strtoupper($req->group_name);
        $data->active = $req->active ? 1 : 0;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    public function destroy($id){
        Group::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }

}
