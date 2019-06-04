<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventType;
use Illuminate\Support\Facades\Validator;

class EventTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = EventType::all();
        return response()->json(['data'=> $types,'error' => NULL]);
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
           'name' => 'required|string',
           'description' => 'string',
        ]);
        if($validator->fails()){
            $response =  response()->json(['data'=>'failed', 'error' => $validator->messages()->first()]);
        }else{
            $type = new EventType;
            $type->name = $request->name;
            $type->description = $request->description;
            $type->save();
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
        //
        $eventType = EventType::find($id);
        return response()->json(['data' => $eventType, 'error' => NULL]);
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
        try {
            $eventType = EventType::find($id);
            if ($eventType != null){
                $eventType->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El tipo de evento no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $eventType = EventType::find($id);
            if ($eventType != null) {
                $eventType->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El tipo de evento no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }
}
