<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MenuStoreRequest;
use Illuminate\Support\Facades\Storage;

class AdminMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Bid =Category::where('name','Breakfast')->pluck('id');
        $breakfast = Menu::where('category_id',$Bid)->get();

       


        $Did =Category::where('name','dessert')->pluck('id');
        $dessert = Menu::where('category_id',$Did)->get();

        return view('admin.menus.dessert', get_defined_vars());
    }

    public function breakfast()
    {
        $Bid =Category::where('name','Breakfast')->pluck('id');
        $breakfast =Menu::with('category')->where('category_id',$Bid)->get();
        return view('admin.menus.breakfast', get_defined_vars());
    }

    public function lunch()
    {
        $Lid =Category::where('name','Lunch')->pluck('id');
        $lunch = Menu::where('category_id',$Lid)->get();
        return view('admin.menus.lunch', get_defined_vars());
    }

    public function dessert()
    {
        $Bid =Category::where('name','dessert')->pluck('id');
        $dessert = Menu::where('category_id',$Bid)->get();
        return view('admin.menus.dessert', get_defined_vars());
    }

    public function drink()
    {
        $Did =Category::where('name','drinks')->pluck('id');
        $drinks = Menu::where('category_id',$Did)->get();
        return view('admin.menus.drink', get_defined_vars());
    }

    
    public function special()
    {
        $cat =Category::where('name','special')->pluck('id');
        $specials = Menu::where('category_id',$cat)->get();
        return view('admin.menus.special', get_defined_vars());
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.menus.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MenuStoreRequest $request)
    {
        if ($request->file('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $image = $request->file('image')->storeAs('menus', $name, 'restaurant');
        }
        $menu = Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'category_id' => $request->category_id

        ]);
       
        return to_route('admin.menus.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu = Menu::findOrFail($id);       
        $categories = Category::all();

        return view('admin.menus.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
            'category_id' => 'required'

        ]);
        if ($request->file('image')) {
                Storage::disk('restaurant')->delete($menu->image);
                $name = $request->file('image')->getClientOriginalName();
                $image = $request->file('image')->storeAs('menus', $name, 'restaurant');
         }else{
            $image=$menu->image;
         }
        $menu->update([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $image,
            'price' => $request->price,
            'category_id' => $request->category_id


        ]);
          $category= Category::findOrFail($request->category_id)->name;
        return to_route("admin.menus.".$category)->with('success', 'Menu created successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
       
        if ($menu->image != null) {
            Storage::disk('restaurant')->delete($menu->image);
        }
        $menu->delete();
        $category= Category::findOrFail($menu->category_id)->name;
        return to_route("admin.menus.".$category)->with('success', 'Menu deleted successfully.');
    }
}
