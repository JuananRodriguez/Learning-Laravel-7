<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Task extends JsonResource
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
            'description' => $this->description,
            'project' => $this->project,
            'project_id' => $this->project_id,
            'created_at' => $this->created_at->timezone('Europe/Madrid')->toDateTimeString(),
            'updated_at' => $this->updated_at->timezone('Europe/Madrid')->toDateTimeString(),
        ];
    }
}
