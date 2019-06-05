<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

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
            //error_log($name);
            /*$photo = new Photo();
            $photo->route = 'photos/'.$name;
            error_log($name);
            $photo->report = $report->id;
            $photo->save();*/
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
    public function destroy($fileName)
    {
        $response = response()->json(['data'=>'failed', 'error'=> 'No file to delete']);
        $path = public_path().'\images\\'.$fileName;
        if(File::exists($path)){
            File::delete($path);
            $response = response()->json(['data'=>'success', 'error'=> NULL]);
        }
        return $response;
    }
}
