<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CareerAndSitePerCompanyResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $requests = [];
        foreach ($this->collection as $request) {
            array_push ($requests, [
                'id' => $request->id,
                'site' => $request->site,
                'career' => $request->career,
                'company' => $request->company
            ]);
        }
        return $requests;
    }
}
