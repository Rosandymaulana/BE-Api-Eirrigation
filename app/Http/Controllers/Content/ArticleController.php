<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Http\Resources\Content\ArticleResource;
use App\Models\Content\Article;
use App\Services\Content\ArticleFilter;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articleFilter = new ArticleFilter();
        $queryItems = $articleFilter->transform($request);

        $query = QueryBuilder::for(Article::class)
            ->allowedSorts(['title', 'desc', 'image', 'created_at', 'updated_at'])
            ->with('article_photo');

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

        return ArticleResource::collection($article);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'author' => 'required',
                'title' => 'required',
                'desc' => 'required',
                'image' => 'required',
                'location' => 'sometimes',
                'tags' => 'sometimes',
            ]);

            $article = Article::create($validatedData);

            return response()->json([
                'message' => 'Artilce created successfully',
                'data' => new ArticleResource(($article)),
            ], 201);
        } catch (ValidationException $err) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $err->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $articleId = Article::findOrFail($id);

        return new ArticleResource($articleId);
    }

    public function update(Request $request, $id)
    {
        try {
            $article = Article::findOrFail($id);

            $validatedData = $request->validate([
                'author' => 'sometimes',
                'title' => 'sometimes',
                'desc' => 'sometimes',
                'image' => 'sometimes',
                'location' => 'sometimes',
                'tags' => 'sometimes',
            ]);

            $article->update($validatedData);

            return response()->json([
                'message' => 'Article updated successfully',
                'data' => new ArticleResource($article),
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'message' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $role = Article::findOrFail($id);
            $role->delete();

            return response()->json([
                'message' => 'Article deleted successfully',
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Article not found with provided ID',
                'message' => $e->getMessage(),
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete Article',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
