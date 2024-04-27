<?php

namespace App\Services;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Traits\ApiResponses;
use Illuminate\Http\JsonResponse;
class CategoryService
{
    use ApiResponses;
    public function index($request):JsonResponse
    {
        $per_page = $request->input('per_page', 30);
        $name = $request->input('name', null);
        $categories = Category::query();
        if($name){
            $categories = $categories->where('name', 'like', '%'.$name.'%');
        }
        $categories = $categories->paginate($per_page);
        return $this->sendResponse('Categories retrieved successfully!', CategoryResource::collection($categories)->resource);


    }
    public function storeCategory($request): JsonResponse
    {
        $category = Category::create([
            'name' => $request->name
        ]);
        return $this->sendResponse('Category created successfully!', new CategoryResource($category));
    }
    public function updateCategory($request, $category): JsonResponse
    {
        $category->update([
            'name' => $request->name
        ]);
        return $this->sendResponse('Category updated successfully!', new CategoryResource($category));
    }
    public function deleteCategory($request, $category): JsonResponse
    {
        $category->delete();
        return $this->sendResponse('Category deleted successfully!', new CategoryResource($category));
    }

}
