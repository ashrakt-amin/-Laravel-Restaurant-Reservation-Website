<?php

namespace App\Http\Controllers\UI;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;

class MenuController extends Controller
{
    public function index()
    {
        return view('ui.menus.index');
    }

    public function breakfast($id)
    {
        $category = Category::findOrFail($id);
        // return $category;
        $menus = Menu::where('category_id', $category->id)->get();
        return view('ui.menus.breakfast', get_defined_vars());
    }

    public function lunch($id)
    {
        $category = Category::findOrFail($id);
        $menus = Menu::where('category_id', $category->id)->get();
        return view('ui.menus.lunch', get_defined_vars());
    }

    public function dessert($id)
    {
        $category = Category::findOrFail($id);
        $menus = Menu::where('category_id', $category->id)->get();       
        return view('ui.menus.dessert', get_defined_vars());
    }

    public function drinks($id)
    {
        $category = Category::findOrFail($id);
        $menus = Menu::where('category_id', $category->id)->get();
        return view('ui.menus.drinks', get_defined_vars());
    }

    public function special($id)
    {
        $category = Category::where('name','special')->findOrFail($id);  
        $menus = Menu::where('category_id', $category->id)->get();
        return view('ui.menus.special', get_defined_vars());
    }
}
