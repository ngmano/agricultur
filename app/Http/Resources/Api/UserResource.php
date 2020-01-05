<?php

namespace App\Http\Resources\Api;

use Illuminate\{
    Http\Resources\Json\JsonResource,
    Http\Request,
    Http\Response
};

class UserResource extends JsonResource
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
            'user_key' => $this->user_key,            
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'api_token' => $this->api_token
        ];
    }
}
