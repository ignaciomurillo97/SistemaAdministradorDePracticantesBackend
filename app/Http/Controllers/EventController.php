<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Activity;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

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
                $path = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$name;
                $photo->move(public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR,$name);
                $event->image = $path;

            }
            else{
                $event->image = $request->image;
            }
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
        $event = Event::find($id);
        $activities = Activity::where('event_id', $id)->get();
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

    public function confirmAssistance($event){
        $user = auth()->guard('api')->user();
        Event::confirmAssistance($user->id,$event);
        return response()->json(['data'=> 'success' ,'error' => NULL]);
    }
}
