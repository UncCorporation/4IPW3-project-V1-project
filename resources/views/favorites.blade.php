<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
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
            max-height: 300px;
            object-fit: cover;
        }
    </style>
</head>
<body><!-- Barre de navigation -->
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
        


        <!-- Titre principal -->
        <h1>Mes Articles Favoris</h1>

        <!-- Compteur de favoris -->
        <p class="text-center"><strong>Nombre total d'articles favoris :</strong> {{ count($favoriteArticles) }}</p>

        @if(empty($favoriteArticles))
            <p class="text-center">Aucun article favori pour le moment.</p>
        @else
            <!-- Tableau des favoris -->
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Titre</th>
                        <th scope="col">Auteur</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($favoriteArticles as $article)
                        <tr>
                            <td>{{ $article->title_art }}</td>
                            <td>{{ $article->author }}</td>
                            <td>{{ \Carbon\Carbon::parse($article->date_art)->format('d/m/Y') }}</td>
                            <td>
                                <!-- Retirer des favoris -->
                                <form action="{{ url('/article/' . $article->id_art . '/remove_favorite') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Retirer des favoris</button>
                                </form>
                                <!-- Lire l'article -->
                                <a href="{{ url('/article/' . $article->id_art) }}" class="btn btn-primary btn-sm">Lire l'article</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

        <!-- Retour aux articles -->
        <a href="{{ url('/') }}" class="btn btn-secondary">Retour à la liste des articles</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
