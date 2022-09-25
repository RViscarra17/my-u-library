<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'description' => $this->when($this->description, $this->description),
            'author' => $this->author,
            'published_year' => $this->when($this->published_year, $this->published_year),
            'genre' => $this->whenLoaded('genre', fn() => $this->genre->name),
            'stock' => $this->when($this->stock, $this->stock),
        ];
    }
}
