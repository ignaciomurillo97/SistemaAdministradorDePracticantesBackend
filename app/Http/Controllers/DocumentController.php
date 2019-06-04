<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        error_log("Hola request");
        /*if(Input::hasFile('file')){
            $photo = Input::file('file');
            $extension = $photo->getClientOriginalExtension();
            $name = time().'.'.$extension;
            $photo->move(public_path().'\images\\',$name);*/
            /*$photo = new Photo();
            $photo->route = 'photos/'.$name;
            error_log($name);
            $photo->report = $report->id;
            $photo->save();*/
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
