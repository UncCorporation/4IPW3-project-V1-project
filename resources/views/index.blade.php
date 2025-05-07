<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Articles</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    console.log("✅ JavaScript is running!");
</script>
</head>
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

            <!-- Search Form -->
            <form class="search-form mb-4">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control" placeholder="Rechercher un article...">
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </div>
            </form>

            <!-- Articles List -->
            <div class="list-group">
                <!-- Articles will be loaded here via AJAX -->
            </div>

            <!-- Article Details -->
            <div id="article-details" class="mt-5">
                <!-- Article details will be displayed here -->
            </div>
        </div>
    </div>

    

    <script>
    $(document).ready(function() {
        console.log("✅ JavaScript is running!");
        
        // Load default articles on page load
        loadArticles();

        // Handle search form submission
        $('.search-form').on('submit', function(event) {
            event.preventDefault();
            var formData = $(this).serialize();
            
            $.ajax({
                url: '/articles',
                type: 'GET',
                data: formData,
                dataType: 'json',
                success: function(data) {
                    console.log("Search results:", data);
                    renderArticles(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching articles:', error);
                    var articlesContainer = $('.list-group');
                    articlesContainer.empty();
                    articlesContainer.append('<p>Une erreur est survenue lors de la récupération des articles. Veuillez réessayer plus tard.</p>');
                }
            });
        });

        // Handle click event for reading an article
        $(document).on('click', '.read-article', function(event) {
            event.preventDefault();
            var articleId = $(this).data('id');
            
            console.log("Fetching article with ID:", articleId);
            
            $.ajax({
                url: `/article/${articleId}`,
                type: 'GET',
                dataType: 'json',
                success: function(article) {
                    console.log("Article details:", article);
                    var articleDetailsContainer = $('#article-details');
                    articleDetailsContainer.html(`
                        <h2>${article.title_art}</h2>
                        <p><strong>Auteur :</strong> ${article.author || 'Inconnu'}</p>
                        <p><strong>Date :</strong> ${article.date_art ? new Date(article.date_art).toLocaleDateString() : 'Date inconnue'}</p>
                        <p>${article.content_art || 'Contenu non disponible'}</p>
                    `);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching article details:', error);
                    $('#article-details').html('<p>Impossible de charger les détails de l\'article. Veuillez réessayer plus tard.</p>');
                }
            });
        });

        // Function to load default articles
        function loadArticles() {
            console.log("Loading default articles...");
            
            $.ajax({
                url: '/articles',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    console.log("Default articles loaded:", data);
                    renderArticles(data);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching default articles:', error);
                    $('.list-group').html('<p>Une erreur est survenue lors du chargement des articles. Veuillez réessayer plus tard.</p>');
                }
            });
        }

        // Function to render articles
        function renderArticles(data) {
            console.log("Rendering articles:", data);
            var articlesContainer = $('.list-group');
            articlesContainer.empty();

            if (!data || data.length === 0) {
                articlesContainer.append('<p>Aucun article trouvé.</p>');
                return;
            }

            $.each(data, function(index, article) {
                var title = article.title_art || 'Titre non disponible';
                var author = article.author || 'Auteur inconnu';
                var date = article.date_art ? new Date(article.date_art).toLocaleDateString() : 'Date non disponible';
                var hook = article.hook_art || 'Aperçu non disponible';
                var articleId = article.id_art || '#';

                var articleElement = $('<div class="list-group-item"></div>');
                articleElement.html(`
                    <h3>${title}</h3>
                    <p><strong>Auteur :</strong> ${author}</p>
                    <p><strong>Date :</strong> ${date}</p>
                    <p>${hook}</p>
                    <a href="#" class="btn btn-primary read-article" data-id="${articleId}">Lire l'article</a>
                `);

                articlesContainer.append(articleElement);
            });
        }
    });
    </script>
</body>
</html>
