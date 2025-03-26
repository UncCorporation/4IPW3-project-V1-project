<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class SponsorController extends Controller
{
    public function showBanner()
    {
        // URL de l'API
        $url = 'http://playground.burotix.be/adv/banner_for_isfce.json';

        // Tenter de récupérer les données JSON
        $response = Http::get($url);

        // Vérifier si la requête a réussi
        if ($response->successful()) {
            // Extraire les données nécessaires
            $banner = $response->json()['banner_4IPDW'];
        } else {
            // Si erreur, définir la bannière comme null
            $banner = null;
        }

        // Retourner la vue avec les données de la bannière
        return view('sponsor', compact('banner'));
    }
}
