<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\{CategoryStoreRequest, CategoryUpdateRequest};
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return CategoryResource::collection(Category::paginate());
    }

    /**
     * @param CategoryStoreRequest $request
     * @return CategoryResource
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }


    /**
     * @param Request $request
     * @param Category $category
     * @return CategoryResource
     */
    public function show(Request $request, Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return CategoryResource
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return new CategoryResource($category);
    }


    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Request $request, Category $category)
    {
        $category->delete();

        return response()->noContent();
    }

    /**
     * @param Request $request
     * @param Category $category
     * @return CategoryResource
     */
    public function block(Request $request, Category $category)
    {
        $category->toggleBlock();
        return new CategoryResource($category);
    }

}
