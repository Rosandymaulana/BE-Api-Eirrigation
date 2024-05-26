<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\RoleResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data = [
            'id' => $this->id,
            'urole_id' => $this->urole_id,
            'username' => $this->username,
            'shortname' => $this->shortname,
            'email' => $this->email,
            'fullname' => $this->fullname,
            'avatar' => $this->avatar,
            'phone' => $this->phone,
            'last_active' => $this->last_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'role' => RoleResource::collection($this->whenLoaded('urole_id')),
        ];

        if ($request->has('embed') && $request->get('embed') === 'role') {
            $data['role'] = new RoleResource($this->role);
        }

        return $data;
    }
}
