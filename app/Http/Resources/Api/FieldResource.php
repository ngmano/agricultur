<?php

namespace App\Http\Resources\Api;

use Illuminate\{
    Http\Resources\Json\JsonResource,
    Http\Request,
    Http\Response
};
use App\Field;

class FieldResource extends JsonResource
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
            'field_key' => $this->field_key,            
            'field_name' => $this->field_name,
            'field_type_label' => Field::getFieldTypeLabel($this->field_type),
            'field_type' => $this->field_type,
            'area' => $this->area
        ];
    }
}
