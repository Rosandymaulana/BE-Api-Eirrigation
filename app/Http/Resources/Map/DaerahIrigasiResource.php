<?php

namespace App\Http\Resources\Map;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DaerahIrigasiResource extends JsonResource
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
            'sub_district_id' => $this->sub_district_id,
            'name_di' => $this->name_di,
            'status' => $this->status,
            'area_ha' => $this->area_ha,
            'information' => $this->information,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'geojson' => $this->geojson,
        ];

        return $data;
    }
}
