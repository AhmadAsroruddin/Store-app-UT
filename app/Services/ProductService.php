<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
}
