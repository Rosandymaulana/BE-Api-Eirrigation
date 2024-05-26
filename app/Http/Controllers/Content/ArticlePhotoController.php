<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Resources\Content\ArticlePhotoResource;
use App\Models\Content\Article;
use App\Models\Content\ArticlePhoto;
use App\Services\Content\ArticlePhotoFilter;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ArticlePhotoController extends Controller
{
    public function index(Request $request)
    {
        $articleFilter = new ArticlePhotoFilter();
        $queryItems = $articleFilter->transform($request);

        $query = QueryBuilder::for(ArticlePhoto::class)
            ->allowedSorts([
                'article_id',
                'upload_dump_id',
                'filename',
                'file_url', 'created_at', 'updated_at'
            ]);

        foreach ($queryItems as $filter) {
            $query->where($filter[0], $filter[1], $filter[2]);
        }

        if ($request->has('limit')) {
            $article = $query->paginate($request->query('limit'));
        } else {
            $article = $query->paginate();
        }

        $article->getCollection()->transform(function ($article) {
            return $article;
        });

        return ArticlePhotoResource::collection($article);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'article_id' => 'required',
                'upload_dump_id' => 'required',
                'filename' => 'required',
                'file_url' => 'required',
            ]);

            $article = Article::findOrFail($validatedData['article_id']);

            $article = ArticlePhoto::create($validatedData);

            return response()->json([
                'message' => 'Photo Article created successfully',
                'data' => new ArticlePhotoResource(($article)),
            ], 201);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Article not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update Photo Article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
