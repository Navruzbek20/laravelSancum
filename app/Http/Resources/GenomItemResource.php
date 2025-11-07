<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GenomItemResource extends JsonResource
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
            "id" => $this->id,
            "genom_id" => $this->genom_id,
            "locus_id" => $this->locus_id,
            "a1" => $this->a1,
            "a2" => $this->a2,
            "a3" => $this->a3,
            "a4" => $this->a4,
            "a5" => $this->a5,
            "a6" => $this->a6,
            "a7" => $this->a7,
            "a8" => $this->a8,
            "a9" => $this->a9,
            "status" => $this->status,
            "locus"=>$this->locus->name
        ];
    }
}
