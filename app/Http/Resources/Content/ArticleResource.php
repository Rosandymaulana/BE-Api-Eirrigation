<?php

namespace App\Http\Resources\Content;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'title' => $this->title,
            'desc' => $this->desc,
            'image' => $this->image,
            'location' => $this->location,
            'author' => $this->author,
            'tags' => $this->tags,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'photo' => ArticlePhotoResource::collection($this->whenLoaded('photo')),

        ];

        if ($request->has('embed') && $request->get('embed') === 'photo') {
            $data['photo'] = ArticlePhotoResource::collection($this->article_photo);
        }


        return $data;
    }
}
