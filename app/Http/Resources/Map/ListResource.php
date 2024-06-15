<?php

namespace App\Http\Resources\Map;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class ListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $data =  [
            'id' => $this->id,
            'district_id' => $this->district_id,
            'sub_district_id' => $this->sub_district_id,
            'name' => $this->name,
            'type' => $this->type,
            'length' => $this->length,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'geojson' =>
            DB::selectOne('SELECT *, ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations WHERE id = ?', [$this->id])->geojson,
            'district' => DistrictResource::collection($this->whenLoaded('district_id')),
            'sub_district' => DistrictResource::collection($this->whenLoaded('sub_district_id')),
        ];

        if ($request->has('embed')) {
            $embedFields = explode(',', $request->get('embed'));

            foreach ($embedFields as $field) {
                if ($field === 'district') {
                    $data['district'] = new DistrictResource($this->district);
                }
                if ($field === 'sub_district') {
                    $data['sub_district'] = new SubDistrictResource($this->sub_district);
                }
            }
        }

        return $data;
    }
}
