<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
       body {
            background-color: {{ session('background_color', 'white') }};
            font-family: {{ session('font_style', 'Arial') }};
        }

        .login-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .login-container h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .alert {
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #565e64;
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

            <!-- Contenu principal -->
            <div class="content">
                @yield('content')
            </div>
    <div class="login-container">
        <h1>Connexion</h1>

        <!-- Messages de session -->
        @if (session('login_error'))
            <div class="alert alert-danger">{{ session('login_error') }}</div>
        @endif

        @if (session('login_success'))
            <div class="alert alert-success">{{ session('login_success') }}</div>
        @endif

        @if (session('logout_success'))
            <div class="alert alert-info">{{ session('logout_success') }}</div>
        @endif

        @if (!session('user'))
            <!-- Formulaire de connexion -->
            <form method="POST" action="{{ route('login.action') }}">
                @csrf
                <div class="mb-3">
                    <label for="identifier" class="form-label">Identifiant</label>
                    <input type="text" id="identifier" name="identifier" class="form-control" required placeholder="Votre identifiant">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe</label>
                    <input type="password" id="password" name="password" class="form-control" required placeholder="Votre mot de passe">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Se connecter</button>
                </div>
            </form>
        @else
            <!-- Message utilisateur connecté -->
            <p class="text-center mt-3">Bonjour, <strong>{{ session('user.id') }}</strong> (<em>{{ session('user.role') }}</em>)</p>
            <form method="POST" action="{{ route('logout') }}" class="d-grid mt-3">
                @csrf
                <button type="submit" class="btn btn-secondary">Se déconnecter</button>
            </form>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
