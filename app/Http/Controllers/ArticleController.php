<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;



class ArticleController extends Controller
{
 
 //affiche moi le symbole pour ouvrir commencer un commentaire sur plusieurs lignes
    /*
   public function index(Request $request)
    {
        // Start with a base query
        $query = Article::query();

        // Handle category filter
        if ($request->filled('category')) {
            // If a specific category is selected
            $query->where('fk_category_art', $request->category);
        } else {
            // Default to "On n'est pas des pigeons" category
            $category = \App\Models\Category::where('name_cat', "On n'est pas des pigeons")->first();
            if ($category) {
                $query->where('fk_category_art', $category->id_cat);
            }
        }
        // Handle existing keyword search
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function($q) use ($keyword) {
                $q->where('title_art', 'like', '%' . $keyword . '%')
                  ->orWhere('hook_art', 'like', '%' . $keyword . '%')
                  ->orWhere('content_art', 'like', '%' . $keyword . '%');
            });
        }

        // Handle existing date filters
        if ($request->filled('date_min')) {
            $query->where('date_art', '>=', $request->date_min);
        }

        if ($request->filled('date_max')) {
            $query->where('date_art', '<=', $request->date_max);
        }

        // Get the filtered articles
        $articles = $query->orderBy('date_art', 'desc')
                         ->take(10)
                         ->get();

        // Load the category relationship for each article
        $articles->load('category');

        return view('index', compact('articles'));
    }

    */
    //
 

    public function show($id)
    {
        $article = Article::findOrFail($id);
        $article->load('category');

        return response()->json($article);
    }
     // Ajouter un article aux favoris
     public function addFavorite($id)
     {
         // Récupérer les favoris depuis le cookie (si le cookie existe)
         $favorites = json_decode(Cookie::get('favorites', '[]'), true);
 
         // Ajouter l'article aux favoris si ce n'est pas déjà dans la liste
         if (!in_array($id, $favorites)) {
             $favorites[] = $id;
         }
 
         // Enregistrer les favoris dans le cookie (avec une durée de 30 jours)
         Cookie::queue('favorites', json_encode($favorites), 43200); // 43200 minutes = 30 jours
 
         return back(); // Rediriger vers la page précédente
     }
     public function showFavorites(Request $request)
{
    // Récupérer les IDs des articles favoris à partir des cookies
    $favorites = json_decode($request->cookie('favorites'), true) ?? [];

    // Si aucun favori, afficher un tableau vide
    if (empty($favorites)) {
        $favoriteArticles = [];
    } else {
        // Récupérer les articles à partir des IDs favoris
        $favoriteArticles = Article::whereIn('id_art', $favorites)->get();
    }

    return view('favorites', compact('favoriteArticles'));
}


 // Retirer un article des favoris
 public function removeFavorite($id, Request $request)
 {
     $favorites = json_decode($request->cookie('favorites'), true) ?? [];

     // Retirer l'article des favoris
     if (($key = array_search($id, $favorites)) !== false) {
         unset($favorites[$key]);
     }

     // Mettre à jour les cookies
     Cookie::queue('favorites', json_encode(array_values($favorites)), 60 * 24 * 30); // Expire dans 30 jours

     return redirect('/favorites');
 }

 public function customize(Request $request)
{
    // Valider les entrées de l'utilisateur
    $validated = $request->validate([
        'background_color' => 'required|string',
        'border_style' => 'required|string',
        'font_style' => 'required|string',
    ]);

    // Stocker les options dans la session
    session([
        'background_color' => $validated['background_color'],
        'border_style' => $validated['border_style'],
        'font_style' => $validated['font_style'],
    ]);


    return redirect()->back();
}

public function index(Request $request)
{
    // Start with a base query
    $query = Article::query();

    // Handle category filter
    if ($request->filled('category')) {
        // If a specific category is selected
        $query->where('fk_category_art', $request->category);
    } else {
        // Default to "On n'est pas des pigeons" category
        $category = \App\Models\Category::where('name_cat', "On n'est pas des pigeons")->first();
        if ($category) {
            $query->where('fk_category_art', $category->id_cat);
        }
    }
    // Handle existing keyword search
    if ($request->filled('keyword')) {
        $keyword = $request->keyword;
        $query->where(function($q) use ($keyword) {
            $q->where('title_art', 'like', '%' . $keyword . '%')
              ->orWhere('hook_art', 'like', '%' . $keyword . '%')
              ->orWhere('content_art', 'like', '%' . $keyword . '%');
        });
    }

    // Handle existing date filters
    if ($request->filled('date_min')) {
        $query->where('date_art', '>=', $request->date_min);
    }

    if ($request->filled('date_max')) {
        $query->where('date_art', '<=', $request->date_max);
    }

    // Get the filtered articles
    $articles = $query->orderBy('date_art', 'desc')
                     ->take(10)
                     ->get();

    // Load the category relationship for each article
    $articles->load('category');

    // Return JSON response
    return response()->json($articles);
}
}
