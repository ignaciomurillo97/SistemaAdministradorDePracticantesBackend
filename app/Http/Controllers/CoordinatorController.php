<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\CareerAndSitePerCompany;
use App\Http\Resources\CareerAndSitePerCompanyResource;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Person;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

class CoordinatorController extends Controller
{
    public function getCompanyRegistrationRequest (Request $request) {
        $coordinator = auth()->guard('api')->user()->person->coordinator;

        return new CareerAndSitePerCompanyResource(
            CareerAndSitePerCompany::where('site_id', $coordinator->site_id)->get()
        );
    }

    public function aproveCompanyRegistration (Request $request, int $id) {
        $relation = CareerAndSitePerCompany::find($id);
        $relation->status = 'aproved';
        $relation->save();
        return makeResponseObject('success', null);
    }

    public function denyCompanyRegistration (Request $request, int $id) {
        $relation = CareerAndSitePerCompany::find($id);
        $relation->status = 'denied';
        $relation->save();
        return makeResponseObject('success', null);
    }

    public function getStudentWithStatus (Request $request, $status) {
        $students = Student::where('status', $status)->get();
        return makeResponseObject($students, null);
    }

    // se busca con el carne del estudiante
    public function aproveStudentRequest (Request $request, $id, $status) {
        $student = Student::find($id);
        $student->status = $status;
        $student->save();
        return makeResponseObject('success', null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coordinator = DB::table('users as u')
                            ->join('people as p', 'p.id', '=', 'u.person_id')
                            ->where('u.scope_id', 2)
                            ->select('u.email', 'p.name',
                                    'p.lastName', 'p.secondLastName', 'p.telephone')
                            ->get();
        return response()->json(['data'=> $coordinator,'error' => NULL]);
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
        $userData["scope_id"] = 2; // Coordinator scoppe id
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
        $coordinator = Person::find($id);
        $coordinatorUser = User::where('person_id', $coordinator->id)->get();
        return response()->json(['data'=> ['coordinator' => $coordinator, 'coordinatorUser' => $professorUser] ,'error' => NULL]);
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
            $coordinator = Person::find($id);
            if ($coordinator != null){
                $coordinator->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "El coordinador no existe");
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
            $coordinator = Person::find($id);
            $coordinatorId = User::select('id')->where('person_id', $coordinator->id)->get();
            
            if ($coordinator != null) {
                DB::table('Users')->where('id', $coordinatorId)->delete();
                $coordinator->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject(null, "El coordinador no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }
}
