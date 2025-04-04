<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;



class ArticleController extends Controller
{
    //
    public function index(Request $request)
    {
        // Nom de la catégorie à filtrer
        $categoryName = "On n'est pas des pigeons"; 

        // Récupérer la catégorie "On n'est pas des pigeons"
        $category = \App\Models\Category::where('name_cat', $categoryName)->first();

        if (!$category) {
            dd("La catégorie 'On n'est pas des pigeons' n'existe pas.");
        }

         // Récupérer les paramètres de recherche
        $keyword = $request->input('keyword');
        // Récupération des paramètres de date
        $dateMin = $request->input('date_min');
        $dateMax = $request->input('date_max');

        // Construction de la requête
        $query = Article::where('fk_category_art', $category->id_cat);
    // Ajouter une condition pour la recherche par mot-clé dans le titre, l'accroche ou le contenu
    if ($keyword) {
        $query->where(function($q) use ($keyword) {
            $q->where('title_art', 'like', '%' . $keyword . '%')
              ->orWhere('hook_art', 'like', '%' . $keyword . '%')
              ->orWhere('content_art', 'like', '%' . $keyword . '%');
        });
    }

        // Filtrer par date si nécessaire
        if ($dateMin) {
            $query->where('date_art', '>=', $dateMin);
        }

        if ($dateMax) {
            $query->where('date_art', '<=', $dateMax);
        }

        // Récupérer les articles triés par date et limités à 10 résultats
        $articles = $query->orderBy('date_art', 'desc')->take(10)->get();

        // Charger la catégorie pour chaque article
        foreach ($articles as $article) {
            $article->load('category');  
        }

        return view('index', compact('articles'));
    }
    public function show($id)
    {
        // Récupérer l'article à partir de son ID
        $article = Article::findOrFail($id);  // Utilise findOrFail pour gérer les erreurs si l'article n'est pas trouvé
        
        // Charger la catégorie associée à l'article
        $article->load('category');

        return view('show', compact('article'));
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
}
