<?php

namespace App\Http\Resources\Report;

use App\Http\Resources\Map\MapSegmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportSegmentResource extends JsonResource
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
            'segment_id' => $this->segment_id,
            'level' => $this->level,
            'type' => $this->type,
            'rate' => $this->rate,
            'note' => $this->note,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if ($request->has('embed')) {
            $embedValues = explode(',', $request->get('embed'));

            if (in_array('segmen', $embedValues)) {
                $data['segmen'] = new MapSegmentResource($this->segmen);
            }

            if (in_array('photo', $embedValues)) {
                $photos = $this->report_photo->map(function ($photo) {
                    return new ReportPhotoResource($photo);
                });

                $data['photo'] = $photos->toArray();
            }

            if (in_array('photo_after', $embedValues)) {
                $photos = $this->report_photo_repair->map(function ($photo) {
                    return new ReportPhotoRepairResource($photo);
                });

                $data['photo_after'] = $photos->toArray();
            }
        }

        return $data;
    }
}
