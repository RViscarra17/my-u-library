<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CheckoutResponse extends JsonResource
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
            'name' => "{$this->user->first_name} {$this->user->last_name}",
            'book' => $this->book->title,
            'checkout_date' => Carbon::create($this->created_at, 'America/El_Salvador')->format('m/d/Y'),
            'returned' => $this->returned,
        ];
    }
}
