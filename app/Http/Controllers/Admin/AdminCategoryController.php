<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\CategoryStoreRequest;

class adminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryStoreRequest $request)
    {
        // return $request ;
        if ($request->file('image')) {
            $name = $request->file('image')->getClientOriginalName();
            $image = $request->file('image')->storeAs('categories', $name, 'restaurant');
        }else{
            $image = null;
        }

        Category::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$image
        ]);
        return to_route('admin.categories.index')->with('success', 'Category created successfully.');

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
        $category = Category::findOrFail($id);
        return view('admin.categories.edit',get_defined_vars());
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

        $category = Category::findOrFail($id);
        // return $category;
        $request->validate([
            'name'=>'required',
            'description'=>'required'
        ]);
        if ($request->file('image')!= null) {
            if($category->image != null){
                Storage::disk('restaurant')->delete($category->image);
            }
                $name = $request->file('image')->getClientOriginalName();
                $image = $request->file('image')->storeAs('categories', $name, 'restaurant');
        }else{
            $image = $category->image;
        }
       $category->update([
            'name'=>$request->name,
            'description'=>$request->description,
            'image'=>$image
       ]);
       return to_route('admin.categories.index')->with('success', 'Category created successfully.');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        if($category->image != null){
            Storage::disk('restaurant')->delete($category->image);
        }
        $category->delete();
        return to_route('admin.categories.index');
    }
}
