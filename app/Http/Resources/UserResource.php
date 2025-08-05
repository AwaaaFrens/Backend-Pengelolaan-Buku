<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'updated_at' => $this->updated_at,
            'is_active' => $this->is_active,
            'primary_role' => $this->whenLoaded('roles', function () {
                return $this->roles->pluck('name')->first();
            }),
            'roles' => $this->roles->pluck('name') ?? null,
        ];
    }
}
