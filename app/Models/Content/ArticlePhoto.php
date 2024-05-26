<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticlePhoto extends Model
{
    use HasFactory;
    protected $table = 'content.article_photo';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable = [
        'upload_dump_id',
        'filename',
        'file_url',
        'created_at',
        'updated_at',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
