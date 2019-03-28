<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Validator;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activities = Suggestion::all();
        return response()->json(['data'=>$activities, 'error'=> NULL]);
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
        $response = response()->json(['data'=>'success', 'error'=> NULL]);
        $validator = Validator::make($request->all(), [
            'event' => 'required|integer',
            'duration' => 'required',
            'company' => 'required|digits:10',
            'name' => 'required|integer',
            'charlista' => 'required',
            'name' => 'required'
        ]);
        if($validator->fails()){
            $response = response()->json(['data'=>'failed', 'error'=> $validator->messages()->first()]);
        } else {
            $suggestion = new Suggestion;
            $suggestion->duration = $request->duration;
            $suggestion->company_id = $request->company;
            $suggestion->event_id = $request->event;
            $suggestion->charlista = $request->charlista;
            $suggestion->name = $request->name;
            $suggestion->remarks = $request->remarks;
            $suggestion->save();
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
    	$event = Event::find($id);
        $activities = Suggestion::where('event_id', $id)->get();
        return response()->json(['data'=> ['event'=>$event,'activities'=>$activities] ,'error' => NULL]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
