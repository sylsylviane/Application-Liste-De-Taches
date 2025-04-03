<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Méthode pour afficher le formulaire de création d'une catégorie
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Méthode pour stocker une nouvelle catégorie
     */
    public function store(Request $request)
    {
       $request->validate([
        'category_en' => 'required|max:30',
        'category_fr' => 'max:30'
       ]);

       $category = [
        'en' => $request->category_en, 
       ];

       if($request->category_fr!=null) {$category = $category + ['fr' =>$request->category_fr];}

       Category::create([
        'category' => $category
       ]);

       return back()->withSuccess('Category created successfully!');

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
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
