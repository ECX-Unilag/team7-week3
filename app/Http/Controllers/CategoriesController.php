<?php

namespace App\Http\Controllers;
use App\Category;
use App\Post;
use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  $categories= DB::table('categories')->get();
        // return view('category.index')->with($categories);
        return view('category.index')->with('categories', Category::all())->with('category', '');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        
        $data = request()->all();
        $category = new Category();
        $category->name = $data['name'];
        $category->save();
        session()->flash('success', 'category created successfully');
        return redirect(route('category.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       return $category = DB::table('categories')->where('id',$id);
        // return view('category.edit')->with('categories', Category::all($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        // return view('category.edit')->with('categories', Category::all($id));

        return view('category.create')->with('category', $category);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = request()->all();
        $category->name = $data['name'];
        $category->save();
        session()->flash('success', 'category updated successfully');
        return redirect(route('category.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->posts->count() > 0)
        {
            session()->flash('error', 'category is attached to a post ');
            return redirect()->back();
        }
        $category->delete();
        session()->flash('success', 'category deleted successfully');
        return redirect('/category');

    }
}
