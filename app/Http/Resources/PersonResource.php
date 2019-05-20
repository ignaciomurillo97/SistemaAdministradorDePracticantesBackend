<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PersonResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'lastName' => $this->lastName,
            'secondLastName' => $this->secondLastName,
            'gender_id' => $this->gender_id,
            'birthday' => $this->birthday,
            'telephone' => $this->telephone,
            'student' => $this->student,
            'company' => $this->company,
            'coordinator' => $this->coordinator
        ];
    }
}
