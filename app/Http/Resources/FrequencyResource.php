<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FrequencyResource extends JsonResource
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
            "id" =>$this->id,
            "population_id" => $this->population_id,
            "locus_id" => $this->locus_id,
            "symbol" => $this->symbol,
            "alel_name" => $this->alel_name,
            "frequency" => $this->frequency,
            "locus" => $this->locus->name,
            "population" => $this->population->name
        ];

    }
}
