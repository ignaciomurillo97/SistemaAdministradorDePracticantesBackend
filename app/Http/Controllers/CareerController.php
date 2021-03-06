<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use App\Http\Resources\CareerResource;

class CareerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $career = Career::find($id);
        if ($career == null) {
            return makeResponseObject("Failed", "No se encontro la carrera");
        }
        return makeResponseObject(new CareerResource($career), null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $career = Career::all();
        return makeResponseObject(CareerResource::collection($career), null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $career = Career::create($request->all());
        return makeResponseObject("Success", null);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        try {
            $career = Career::find($id);
            if ($career != null){
                $career->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "La carrera no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try {
            $career = Career::find($id);
            if ($career != null) {
                $career->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "La carrera no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }
}
