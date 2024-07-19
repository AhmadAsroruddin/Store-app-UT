<?php

namespace App\Services;

use App\Models\Category_Product;

class CategoryProductService{
    public function addCategory($data){
        return CategoryProduct::create($data);
    }

    public function getAll(){
        return Category_Product::all();
    }

    public function getById($id){
        return CategoryProduct::find($id);
    }

    public function update($id, $data)
    {
        $category = CategoryProduct::find($id);
        if ($category) {
            $category->update($data);
        }
        return $category;
    }

    public function delete($id)
    {
        $category = CategoryProduct::find($id);
        if ($category) {
            $category->delete();
        }
        return $category;
    }
}