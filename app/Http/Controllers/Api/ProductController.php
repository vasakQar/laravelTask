<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\ProductNameRequest;
use App\Http\Resources\Api\ProductResource;
use App\Models\Product;
use App\Models\ProductLocalization;
use Illuminate\Support\Arr;

class ProductController extends Controller
{

    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $products = Product::query()->paginate(5);

        return ProductResource::collection($products);
    }

    /**
     * @param CreateProductRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateProductRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $prodData = Arr::except($data, ['lang_id', 'name']);

        $product = Product::create($prodData);
        $product->names()->create(['lang_id' => $data['lang_id'], 'name' => $data['name']]);

        return response()->json(['success' => true, 'message' => 'Product has been created successfully!']);
    }

    /**
     * @param Product $product
     * @return ProductResource
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * @param CreateProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CreateProductRequest $request, Product $product): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $prodData = Arr::except($data, ['lang_id', 'name']);

        $product->update($prodData);
        ProductLocalization::query()->where([['product_id', $product->id], ['lang_id', $data['lang_id']]])->update(['name' => $data['name']]);

        return response()->json(['success' => true, 'message' => 'Product has been updated successfully']);
    }

    /**
     * @param ProductNameRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addNewName(ProductNameRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        ProductLocalization::create($data);

        return response()->json(['success' => true, 'message' => 'Product name has been created successfully']);
    }

    public function destroy($id)
    {
        //
    }
}
