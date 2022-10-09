<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'name' => $this->name,
            'national_id' => $this->national_id,
            'email' => $this->email,
            'avatar' => $this->avatar,
            'created_by' => [
                'id' => $this->creator->id,
                'name' => $this->creator->name,
                'role' => $this->creator->getRoleNames()[0],
            ],
        ];
        // return parent::toArray($request);
    }
}
