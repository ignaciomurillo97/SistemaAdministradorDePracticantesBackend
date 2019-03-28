<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Person;
use App\Models\User;
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
        $students = Student::where('status', $status)->get(); // aprobado
        return makeResponseObject(StudentResource::collection($students), null);
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
                $studentData['image'] = $this->saveBase64ImageToDisk($personData['image']);
            } else {
                $studentData['image'] = null;
            }
            $this->saveDataToDB($personData, $studentData, $userData);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return makeResponseObject(null, "Ceoula, carné o correo ya existente en el sistema");
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

    /**
     * Save base 64 image to disk with timestamp name
     * 
     * @param string image
     * @return string path
     */
    private function saveBase64ImageToDisk ($image) {
        $photo = base64_decode($image);
        $f = finfo_open();
        $mimeType = finfo_buffer($f, $photo, FILEINFO_MIME_TYPE);
        $name = time().'.'.$this->extensions[$mimeType];
        $pathFromServerRoot = DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$name;

        $file = fopen(public_path().$pathFromServerRoot, 'w');
        fwrite($file, $photo);
        fclose($file);
        return $pathFromServerRoot;
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
        $student->status = 2;// aprobado
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
        $student->status = 3;// rechazado
        $student->save();
        return makeResponseObject("success", null);
    }
}
