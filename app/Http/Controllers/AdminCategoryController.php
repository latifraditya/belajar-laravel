<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.categories.index', [
          'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.categories.create', [
          'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'name' => 'required|max:255',
          'slug' => 'required|unique:categories',
      ]);
      Category::create($validatedData);
      return redirect('/dashboard/categories')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
      
      $validatedData = $request->validate([
        'id' => 'required|exists:categories,id', // Pastikan ID valid
        'name' => 'required|max:255'
    ]);

    // Cari kategori berdasarkan ID
    $category = Category::find($request->id);
    if (!$category) {
        return response()->json(['error' => 'Kategori tidak ditemukan'], 404);
    }

    // Update nama kategori
    $category->name = $validatedData['name'];
    $category->save();

    return response()->json(['success' => 'Kategori berhasil diperbarui', 'data' => $category]);
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        // dd('kategori ditemukan',$category);
        Category::destroy($category->id);
        return redirect('/dashboard/categories')->with('success','Category has been deleted');
    }
}
