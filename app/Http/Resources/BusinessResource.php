<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'title' => $this->title,
          'description' => $this->description,
          'address' => $this->address,
          'email' => $this->email,
          'website' => $this->website,
          'status' => $this->status,
          'mobile_phone' => $this->mobile_phone,
          'office_phone' => $this->office_phone,
          'photo' => $this->photo,
          'meta' => $this->meta,
          'city' => $this->city,
          'district' => $this->district,
        ];
    }
}
