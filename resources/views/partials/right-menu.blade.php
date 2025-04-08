<div class="left-menu">
    <!-- Search Section -->
    <div class="menu-section">
        <h3>Rechercher</h3>
        <form action="/" method="GET" class="search-form">
        <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id_cat }}" {{ request('category') == $category->id_cat ? 'selected' : '' }}>
                        {{ $category->name_cat }}
                    </option>
                @endforeach
            </select>
            <div class="form-group mb-3">
                <label for="keyword" class="form-label">Mot-clé</label>
                <input type="text" id="keyword" name="keyword" class="form-control" value="{{ request('keyword') }}">
            </div>
            <div class="form-group mb-3">
                <label for="date_min" class="form-label">Date minimale</label>
                <input type="date" id="date_min" name="date_min" class="form-control" value="{{ request('date_min') }}">
            </div>
            <div class="form-group mb-3">
                <label for="date_max" class="form-label">Date maximale</label>
                <input type="date" id="date_max" name="date_max" class="form-control" value="{{ request('date_max') }}">
            </div>
            <button type="submit" class="btn btn-primary w-100">Rechercher</button>
        </form>
    </div>

    <!-- Customization Section -->
    <div class="menu-section">
        <h3>Personnalisation</h3>
        <form action="{{ url('/customize') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label for="background_color" class="form-label">Couleur de fond</label>
                <select id="background_color" name="background_color" class="form-select">
                    <option value="white" {{ session('background_color') == 'white' ? 'selected' : '' }}>Blanc</option>
                    <option value="lightgray" {{ session('background_color') == 'lightgray' ? 'selected' : '' }}>Gris clair</option>
                    <option value="lightyellow" {{ session('background_color') == 'lightyellow' ? 'selected' : '' }}>Jaune pâle</option>
                    <option value="lightgreen" {{ session('background_color') == 'lightgreen' ? 'selected' : '' }}>Vert clair</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="border_style" class="form-label">Bordure</label>
                <select id="border_style" name="border_style" class="form-select">
                    <option value="none" {{ session('border_style') == 'none' ? 'selected' : '' }}>Aucune</option>
                    <option value="thin" {{ session('border_style') == 'thin' ? 'selected' : '' }}>Fine</option>
                    <option value="thick" {{ session('border_style') == 'thick' ? 'selected' : '' }}>Épaisse</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="font_style" class="form-label">Police de caractères</label>
                <select id="font_style" name="font_style" class="form-select">
                    <option value="Arial" {{ session('font_style') == 'Arial' ? 'selected' : '' }}>Arial</option>
                    <option value="Tahoma" {{ session('font_style') == 'Tahoma' ? 'selected' : '' }}>Tahoma</option>
                    <option value="Verdana" {{ session('font_style') == 'Verdana' ? 'selected' : '' }}>Verdana</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100">Appliquer</button>
        </form>
    </div>

    <!-- Reading Time Section -->
    <div class="menu-section">
        <h3>Temps de lecture</h3>
        <div class="reading-time-dropdown">
            <!-- First 3 visible articles -->
            <div class="reading-time-visible">
                @foreach (($articles ?? [])->take(3) as $article)
                    <div class="reading-time-item">
                        <a href="/article/{{ $article->id_art }}" title="{{ $article->title_art }}">
                            <span class="article-title">{{ $article->title_art }}</span>
                            <span class="reading-time">{{ $article->readtime_art }} min</span>
                        </a>
                    </div>
                @endforeach
            </div>

            <!-- Show more button -->
            @if(($articles ?? [])->count() > 3)
                <button class="show-more-btn" onclick="toggleReadingTime()">
                    Voir plus <i class="fas fa-chevron-down"></i>
                </button>
            @endif

            <!-- Hidden articles -->
            <div class="reading-time-hidden" id="hiddenArticles">
                @foreach (($articles ?? [])->slice(3) as $article)
                    <div class="reading-time-item">
                        <a href="/article/{{ $article->id_art }}" title="{{ $article->title_art }}">
                            <span class="article-title">{{ $article->title_art }}</span>
                            <span class="reading-time">{{ $article->readtime_art }} min</span>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --navbar-height: 60px;
    --menu-width: 20%;
}

.left-menu {
    position: sticky;
    top: var(--navbar-height, 60px);
    height: calc(100vh - var(--navbar-height, 60px));
    width: var(--menu-width, 20%);
    min-width: 250px;
    background-color: {{ session('background_color', 'white') }};
    border-right: 1px solid rgba(0, 0, 0, 0.1);
    padding: 1rem;
    overflow-y: auto;
    flex-shrink: 0;
}

.menu-section {
    margin-bottom: 1.5rem;
    padding: 1rem;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    backdrop-filter: blur(5px);
}

.menu-section h3 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    color: #333;
    border-bottom: 2px solid #e9ecef;
    padding-bottom: 8px;
}

.search-form .form-control,
.search-form .form-select {
    font-size: 0.9rem;
}

/* Reading Time Styles */
.reading-time-dropdown {
    position: relative;
}

.reading-time-item {
    padding: 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.reading-time-item:hover {
    background-color: rgba(0, 0, 0, 0.03);
}

.reading-time-item:last-child {
    border-bottom: none;
}

.reading-time-item a {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    text-decoration: none;
    color: #333;
    font-size: 0.9rem;
    padding: 8px;
    gap: 10px;
}

.article-title {
    flex: 1;
    line-height: 1.3;
    word-wrap: break-word;
}

.reading-time {
    flex-shrink: 0;
    white-space: nowrap;
    color: #666;
}

.reading-time-hidden {
    display: none;
    background-color: rgba(255, 255, 255, 0.5);
    border-radius: 0 0 8px 8px;
    margin-top: 5px;
}

.show-more-btn {
    width: 100%;
    padding: 8px;
    margin-top: 5px;
    background-color: transparent;
    border: 1px solid rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.show-more-btn:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .left-menu {
        position: relative;
        width: 100%;
        height: auto;
        top: 0;
    }
}
</style>

<script>
function toggleReadingTime() {
    const hiddenArticles = document.getElementById('hiddenArticles');
    const button = document.querySelector('.show-more-btn');
    
    if (hiddenArticles.style.display === 'none' || !hiddenArticles.style.display) {
        hiddenArticles.style.display = 'block';
        button.innerHTML = 'Voir moins <i class="fas fa-chevron-up"></i>';
    } else {
        hiddenArticles.style.display = 'none';
        button.innerHTML = 'Voir plus <i class="fas fa-chevron-down"></i>';
    }
}
</script>