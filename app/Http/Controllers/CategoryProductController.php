<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\CategoryProductService;


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

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);

        $category = $this->categoryProductService->create($request->all());
        return response()->json($category, 201);
    }

    public function update(Request $request, $id)
    {
        $category = $this->categoryProductService->getById($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $this->validate($request, [
            'name' => 'required|string|max:255'
        ]);

        $category = $this->categoryProductService->update($id, $request->all());
        return response()->json($category);
    }

    public function delete($id)
    {
        $category = $this->categoryProductService->getById($id);
        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $this->categoryProductService->delete($id);
        return response()->json(['message' => 'Category deleted successfully']);
    }
}
