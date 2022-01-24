<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function getProductByCategory($id){
        $category = Category::find($id);
        $products = $category->products;
        return view('product.category')->with('products',$products);
    }
}
