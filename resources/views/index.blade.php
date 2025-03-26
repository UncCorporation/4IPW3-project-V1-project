<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Articles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: {{ session('background_color', 'white') }};
            font-family: {{ session('font_style', 'Arial') }};
        }

        .list-group-item {
            border: {{ session('border_style', 'none') }} solid black;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .list-group-item h3 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .list-group-item img {
            border-radius: 8px;
            max-height: 200px;
            object-fit: cover;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-warning {
            color: #212529;
        }

        .form-select, .form-control {
            font-size: 0.9rem;
        }
        
    </style>
</head>
<body>
    <!-- Inclure le menu -->
@include('navbar')

  






<!-- Menu déroulant pour la personnalisation -->
<div class="dropdown mt-2 d-flex justify-content-end"> <!-- mt-4 ajoute un espace en haut -->
    <a href="#" class="  dropdown-toggle btn btn-secondary " data-bs-toggle="dropdown">Temps de lecture</a>
    <ul class="dropdown-menu">
        @foreach ($articles as $article)
            <li>
                <a href="/article/{{ $article->id_art }}">
                    {{ $article->title_art }} : {{ $article->readtime_art }} minutes
                </a>
            </li>
        @endforeach
    </ul>
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
     

        <h1 class="text-center mb-5">Articles de la catégorie "On n'est pas des pigeons"</h1>

    



        <!-- Formulaire de recherche -->
        <div class="container mb-4">
            <h2 class="h4 mb-3">Rechercher des articles</h2>
            <form action="/" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="keyword" class="form-label">Mot-clé</label>
                    <input type="text" id="keyword" name="keyword" class="form-control" value="{{ request('keyword') }}">
                </div>
                <div class="col-md-4">
                    <label for="date_min" class="form-label">Date minimale</label>
                    <input type="date" id="date_min" name="date_min" class="form-control" value="{{ request('date_min') }}">
                </div>
                <div class="col-md-4">
                    <label for="date_max" class="form-label">Date maximale</label>
                    <input type="date" id="date_max" name="date_max" class="form-control" value="{{ request('date_max') }}">
                </div>
                <div class="col-md-4 align-self-end">
                    <button type="submit" class="btn btn-primary">Rechercher</button>
                </div>
            </form>
        </div>

        <!-- Bouton vers les favoris -->
        <div class="text-end mb-4">
            <a href="{{ url('/favorites') }}" class="btn btn-success">Voir mes favoris</a>
        </div>

        <!-- Liste des articles -->
        @if($articles->isEmpty())
            <p>Aucun article trouvé.</p>
        @else
            <div class="list-group">
                @foreach($articles as $article)
                    <div class="list-group-item">
                        <h3>{{ $article->title_art }}</h3>
                        @if(!empty($article->image_art))
                            <div class="mb-3">
                                <img src="{{ asset('images/media_article/' . $article->image_art) }}" alt="Image de l'article" class="img-fluid">
                            </div>
                        @endif
                        <p><strong>Auteur :</strong> {{ $article->author }}</p>
                        <p><strong>Date :</strong> {{ \Carbon\Carbon::parse($article->date_art)->format('d/m/Y') }}</p>
                        <p>{{ Str::limit($article->hook_art, 150) }}</p>
                        <a href="/article/{{ $article->id_art }}" class="btn btn-primary">Lire l'article</a>
                        @php
                            $favorites = json_decode(request()->cookie('favorites'), true) ?? [];
                        @endphp
                        @if(in_array($article->id_art, $favorites))
                            <button type="button" class="btn btn-warning" disabled>Déjà ajouté aux favoris</button>
                        @else
                            <form action="{{ url('/article/' . $article->id_art . '/favorite') }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="btn btn-warning">Ajouter aux favoris</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
