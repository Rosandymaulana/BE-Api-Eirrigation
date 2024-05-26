<?php

namespace App\Http\Resources\Report;

use App\Http\Resources\Map\BangunanIrigasiResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportBuildingResource extends JsonResource
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
            'report_id' => $this->report_id,
            'building_id' => $this->building_id,
            'level' => $this->level,
            'type' => $this->type,
            'rate' => $this->rate,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($request->has('embed')) {
            $embedValues = explode(',', $request->get('embed'));

            if (in_array('building_details', $embedValues)) {
                $data['irrigations_building'] = new BangunanIrigasiResource($this->build);
            }

            if (in_array('photo', $embedValues)) {
                $photos = $this->report_photo_building->map(function ($photo) {
                    return new ReportPhotoResource($photo);
                });

                $data['photo'] = $photos->toArray();
            }

            if (in_array('photo_after', $embedValues)) {
                $photos = $this->report_photo_repair_building->map(function ($photo) {
                    return new ReportPhotoRepairBuildingResource($photo);
                });

                $data['photo_after'] = $photos->toArray();
            }
        }

        return $data;
    }
}
