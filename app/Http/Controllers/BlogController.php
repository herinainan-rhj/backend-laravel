<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    // Ajouter un article
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'date_publication' => 'required|date',
        ]);

        $image = $request->file('image')->store('blogs', 'public');


        $blog = Blog::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'image' => $image,
            'date_publication' => $request->date_publication,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Article publié.',
            'data' => $blog
        ], 201);
    }


    // Récupérer tous les articles
    public function index()
    {
        $blogs = Blog::latest()->get()->map(function ($blog) {

            $blog->image_url = asset('storage/'.$blog->image);

            return $blog;
        });

        return response()->json([
            'success' => true,
            'data' => $blogs
        ]);
    }


    // Récupérer un article
    public function show($id)
    {
        $blog = Blog::findOrFail($id);

        $blog->image_url = asset('storage/'.$blog->image);

        return response()->json([
            'success' => true,
            'data' => $blog
        ]);
    }
    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'date_publication' => 'required|date',
        ]);

        if ($request->hasFile('image')) {

            $image = $request->file('image')
                ->store('blogs', 'public');

            $blog->image = $image;
        }

        $blog->titre = $request->titre;
        $blog->description = $request->description;
        $blog->date_publication = $request->date_publication;

        $blog->save();

        return response()->json([
            'success' => true,
            'message' => 'Article modifié.',
            'data' => $blog
        ]);
    }


    // Supprimer un article
    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);

        $blog->delete();

        return response()->json([
            'success' => true,
            'message' => 'Article supprimé.'
        ]);
    }
}
