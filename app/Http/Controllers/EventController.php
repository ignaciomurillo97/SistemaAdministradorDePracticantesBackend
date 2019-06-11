<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Activity;
use App\Models\Suggestion;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\SuggestionController;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$events = Event::all()->filter(function($event) {
        //   $day = new Carbon($event->eventDate);
        //   if($day->diffInDays(Carbon::now()) < 3){
        //       return $event;
        //   }
        //})->values();
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
        $response = self::validateData($request);
        if(!$response->getData()->error){//Si error es null
            $event = new Event;
            $event->name = $request->name;
            $event->eventDate = $request->eventDate;
            $event->start = $request->start;
            $event->finish = $request->finish;
            if(Input::hasFile('image')){
                $event->image = saveBase64ImageToDisk($event->image);

            }
            else{
                $event->image = $request->image;
            }
            $event->type_id = $request->type_id;
            try{     
                $event->save();
                $request->event = $event->id;
                $ActivityController = new ActivityController;
                $response = $ActivityController->store($request);
                //error_log(sizeof($request['activities']));
            }
            catch(\Exception $e){
                $response =  response()->json(['data'=>'failed', 'error' => $e->getMessage()]);
            }
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
        if($event){
            $activities = Activity::where('event_id', $id)->get();//all activities
            $companies = array();
            $peopleConfirmed = Event::peopleConfirmed($id);//all people confirmed to current event
            foreach ($peopleConfirmed as $comfirmed) {
                $personConfirmed = User::where('person_id', $comfirmed->person_id)->get();
                if($personConfirmed[0]->scope_id == 4){//check if the person is a company
                    $company = Company::where('person_id',$comfirmed->person_id)->get();//gets company info
                    if(count($company) != 0){
                        $company[0]->suggestions = Suggestion::where('person_id', $comfirmed->person_id)->get();
                    }
                    array_push($companies, $company);
                }
            }
            $response = response()->json(['data'=> ['event'=>$event,'activities'=>$activities, 'companies' => $companies] ,'error' => NULL]);
        }else{
            $response = response()->json(['data'=> 'failed' ,'error' => 'Event does not exist']);
        }
        return $response;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
                
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
        $response = self::validateData($request);
        $event = Event::find($id);
        if($event){//if the event exists
            if(!$response->getData()->error){//if the request is correct
                $event->name = $request->name;
                $event->eventDate = $request->eventDate;
                $event->start = $request->start;
                $event->finish = $request->finish;
                if(Input::hasFile('image')){
                    $event->image = saveBase64ImageToDisk($event->image);
                }
                else{
                    $event->image = $request->image;
                }
                $event->type_id = $request->type_id;
                try{     
                    $event->save();
                    $request->event = $event->id;
                    $ActivityController = new ActivityController;
                    $response = $ActivityController->store($request);
                    //error_log(sizeof($request['activities']));
                }
                catch(\Exception $e){
                    $response =  response()->json(['data'=>'failed', 'error' => $e->getMessage()]);
                }
            }

        }else{
            $response = response()->json(['data'=>'failed', 'error'=> 'event does not exist']);
        }
        return $response;
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

    public function confirmAssistance(Request $request, $event){
        $user = auth()->guard('api')->user();//gets the current user
        $response = response()->json(['data'=>'success', 'error'=> NULL]);
        if(Event::hasConfirmed($user->person_id)){//Verifies that the current user has confirmed
            $response = response()->json(['data'=>'failed', 'error'=> 'Person has confirmed already']);
        }
        else if($user->scope_id == 4 && count($request->all()) != 0){//if user is a company and request has data
            $validator = Validator::make($request->all(), [//verifies if the request is correct
               'duration' => 'required|string',
               'charlista' => 'required|string',
               'name' => 'required|string',
               'remarks' => 'string',
            ]);
            if($validator->fails()){//The request was incorrect
                $response =  response()->json(['data'=>'failed', 'error' => $validator->messages()->first()]);
            }
            if(!$response->getData()->error){//request was correct
                $request->request->add(['event' => $event,'person_id' =>$user->person_id]);
                $SuggestionController = new SuggestionController;
                $response = $SuggestionController->store($request);//creates the suggestion
            }             
        }

        if(!$response->getData()->error){//If user is not a company
            Event::confirmAssistance($user->person_id,$event);
        }
        return $response;
    }

    public function validateData(Request $request){
        $response = response()->json(['data'=>'success', 'error' => NULL]);
        $validator = Validator::make($request->all(), [
           'name' => 'required|string',
           'eventDate' => 'required|date',
           'start' => 'required',
           'finish' => 'required',
           'type_id' => 'required|integer',
           'activities' => 'array'
        ]);
        if($validator->fails()){
            $response =  response()->json(['data'=>'failed', 'error' => $validator->messages()->first()]);
        }
        return $response;
    }
}
