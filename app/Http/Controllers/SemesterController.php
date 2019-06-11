<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Semester;
use Illuminate\Support\Facades\Validator;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $semester = Semester::all();
        return response()->json(['data'=> $semester,'error' => NULL]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = response()->json(['data'=>'success', 'error' => NULL]);
        $validator = Validator::make($request->all(), [
           'semester' => 'required',
           'start' => 'required',
           'end' => 'required',
        ]);
        if($validator->fails()){
            $response =  response()->json(['data'=>'failed', 'error' => $validator->messages()->first()]);
        }else{
            $semester = new Semester;
            $semester->semester = $request->semester;
            $semester->start = $request->start;
            $semester->end = $request->end;
            $semester->save();
        }
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $semester = Semester::find($id);
        return response()->json(['data'=> $semester ,'error' => NULL]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function edit(Semester $semester)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Semester $semester)
    {
        try {
            $semester = Semester::find($id);
            if ($semester != null){
                $semester->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El semestre no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Semester  $semester
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $semester = Semester::find($id);
            if ($semester != null) {
                $semester->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El semestre no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }
}
