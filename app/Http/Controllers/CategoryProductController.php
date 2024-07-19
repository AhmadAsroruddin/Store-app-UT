<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\UpdateProductCategoryRequest;
use App\Services\CategoryProductService;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;


class CategoryProductController extends Controller
{
    protected $categoryProductService;

    public function __construct(CategoryProductService $categoryProductService)
    {
        $this->categoryProductService = $categoryProductService;
        $this->middleware('auth:api');
    }

    public function getAll()
    {
        $categories = $this->categoryProductService->getAll();
        return response()->json($categories);
    }

    public function getById($id)
    {
        $category = $this->categoryProductService->getById($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }
        return response()->json($category);
    }

    public function store(ProductCategoryRequest $request)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:category_products,name',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }

        // Proceed with adding category
        $category = $this->categoryProductService->addCategory($request->all());
        return response()->json($category, 201);
    }

    public function update(UpdateProductCategoryRequest $request, $id)
    {
        $category = $this->categoryProductService->getById($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:category_products,name',
        ]);

        // Handle validation failure
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ], 422);
        }


        $category = $this->categoryProductService->update($id, $request->all());
        return response()->json($category);
    }

    public function delete($id)
    {
        $category = $this->categoryProductService->getById($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        Product::where('product_category_id', $id)->delete();

        $this->categoryProductService->delete($id);
        return response()->json(['message' => 'Category deleted successfully']);
    }
}

