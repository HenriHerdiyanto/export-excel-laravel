<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $categories = Category::all();
        return view("admin.categori", compact("categories", "user"));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            "user_id" => "required",
            "nama" => "required",
        ]);
        $category = new Category();
        $category->user_id = $validate['user_id'];
        $category->nama = $validate['nama'];
        $category->save();
        return redirect()->back()->with("success", "ok");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required',
            'nama' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        $category->user_id = $request->user_id;
        $category->nama = $request->nama;
        $category->save();

        return redirect()->back()->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('success', 'ok');
    }
}
