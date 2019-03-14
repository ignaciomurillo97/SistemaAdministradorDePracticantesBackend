<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Resources\StudentResource;

class StudentController extends Controller
{
    /**
     * Display a resource with a given id.
     *
     * @param Integer
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student = Student::create($request->all());
        return makeResponseObject("Success", null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        try {
            $student = Student::find($id);
            if ($student != null) {
                $student->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject(null, "El estudiante no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
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
}
