<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Article</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: {{ session('background_color', 'white') }};
            font-family: {{ session('font_style', 'Arial') }};
        }

        .list-group-item {
            border: {{ session('border_style', 'none') }} solid black;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #343a40;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-warning {
            color: #fff;
            background-color: #ffc107;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e0a800;
        }

        img {
            max-height: 600px;
            object-fit: cover;
        }
    </style>
</head>
<body>
         <!-- Inclure le menu -->
         @include('navbar')
         
<!-- Menu déroulant pour la personnalisation -->
<div class="dropdown mt-2 d-flex justify-content-end"> <!-- mt-4 ajoute un espace en haut -->
    <button class="btn btn-secondary dropdown-toggle" type="button" id="customizationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Personnalisation
    </button>
    <ul class="dropdown-menu">
        <li>
            <form action="{{ url('/customize') }}" method="POST" class="p-3">
                @csrf
                <div class="mb-3">
                    <label for="background_color" class="form-label">Couleur de fond</label>
                    <select id="background_color" name="background_color" class="form-select form-select-sm">
                        <option value="white" {{ session('background_color') == 'white' ? 'selected' : '' }}>Blanc</option>
                        <option value="lightgray" {{ session('background_color') == 'lightgray' ? 'selected' : '' }}>Gris clair</option>
                        <option value="lightyellow" {{ session('background_color') == 'lightyellow' ? 'selected' : '' }}>Jaune pâle</option>
                        <option value="lightgreen" {{ session('background_color') == 'lightgreen' ? 'selected' : '' }}>Vert clair</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="border_style" class="form-label">Bordure</label>
                    <select id="border_style" name="border_style" class="form-select form-select-sm">
                        <option value="none" {{ session('border_style') == 'none' ? 'selected' : '' }}>Aucune</option>
                        <option value="thin" {{ session('border_style') == 'thin' ? 'selected' : '' }}>Fine</option>
                        <option value="thick" {{ session('border_style') == 'thick' ? 'selected' : '' }}>Épaisse</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="font_style" class="form-label">Police de caractères</label>
                    <select id="font_style" name="font_style" class="form-select form-select-sm">
                        <option value="Arial" {{ session('font_style') == 'Arial' ? 'selected' : '' }}>Arial</option>
                        <option value="Tahoma" {{ session('font_style') == 'Tahoma' ? 'selected' : '' }}>Tahoma</option>
                        <option value="Verdana" {{ session('font_style') == 'Verdana' ? 'selected' : '' }}>Verdana</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Appliquer</button>
            </form>
        </li>
    </ul>
</div>
    <div class="container mt-5">
            <!-- Boutons d'action -->
            <div class="mt-3">
             
                
                <!-- Gestion des favoris -->
                @php
                $favorites = json_decode(request()->cookie('favorites'), true) ?? [];
                @endphp
    
                @if(in_array($article->id_art, $favorites))
                <button type="button" class="btn btn-warning" disabled>Déjà ajouté aux favoris</button>
                @else
                <form action="{{ url('/article/' . $article->id_art . '/favorite') }}" method="POST" class="mt-2 d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">Ajouter aux favoris</button>
                </form>
                @endif
            </div>

        <!-- Contenu principal -->
        <h1>{{ $article->title_art }}</h1>

        <!-- Affichage de l'image -->
        @if($article->image_art)
        <div class="mb-4">
            <img src="{{ asset('images/media_article/' . $article->image_art) }}" alt="Image de l'article" class="img-fluid w-100 rounded">
        </div>
        @endif

        <!-- Informations principales -->
        <p><strong>Auteur :</strong> {{ $article->author }}</p>
        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($article->date_art)->format('d/m/Y') }}</p>
        <p><strong>Catégorie :</strong> {{ $article->category->name_cat }}</p>

        <!-- Contenu de l'article -->
        <div class="mt-4">
            <p>{!! $article->content_art !!}</p>
        </div>

    
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
