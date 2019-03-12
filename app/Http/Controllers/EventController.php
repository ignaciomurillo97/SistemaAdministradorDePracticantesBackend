<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = Event::all();
        return response()->json(['data'=> $events,'error' => NULL]);
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
        //
        $response = response()->json(['data'=>'success', 'error' => NULL]);
        $validator = Validator::make($request->all(), [
           'name' => 'required|string',
           'date' => 'required|date',
           'start' => 'required',
           'finish' => 'required',
           'type' => 'required|integer'
        ]);
        if($validator->fails()){
            $response =  response()->json(['data'=>'failed', 'error' => $validator->messages()->first()]);
        }else{
            $event = new Event;
            $event->name = $request->name;
            $event->eventDate = $request->date;
            $event->start = $request->start;
            $event->finish = $request->finish;
            if(Input::hasFile('image')){
                $photo = Input::file('image');
                $extension = $photo->getClientOriginalExtension();
                $name = time().'.'.$extension;
                $photo->move(public_path().'\images\\',$name);
                $event->image = 'photos/'.$name;
            }
            //$event->image = $request->image;
            $event->type_id = $request->type;
            $event->save();
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
