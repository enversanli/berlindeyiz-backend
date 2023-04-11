<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'date_from' => $this->date_from ? Carbon::parse($this->date_from)->format('d-m-Y') : null,
            'date_to' => $this->date_to ? Carbon::parse($this->date_to)->format('d-m-Y') : null,
            'start_time' => $this->start_time ? Carbon::parse($this->start_time)->format('H:i') : null,
            'end_time' => $this->end_time ? Carbon::parse($this->end_time)->format('H:i') : null,
            'status' => $this->status,
            'logo' => $this->logo,
            'guide' => $this->guide,
            'types' => $this->types,
            'price' => $this->price,
            'is_priced' => $this->is_priced,
            'internal_ticket' => $this->internal_ticket,
            'questions' => $this->questions,
            'city' => $this->city,
            'category' => $this->category,
            'meta' => $this->meta,
            'type' => $this->type,
            'created_at' => $this->created_at,
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
