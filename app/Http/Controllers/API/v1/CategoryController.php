<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Category\CategorySaveRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CategoryService $categoryService): JsonResponse
    {
        return $categoryService->index($request);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CategorySaveRequest $request, CategoryService $categoryService): JsonResponse
    {
        DB::beginTransaction();
        try {
            $category = $categoryService->storeCategory($request);
            DB::commit();
            return $category;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function update(CategoryUpdateRequest $request, Category $category, CategoryService $categoryService): jsonResponse
    {
        DB::beginTransaction();
        try {
            $category = $categoryService->updateCategory($request, $category);
            DB::commit();
            return $category;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Category $category, CategoryService $categoryService): jsonResponse
    {
        DB::beginTransaction();
        try {
            $user = $categoryService->deleteCategory($request, $category);
            DB::commit();
            return $user;
        } catch (\Error $th) {
            DB::rollBack();
            return $this->sendErrors(null, $th);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendErrors(null, $e);
        }
    }
}
