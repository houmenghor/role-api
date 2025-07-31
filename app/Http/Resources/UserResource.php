<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage; // <-- This import is crucial

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
            'email' => $this->email,
            'role' => [
                'id' => $this->role->id,
                'name' => $this->role->name
            ],
            'is_active' => $this->is_active,
            'userProfile' => [
                'name' => $this->userProfile->name,
                'gender' => $this->userProfile->gender,
                'dob' => $this->userProfile->dob,
                'phone' => $this->userProfile->phone,
                // This is the correct way to get the URL from the 'r2' disk
                'photo' => Storage::disk('r2')->url($this->userProfile->photo),
            ]
        ];
    }
}