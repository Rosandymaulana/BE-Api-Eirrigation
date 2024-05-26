<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        $statusCounts = [
            'PROG' => 0,
            'FOLUP' => 0,
            'RJT' => 0,
        ];

        foreach ($this as $count) {
            $statusCounts[$count->status_id] = $count->count;
        }


        return $statusCounts;
    }
}
