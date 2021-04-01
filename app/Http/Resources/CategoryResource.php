<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'products'    => $this->products,
            'published'   => $this->published,
            'deleted'     => $this->deleted,
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
        //return parent::toArray($request);
    }
}
