<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public static $wrap = 'products';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return[
            'name' => $this->name,
            'price' => $this->price,
            'price_float' => $this->price_float,
            'categories' => $this->whenLoaded('categories'),
            'photos' => $this->whenLoaded('photos'),
        ];
    }
}
