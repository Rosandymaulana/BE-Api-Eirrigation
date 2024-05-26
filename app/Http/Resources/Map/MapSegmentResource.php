<?php

namespace App\Http\Resources\Map;

use App\Http\Resources\Report\ReportListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class MapSegmentResource extends JsonResource
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
            'irrigation_id' => $this->irrigation_id,
            'irrigation_section_id' => $this->irrigation_section_id,
            'name' => $this->name,
            'sub_district_name' => $this->sub_district_name,
            'sub_district_type' => $this->sub_district_type,
            'type' => $this->type,
            'length' => $this->length,
            'center_point' => DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(center_point, 4326)) as center_point FROM map.irrigations_segment WHERE id = ?', [$this->id])->center_point,
            'geojson' => DB::selectOne('SELECT ST_AsGeoJSON(ST_Transform(geom, 4326)) as geojson FROM map.irrigations_segment WHERE id = ?', [$this->id])->geojson,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if (isset($this->irrigation)) {
            $data['irrigation'] = new ListResource($this->irrigation);
        }

        return $data;
    }
}
