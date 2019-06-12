<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Person;
use App\Models\User;
use App\Models\InternshipProcessEvaluation;
use App\Models\InternshipProfessorEvaluation;
use App\Models\Document;
use App\Http\Resources\StudentResource;
use Illuminate\Support\Facades\Input;

class StudentController extends Controller
{
    public $extensions = ['image/jpeg' => 'jpg',
                    'image/png' => 'png'];

    /**
     * Display a resource with a given id.
     *
     * @param Integer $id
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $student = Student::find($id);
        if ($student == null) {
            return makeResponseObject(null, "no se encontro estudiante");
        }
        return makeResponseObject(new StudentResource($student), null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $students = Student::all();
        return makeResponseObject(StudentResource::collection($students), null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filterByStatus($status)
    {
        $students = DB::table('people')->join('students', 'students.person_id', '=', 'people.id')->select('people.id','people.name','people.lastName','people.secondLastName','people.telephone','students.id')->where('students.status', $status)->get(); // aprobado
        return response()->json(['data'=> $students ,'error' => NULL]);
        // return makeResponseObject(StudentResource::collection($students), null);
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
        $studentData = $requestContents['student'];
        $userData = $requestContents['user'];
        $personData = $requestContents['person'];
        $this->setDefaultValues($studentData, $userData, $personData);

        try {
            if (isset($personData['image'])) {
                $studentData['image'] = saveBase64ImageToDisk($personData['image']);
            } else {
                $studentData['image'] = null;
            }
            $this->saveDataToDB($personData, $studentData, $userData);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return makeResponseObject(null, "Cédula, carné o correo ya existente en el sistema");
            }
            return $e;
            return makeResponseObject(null, "No se pudo crear el usuario");
        } catch (\Exception $e) {
            DB::rollback();
            return makeResponseObject(null, "Error del servidor");
        }

        DB::commit();

        return makeResponseObject("Success", null);
    }

    private function saveDataToDB ($personData, $studentData, $userData) {
        $person = Person::create($personData);
        $person->student()->save(Student::create($studentData));
        $person->user()->save(User::create($userData));
        $person->save();
    }

    private function isValidFunction ($mimeType) {
        return isset($this->extensions[$mimeType]);
    }

    private function setDefaultValues(&$studentData, &$userData, &$personData) {
        $userData["person_id"] = $personData["id"];
        $studentData["person_id"] = $personData["id"];
        $studentData["status"] = 1; // Pendiente
        $userData["scope_id"] = 3;
        $userData["password"] = bcrypt($userData["password"]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Integer $id
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $student = Student::find($id);
            if ($student != null) {
                $student->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject(null, "El estudiante no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $student = Student::find($id);
            if ($student != null) {
                $student->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject(null, "El estudiatne no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }

    /**
     * Aprove the student
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function aproveStudent (Request $request, int $id) {
        $student = Student::find($id);
        if ($student == null) {
            return makeResponseObject(null, 'El usuario no existe');
        }
        $student->status = 'Aprobado';// aprobado
        $student->save();
        return makeResponseObject("success", null);
    }

    /**
     * Aprove the student
     *
     * @param  Integer  $id
     * @return \Illuminate\Http\Response
     */
    public function rejectStudent (Request $request, int $id) {
        $student = Student::find($id);
        if ($student == null) {
            return makeResponseObject(null, 'El usuario no existe');
        }
        $student->status = 'Rechazado';// rechazado
        $student->save();
        return makeResponseObject("success", null);
    }

    public function assignProfessor($studentID,$professorID){
        //$response = response()->json(['data'=> $var ,'error' => NULL]);
        $student = Student::find($studentID);
        $student->professorAssigned = $professorID;
        $student->save();
        return response()->json(['data'=> $var ,'error' => NULL]);
    }

    public function assignCharterGrade(Request $request, int $id)
    {
        $docu = Document::find($id);
        $docu->grade = $request->grade;
        $docu->save();
        return makeResponseObject('Success', NULL);
    }

    public function showCharterGrade(){
        $person_id = auth()->guard('api')->user()->person_id;
        $docu = Document::select('grade')->where('person_id',$person_id)->get();
        return response()->json(['data'=> $docu ,'error' => NULL]);
    }

    public function storeInternshipProcessEvaluation(Request $request) {
        $student_id = $request->student_id;
        $evaluation = $request->evaluation;

        //validate student 
        $student = Student::find($student_id);
        if (!isset($student)) {
            return makeResponseObject(null, 'student with id does not exist');
        }

        $internEvalModel = InternshipProcessEvaluation::create([
            "student_id" => $student_id,
            "evaluation" => $evaluation
        ]);
        return makeResponseObject('Success', NULL);
    }

    public function storeInternshipProfessorEvaluation(Request $request) {
        $student_id = $request->student_id;
        $professor_id = $request->professor_id;

        // validate person is professor
        $professor = Person::find($professor_id);
        if (!isset($professor) || $professor->user->scope_id != 5) {
            return makeResponseObject(null, 'professor id does not reference a professor');
        }

        //validate student 
        $student = Student::find($student_id);
        if (!isset($student)) {
            return makeResponseObject(null, 'student with id does not exist');
        }

        $evaluation = $request->evaluation;
        $internEvalModel = InternshipProfessorEvaluation::create([
            "student_id" => $student_id,
            "professor_id" => $professor_id,
            "evaluation" => $evaluation
        ]);
        return makeResponseObject('Success', NULL);
    }

    public function downloadConstancyLetter(Request $request) {
        $studentPerson = auth()->guard('api')->user()->person;
        $date = Carbon::now()->locale('es');
        $day_of_emmision = "{$date->dayName} {$date->day} de {$date->monthName} del {$date->year}";
        $pdf = PDF::loadView('carta_constancia_estudio', [
            'name'=> $studentPerson->name,
            'student_id' => $studentPerson->student->id,
            'id' => $studentPerson->id,
            'semester_number' => 'I',
            'semester_year' => 2019,
            'day_of_emmision' => $day_of_emmision
        ]);
        return $pdf->stream();
    }
}
