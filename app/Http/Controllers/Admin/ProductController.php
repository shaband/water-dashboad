<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductStoreRequest;
use App\Http\Requests\Admin\Product\ProductUpdateRequest;

use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return ProductResource::collection(Product::with('category','mark')->paginate());
    }

    /**
     * @param ProductStoreRequest $request
     * @return ProductResource
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());

        return new ProductResource($product);
    }


    /**
     * @param Request $request
     * @param Product $product
     * @return ProductResource
     */
    public function show(Request $request, Product $product)
    {
        return new ProductResource($product);
    }


    /**
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return ProductResource
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());

        return new ProductResource($product);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $product->delete();

        return response()->noContent();
    }
}
