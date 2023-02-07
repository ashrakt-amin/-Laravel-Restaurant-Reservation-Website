<?php

namespace App\Http\Controllers\UI;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(){
        $categories =Category::all();
        return view('ui.categories.index',get_defined_vars());
    }

    public function show($id){
        $category = Category::findOrFail($id);
        return view('ui.categories.show',get_defined_vars());
    }
}
