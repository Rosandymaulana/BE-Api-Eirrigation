<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'content.article';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'desc',
        'location',
        'author',
        'tags',
        'created_at',
        'updated_at',
    ];

    public function article_photo()
    {
        return $this->hasMany(ArticlePhoto::class, 'article_id');
    }
}
