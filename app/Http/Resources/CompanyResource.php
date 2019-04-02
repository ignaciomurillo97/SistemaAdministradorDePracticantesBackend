<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'legal_id'=>$this->legal_id,
            'person_id'=>$this->person_id,
            'name'=>$this->name,
            'address'=>$this->address
        ];
    }
}
