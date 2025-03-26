<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\File;
class StaticContentController extends Controller
{
    public function about()
    {
        $path = public_path('assets/static_content/about.html'); // Chemin complet vers le fichier
    
        if (\Illuminate\Support\Facades\File::exists($path)) {
            return response()->file($path, [
                'Content-Type' => 'text/html', // Spécifie le type MIME pour les fichiers HTML
            ]);
        }
    
        // Si le fichier n'existe pas, retourne une erreur 404
        abort(404, "La page 'À propos' n'a pas été trouvée.");
    }
    
}
