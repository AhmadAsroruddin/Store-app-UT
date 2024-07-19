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
}
