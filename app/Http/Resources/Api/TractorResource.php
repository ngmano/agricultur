<?php

namespace App\Http\Resources\Api;

use Illuminate\{
    Http\Resources\Json\JsonResource,
    Http\Request,
    Http\Response
};
use App\Tractor;

class TractorResource extends JsonResource
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
            'tractor_key' => $this->tractor_key,            
            'tractor_name' => $this->tractor_name
        ];
    }
}
