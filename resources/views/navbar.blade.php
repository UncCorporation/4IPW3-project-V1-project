
<nav class="navbar">
    <ul class="navbar-list">
        @if(isset($menu) && count($menu) > 0)
            @foreach ($menu as $item)
                <li>
                    <a href="{{ $item['link'] }}">{{ $item['text'] }}</a>
                </li>
            @endforeach
        @endif
        
        <!-- User greeting section -->
        <li>
            <div class="d-flex align-items-center">
                @if(session('user'))
                    <span class="me-3 text-light">Bonjour, {{ session('user')['id'] }} !</span>
                @else
                    <span class="me-3 text-light">Utilisateur non identifié !</span>
                @endif
            </div>
        </li>
    </ul>
</nav>

<style>
    .dropdown-menu {
        background-color: #444; /* Couleur de fond */
        color: white; /* Couleur du texte */
        list-style: none;
        padding: 10px 0;
        margin: 0;
        border-radius: 5px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Ombre pour le style */
    }

    .dropdown-menu li {
        padding: 0;
    }

    .dropdown-menu li a {
        color: white; /* Couleur du texte */
        text-decoration: none;
        padding: 10px 15px;
        display: block;
        transition: background-color 0.3s;
    }

    .dropdown-menu li a:hover {
        background-color: #575757; /* Couleur au survol */
        border-radius: 5px;
    }

    .navbar {
        background-color: #333;
        padding: 10px;
    }

    .navbar-list {
        list-style: none;
        display: flex;
        justify-content: space-around;
        margin: 0;
        padding: 0;
    }

    .navbar-list li {
        display: inline;
        margin-right: 20px; /* Reduced margin for better spacing */
    }

    .navbar-list a {
        color: white;
        text-decoration: none;
        padding: 10px 15px;
        transition: background-color 0.3s;
    }

    .navbar-list a:hover {
        background-color: #575757;
        border-radius: 5px;
    }
</style>