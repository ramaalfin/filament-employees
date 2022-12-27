<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'address' => $this->address,
            'countryId' => $this->countryId,
            'stateId' => $this->stateId,
            'cityId' => $this->cityId,
            'departmentId' => $this->departmentId,
            'zip_code' => $this->zip_code,
            'birthDate' => $this->birthDate,
            'dateHired' => $this->dateHired,
        ];
    }
}
