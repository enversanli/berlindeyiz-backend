<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'slug' => $this->slug,
            'text' => $this->text,
            'date_from' => $this->date_from,
            'date_to' => $this->date_to,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
            'logo' => $this->logo,
            'created_at' => $this->created_at,
            'guide' => $this->guide,
            'types' => $this->types,
            'price' => $this->price,
            'is_priced' => $this->is_priced,
            'questions' => $this->questions,
            'city' => $this->city,
            'category' => $this->category,
        ];
    }

    private function setRating($rating){
        if ($rating == 'promising'){
            return __('common.promising');
        }
        if ($rating == 'high'){
            return __('common.high');
        }
        if ($rating == 'not_rated' || $rating == null){
            return __('common.not_rated');
        }
    }
}
