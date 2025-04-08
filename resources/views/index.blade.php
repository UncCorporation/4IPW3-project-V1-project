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
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .main-wrapper {
            display: flex;
            min-height: calc(100vh - var(--navbar-height, 60px));
            margin-top: var(--navbar-height, 60px);
            gap: 0;
        }

        .container {
            flex: 1;
            padding: 2rem;
            width: calc(80% - 250px); /* Subtract menu width from available space */
            max-width: 1000px; /* Limit maximum width */
            margin: 0 auto; /* Center the container */
            margin-left: 250px; /* Account for menu width */
        }

        .list-group {
            max-width: 800px; /* Limit width of article cards */
            margin: 0 auto; /* Center article cards */
        }

        .list-group-item {
            border: {{ session('border_style', 'none') }} solid black;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 1.5rem;
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
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column;
            }

            .container {
                width: 100%;
                margin-left: 0;
                padding: 1rem;
            }

            .list-group {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    @include('navbar')
    <div class="main-wrapper">
        @include('partials.right-menu')
        <div class="container">
            <h1 class="text-center mb-5">Articles de la catégorie "On n'est pas des pigeons"</h1>

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
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
