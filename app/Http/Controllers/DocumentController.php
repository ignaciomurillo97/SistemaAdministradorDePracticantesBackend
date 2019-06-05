<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = response()->json(['data'=>'failed', 'error'=> 'No file to upload']);
        if(Input::hasFile('file')){
            $photo = Input::file('file');
            $extension = $photo->getClientOriginalExtension();
            $name = time().'.'.$extension;
            $photo->move(public_path().'\images\\',$name);
            $response = response()->json(['data'=>$name, 'error'=> NULL]);
            $file = new Document();
            $file->name = '\images\\'.$name;
            $file->person_id = auth()->guard('api')->user()->person_id;
            $file->save();
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = response()->json(['data'=>'failed', 'error'=> 'No file to delete']);
        $file = Document::find($id);
        if($file != null){
            $path = public_path().$file->name;
            if(File::exists($path)){
                File::delete($path);
                $file->delete();
                $response = response()->json(['data'=>'success', 'error'=> NULL]);
            }
        }
        return $response;
    }

    public function uploadCharter(Request $request){
        $response = response()->json(['data'=>'failed', 'error'=> 'No file to upload']);
        if(Input::hasFile('file')){
            $charter = Input::file('file');
            $extension = $charter->getClientOriginalExtension();
            $name = 'charter'.time().'.'.$extension;
            $charter->move(public_path().'\images\\',$name);
            $response = response()->json(['data'=>$name, 'error'=> NULL]);
            $file = new Document();
            $file->name = '\images\\'.$name;
            $file->person_id = auth()->guard('api')->user()->person_id;
            $file->save();
        }
        return $response;
    }
}
