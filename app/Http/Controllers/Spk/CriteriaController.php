<?php

namespace App\Http\Controllers\Spk;

use App\Http\Controllers\Controller;
use App\Http\Resources\Spk\CriteriaResource;
use App\Models\Spk\Criteria;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class CriteriaController extends Controller
{
    public function index(Request $request)
    {
        $query = QueryBuilder::for(Criteria::class)
            ->allowedSorts(['id', 'name', 'weight', 'type', 'created_at', 'updated_at']);

        if ($request->has('limit')) {
            $role = $query->paginate($request->query('limit'));
        } else {
            $role = $query->paginate();
        }

        $role->getCollection()->transform(function ($roles) {
            return $roles;
        });

        return CriteriaResource::collection($role);
    }
}
