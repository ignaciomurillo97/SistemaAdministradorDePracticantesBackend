<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerAndSitePerCompany;
use App\Http\Resources\CareerAndSitePerCompanyResource;

class CoordinatorController extends Controller
{
    public function getCompanyRegistrationRequest (Request $request) {
        $coordinator = auth()->guard('api')->user()->person->coordinator;
        //dd($coordinator);

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
}
