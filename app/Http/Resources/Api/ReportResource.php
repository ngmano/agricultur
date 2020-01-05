<?php

namespace App\Http\Resources\Api;

use Illuminate\{
    Http\Resources\Json\JsonResource,
    Http\Request,
    Http\Response
};
use App\Field;

class ReportResource extends JsonResource
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
            'tractor_name' => $this->tractor_name,
            'field_name' => $this->field_name,
            'fied_type' => Field::getFieldTypeLabel($this->field_type),
            'area' => $this->area,
            'date' => date('d-M-Y', strtotime($this->date)),
        ];
    }
}
