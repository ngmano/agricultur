<?php

namespace App\Http\Resources\Api;

use Illuminate\{
    Http\Resources\Json\JsonResource,
    Http\Request,
    Http\Response
};
use App\ProcessField;

class ProcessFieldResource extends JsonResource
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
            'process_field_key' => $this->process_field_key,            
            'tractor_key' => $this->tractor_key,
            'tractor_name' => $this->tractor_name,
            'field_key' => $this->field_key,
            'field_name' => $this->field_name,
            'area' => $this->area,
            'date' => date('d-M-Y', strtotime($this->date)),
            'status' => $this->status,
            'status_label' => ProcessField::getStatusLabel($this->status)
        ];
    }
}
