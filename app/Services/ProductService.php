<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category_Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductService{
    public function create(array $data)
    {
        
        $validator = Validator::make($data, [
            'product_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);


        $category = Category_Product::find($data['product_category_id']);
        if (!$category) {
            return ['status' => 'error', 'message' => 'Category not found'];
        }
        if ($validator->fails()) {
            return [
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ];
        }



        if (isset($data['image']) && $data['image']->isValid()) {
            $path = $data['image']->store('public/images');
            $data['image'] = basename($path);
        }

        return Product::create($data);
    }

    public function getAll()
    {
        return Product::all();
    }

    public function getById($id){
        return Product::find($id);
    }

    public function updateProduct($id, Request $request) // Ubah tipe argumen di sini
    {
        $product = Product::find($id);
        if (!$product) {
            return ['status' => 'error', 'message' => 'Product not found'];
        }

        // Validate request data
        $validator = Validator::make($request->all(), [
            'product_category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string'
        ]);

        $category = Category_Product::find($request['product_category_id']);
        if (!$category) {
            return ['status' => 'error', 'message' => 'Category not found'];
        }

        if ($validator->fails()) {
            return [
                'status' => 'error',
                'errors' => $validator->errors(),
                'message' => 'Validation failed'
            ];
        }

        // Handle file upload
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($product->image) {
                Storage::delete('public/images/' . $product->image);
            }
            $path = $image->store('public/images');
            $data['image'] = basename($path);
        } else {
            $data['image'] = $product->image; // Keep old image if no new image is uploaded
        }

        $product->update($data);

        return ['status' => 'success', 'product' => $product];
    }
    

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return null;
        }

        if ($product->image) {
            Storage::delete('public/images/' . $product->image);
        }

        $product->delete();
        return true;
    }
}
