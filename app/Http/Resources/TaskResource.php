<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'tags' => json_decode($this->tags),
            'due_date' => $this->due_date,
            'categories' => CategoryResource::collection($this->categories),
            'status'=> $this->status
        ];
    }
}
