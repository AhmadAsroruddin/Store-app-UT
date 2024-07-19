<?php

namespace App\Services;

use App\Models\Category_Product;

class CategoryProductService{
    public function addCategory($data){
        return Category_Product::create($data);
    }

    public function getAll(){
        return Category_Product::all();
    }

    public function getById($id){
        return Category_Product::find($id);
    }

    public function update($id, $data)
    {
        $category = Category_Product::find($id);
        if ($category) {
            $category->update($data);
        }
        return $category;
    }

    public function delete($id)
    {
        $category = Category_Product::find($id);
        if ($category) {
            $category->delete();
        }
        return $category;
    }
}