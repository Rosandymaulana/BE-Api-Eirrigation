<?php

namespace App\Http\Resources\Map;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubDistrictResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'city_id' => $this->city_id,
            'district_id' => $this->district_id,
            'name' => $this->name,
            'type' => $this->type,
            'area_km2' => $this->area_km2,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'geojson' => $this->geojson,
        ];
    }
}
