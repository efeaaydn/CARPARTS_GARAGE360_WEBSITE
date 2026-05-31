<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryApiController extends Controller
{
    public function children(int $parentId)
    {
        $children = Category::where('parent_id', $parentId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name']);

        return response()->json($children);
    }
}
