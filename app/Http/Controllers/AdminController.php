<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $administrator = DB::table('users as u')
                            ->join('people as p', 'p.id', '=', 'u.person_id')
                            ->where('u.scope_id', 1)
                            ->select('u.email', 'p.id', 'p.name',
                                    'p.lastName', 'p.secondLastName', 'p.telephone')
                            ->get();
        return response()->json(['data'=> $administrator,'error' => NULL]);
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
        DB::beginTransaction();
        $requestContents = $request->all();
        $userData = $requestContents['user'];
        $personData = $requestContents['person'];
        // $coordinatorData = $requestContents['coordinator'];
        $this->setDefaultValues($userData, $personData); //, $coordinatorData);

        try {
            $this->saveDataToDB($personData, $userData); //, $coordinatorData);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return makeResponseObject(null, "Cédula o correo ya existente en el sistema");
            }
            return makeResponseObject(null, "No se pudo crear el usuario");
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            return makeResponseObject(null, "Error del servidor");
        }

        DB::commit();

        return makeResponseObject("Success", null);
    }

    private function saveDataToDB ($personData, $userData) { //, $coordinatorData) {
        $person = Person::create($personData);
        $person->save();
        $person->user()->save(User::create($userData));
        // $coordinator = Coordinator::create($coordinatorData);
        // $coordinator->save();
    }

    private function setDefaultValues( &$userData, &$personData) {//, &$coordinatorData) {
        $userData["person_id"] = $personData["id"];
        $userData["scope_id"] = 1; // Coordinator scoppe id
        $userData["password"] = bcrypt($userData["password"]);
        // $coordinatorData["person_id"] = $personData["id"];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $administrator = Person::find($id);
        $administratorUser = User::where('person_id', $administrator->id)->get();
        return response()->json(['data'=> ['administrator' => $administrator, 'administratorUser' => $administratorUser] ,'error' => NULL]);
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
            $administrator = Person::find($id);
            if ($administrator != null){
                $administrator->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El administrador no existe");
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
            $administrator = Person::find($id);
            $administratorId = User::select('id')->where('person_id', $administrator->id)->get();
            
            if ($administrator != null) {
                DB::table('Users')->where('id', $administratorId)->delete();
                $administrator->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject(null, "El administrador no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }
}
