<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use App\Services\MenuService;

class StaticContentController extends Controller
{
    public function about()
    {
        $path = public_path('assets/static_content/about.html');
    
        if (File::exists($path)) {
            // Get the HTML content
            $content = File::get($path);
            
            // Get menu from MenuService
            $menuService = app(MenuService::class);
            $menu = $menuService->getMenu();
            
            // Generate menu HTML
            $menuHtml = '<nav class="navbar"><ul class="navbar-list">';
            foreach ($menu as $item) {
                $menuHtml .= sprintf(
                    '<li><a href="%s">%s</a></li>',
                    $item['link'],
                    $item['text']
                );
            }
            $menuHtml .= '</ul></nav>';
            
            // Replace the existing nav section with our dynamic menu
            $content = preg_replace(
                '/<nav class="navbar">.*?<\/nav>/s',
                $menuHtml,
                $content
            );
            
            return response($content)->header('Content-Type', 'text/html');
        }
    
        abort(404, "La page 'À propos' n'a pas été trouvée.");
    }
    

}
