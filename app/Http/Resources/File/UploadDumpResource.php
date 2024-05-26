<?php

namespace App\Http\Resources\File;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadDumpResource extends JsonResource
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
            'filename' => $this->filename,
            'file_type' => $this->file_type,
            'size' => $this->size,
            'folder' => $this->folder,
            'rel_path' => $this->file_url,
            'uploader_ip' => $this->uploader_ip,
            'uploader_status' => $this->uploader_status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
