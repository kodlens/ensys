<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Learner;
use Illuminate\Support\Facades\Storage;
use App\Models\EnrolleeCredential;

class EnrolleeCredentialListController extends Controller
{
    //

    public function index(){
        return view('administrator.enrollee_credential.enrollee-credential-list-index');
    }


    public function getData(Request $req){

        $sort = explode('.', $req->sort_by);

        $data = Learner::with(['credentials',
            'section', 'track', 'strand'
            ])
            ->where('lname','like', $req->name . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;

    }


    private $fileCustomPath = 'public/credentials/'; //this is for delete, or checking if file is exist
    //default dir(from root dir of laravel) to visit is storage/app/public/credentials folder

    public function destroy($id){
        $data = EnrolleeCredential::find($id);
        
        if(Storage::exists($this->fileCustomPath . $data->file_path)) {
            Storage::delete($this->fileCustomPath . $data->file_path);
        }

        EnrolleeCredential::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);

    }



}
