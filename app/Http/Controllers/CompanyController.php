<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Person;
use App\Models\User;
use App\Models\Career;
use App\Models\Site;
use App\Models\CareerAndSitePerCompany;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\CareerAndSitePerCompanyResource;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return response()->json(['data'=> $companies,'error' => NULL]);
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
        $companyData = $requestContents['company'];
        $userData = $requestContents['user'];
        $personData = $requestContents['person'];
        $this->setDefaultValues($companyData, $userData, $personData);

        try {
            $this->saveDataToDB($personData, $companyData, $userData);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return makeResponseObject(null, "Cédula, cédula jurídica o correo ya existente en el sistema");
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

    private function saveDataToDB ($personData, $companyData, $userData) {
        $person = Person::create($personData);
        $person->save();
        $person->user()->save(User::create($userData));
        $company = Company::create($companyData);
        $company->save();
    }

    private function setDefaultValues(&$companyData, &$userData, &$personData) {
        $userData["person_id"] = $personData["id"];
        $userData["scope_id"] = 4; // Company scoppe id
        $companyData["person_id"] = $personData["id"];
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
        $company = Company::find($id);
        return response()->json(['data'=> ['company' => $company] ,'error' => NULL]);
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
        //
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

    public function requestRegistrationToCareer(Request $request) {
        $careerId = $request->input('career_id');
        $siteId = $request->input('site_id');

        $company = auth()->guard('api')->user()->person->company;

        if (!existsInDB(Career::Class, $careerId)) {
            return makeResponseObject(null, 'career does not exist');
        }
        if (!existsInDB(Site::Class ,$siteId)) {
            return makeResponseObject(null, 'site does not exist');
        }

        $data = [
            'career_id' => $careerId,
            'site_id' => $siteId,
            'company_id' => $company->legal_id,
            'status' => 'pending'
        ];
        $careerAndSiteRelation = new CareerAndSitePerCompany($data);

        $queryResult = CareerAndSitePerCompany::where('career_id', $careerId)
            ->where('site_id', $siteId)
            ->where('company_id', $company->legal_id)
            ->first();
            
        if (isset($queryResult)) {
            return makeResponseObject(null, 'Una solicitud ya ha sido enviada');
        }

        $careerAndSiteRelation->save();
        return makeResponseObject('success', null);
    }

    public function getRegistrationRequest (Request $request) {
        $company = auth()->guard('api')->user()->person->company;

        return new CareerAndSitePerCompanyResource(
            CareerAndSitePerCompany::where('company_id', $company->legal_id)->get()
        );
    }

    public function aproveRegistration (Request $request, int $id) {
        $relation = CareerAndSitePerCompany::find($id);
        $relation->status = 'aproved';
        $relation->save();
        return makeResponseObject('success', null);
    }

    public function denyRegistration (Request $request, int $id) {
        $relation = CareerAndSitePerCompany::find($id);
        $relation->status = 'denied';
        $relation->save();
        return makeResponseObject('success', null);
    }
}
