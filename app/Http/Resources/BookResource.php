<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
        'id' => $this->id,
        'name' => $this->name,
        'ISBN' => $this->ISBN,
        'publication_year' => $this->publication_year,
        'publiser' => $this->publiser,
        'subscription_status' => $this->subscription_status,
        'image' => $this->image,
        'created_at' => (string) $this->created_at,
        'updated_at' => (string) $this->updated_at,
      ];
    }
}
