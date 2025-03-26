<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // Affiche la page de connexion
    public function index()
    {
        return view('login');
    }

    // Gère la connexion de l'utilisateur
    public function loginAction(Request $request)
    {
        $identifier = $request->input('identifier'); // Récupère le login
        $password = $request->input('password'); // Récupère le mot de passe

        // Vérification : Login ou mot de passe manquant
        if (!$identifier || !$password) {
            return redirect()->route('login')->with(
                'login_error',
                'Veuillez entrer un identifiant et un mot de passe.'
            );
        }

        // Validation avec le modèle
        [$valid, $id, $role] = $this->validateLogin($identifier, $password);

        if ($valid) {
            // Si l'utilisateur est valide, on stocke ses données dans la session
            session([
                'user' => [
                    'id' => $id,
                    'role' => $role,
                ],
            ]);
            return redirect()->route('login')->with('login_success', 'Connexion réussie.');
        } else {
            // Identifiants invalides
            return redirect()->route('login')->with('login_error', 'Identifiant ou mot de passe incorrect.');
        }
    }

    // Gère la déconnexion
    public function logout()
    {
        session()->forget('user'); // Supprime les données utilisateur de la session
        return redirect()->route('login')->with('logout_success', 'Vous êtes déconnecté.');
    }

    // Valide l'identifiant et le mot de passe via le fichier CSV
    private function validateLogin($identifier, $password)
    {
        $filePath = public_path('assets/csv/login.csv'); // Chemin vers le fichier CSV
        
        if (!file_exists($filePath)) {
            throw new \Exception("Le fichier login.csv est introuvable.");
        }

        // Ouverture du fichier CSV
        $fh = fopen($filePath, 'r');
        while (!feof($fh)) {
            $ligne = fgets($fh);
            $user_info = explode(';', trim($ligne)); // Séparation des colonnes
            
            // Vérifie l'identifiant et le mot de passe
            if ($user_info[0] === $identifier && $user_info[1] === $password) {
                fclose($fh);
                // Retourne [valide, identifiant, rôle]
                return [true, $user_info[0], $user_info[2] ?? 'Utilisateur'];
            }
        }
        fclose($fh);

        // Si aucun utilisateur valide n'est trouvé
        return [false, null, null];
    }
}
