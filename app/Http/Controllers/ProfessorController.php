<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professors = DB::table('users as u')
                            ->join('people as p', 'p.id', '=', 'u.person_id')
                            ->where('u.scope_id', 5)
                            ->select('u.email', 'p.name',
                                    'p.lastName', 'p.secondLastName', 'p.telephone')
                            ->get();
        return response()->json(['data'=> $professors,'error' => NULL]);
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
        $this->setDefaultValues($userData, $personData);

        try {
            $this->saveDataToDB($personData, $userData);
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

    private function saveDataToDB ($personData, $userData) {
        $person = Person::create($personData);
        $person->save();
        $person->user()->save(User::create($userData));
    }

    private function setDefaultValues( &$userData, &$personData) {
        $userData["person_id"] = $personData["id"];
        $userData["scope_id"] = 5; // Professor scoppe id
        $userData["password"] = bcrypt($userData["password"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $professor = Person::find($id);
        $professorUser = User::where('person_id', $professor->id)->get();
        return response()->json(['data'=> ['professor' => $professor, 'professorUser' => $professorUser] ,'error' => NULL]);
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
            $professor = Person::find($id);
            if ($professor != null){
                $professor->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El profesor no existe");
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
            $professor = Person::find($id);
            $professorId = User::select('id')->where('person_id', $professor->id)->get();
            
            if ($professor != null) {
                DB::table('Users')->where('id', $professorId)->delete();
                $professor->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject(null, "El profesor no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }
}
