<?php

namespace App\Http\Controllers;


use App\Models\Category;

class CategoryController extends Controller
{
   public function getCategories()
    {

        $categories = Category::all();

       
        return $this->apiResponse(
            true,
            'Categories retrieved successfully',
            $categories,
            200
        );
    }
}
