<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'category' => isset($this->category[app()->getLocale()]) ? $this->category[app()->getLocale()] : $this->category['en'],
            // 'number' => number_format($this->id, 2) 
        ];
    }
}

//// category[en]