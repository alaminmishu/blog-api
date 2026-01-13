<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StoreCategoryRequest;
use App\Http\Requests\Api\V1\UpdateCategoryRequest;
use App\Http\Resources\Api\V1\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('children', 'posts')
            ->with('parent')
            ->whereNull('parent_id') // Only root categories
            ->latest()
            ->get();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $this->authorize('create', Category::class);

        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);

        $category = Category::create($data);

        return (new CategoryResource($category))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return new CategoryResource($category->loadCount('children', 'posts')->load('parent'));
    }

    /**
     * Update a category
     *
     * @urlParam category integer required The category ID. Example: 1
     *
     * @response 200 {
     *   "data": {
     *     "id": 1,
     *     "name": "Updated Category"
     *   }
     * }
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $this->authorize('update', $category);

        $data = $request->validated();
        if (isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $category->update($data);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): JsonResponse
    {
        $this->authorize('delete', $category);

        $category->delete();

        return response()->json([
            'message'=> 'Category deleted successfully',
        ], 200);
    }
}
