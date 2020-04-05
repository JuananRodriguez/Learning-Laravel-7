<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'surname' => $this->surname,
           /*  'tasks' => $this->tasks,
            'users' => $this->users, */
            'created_at' => $this->created_at->timezone('Europe/Madrid')->toDateTimeString(),
            'updated_at' => $this->updated_at->timezone('Europe/Madrid')->toDateTimeString(),
        ];
    }
}
