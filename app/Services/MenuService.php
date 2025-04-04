<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class MenuService
{
    public function getMenu()
    {
        $path = public_path('assets/csv/menu.csv');
        $menu = [];
        
        if (!File::exists($path)) {
            \Log::error("Le fichier CSV n'existe pas : " . $path);
            return $menu;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            $parts = explode('|', $line);
            if (count($parts) >= 2) {
                $menu[] = [
                    'text' => trim($parts[0]),
                    'link' => trim($parts[1]),
                ];
            }
        }
      
        return $menu;
    }
} 