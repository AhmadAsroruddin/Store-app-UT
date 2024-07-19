<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProductService;


class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
        $this->middleware('auth:api');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image');
        }

        $result = $this->productService->create($data);

        if (isset($result['errors'])) {
            return response()->json($result, 422);
        }

        return response()->json($result, 201);
    }

    public function getAll(){
        $products = $this->productService->getAll();
        return response()->json($products);
    }

    public function getById($id){
        $product = $this->productService->getById($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }
        return response()->json($product);
    }

    public function update($id, Request $request)
    {
        $result = $this->productService->updateProduct($id, $request);

        if ($result['status'] == 'error') {
            return response()->json($result, 422);
        }

        return response()->json($result['product']);
    }

    public function destroy($id)
    {
        $result = $this->productService->deleteProduct($id);

        if (!$result) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
