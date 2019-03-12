<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Http\Resources\SiteResource;

class SiteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(int $id)
    {
        $site = Site::find($id);
        if ($site == null) {
            return makeResponseObject("Failed", "No se encontro la sede");
        }
        return makeResponseObject(new SiteResource($site), null);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function all()
    {
        $site = Site::all();
        return makeResponseObject(SiteResource::collection($site), null);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $site = Site::create($request->all());
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
            $site = Site::find($id);
            if ($site != null){
                $site->update($request->all());
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "La sede no existe");
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
            $site = Site::find($id);
            if ($site != null) {
                $site->delete();
                return makeResponseObject("Success", null);
            }
            return makeResponseObject("Failed", "La sede no existe");
        } catch (\Exception $e) {
            return makeResponseObject(null, $e->getMessage());
        }
    }

}
