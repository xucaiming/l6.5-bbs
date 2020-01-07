<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index()
    {
//        return CategoryReource::collection(Category::paginate());

        CategoryResource::wrap('data'); // 添加资源key

        return CategoryResource::collection(Category::all());
    }
}
